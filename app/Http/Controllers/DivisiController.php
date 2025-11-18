<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Notifications\PermohonanRejectedNotification;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::all();
        return view('humas.dashboard_divisi', compact('divisis'));
    }

    public function userDashboard()
    {
        $divisis = Divisi::all();
        return view('user.dashboard', compact('divisis'));
    }


    public function kuota()
    {
        $divisis = Divisi::all();
        return view('divisi.kuota_magang', compact('divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi'       => 'required|string|max:255',
            'kebutuhan_magang'  => 'nullable|integer',
            'jumlah_magang'     => 'nullable|integer',
        ]);

        Divisi::create($request->only(['nama_divisi', 'kebutuhan_magang', 'jumlah_magang']));

        return redirect()->route('divisis.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    public function updateKebutuhan(Request $request, $id)
    {
        $request->validate([
            'kebutuhan_magang' => 'required|integer|min:1',
        ]);

        $divisi = Divisi::findOrFail($id);
        $divisi->kebutuhan_magang = $request->kebutuhan_magang;
        $divisi->save();

        return redirect()->route('kuota')->with('success', 'Kebutuhan peserta magang berhasil diperbarui.');
    }

    public function penempatanIndex()
    {
        $divisis = Divisi::all();
        $permohonans = Permohonan::where('status', 'DIVISION_REVIEW')->paginate(7);
        return view('divisi.penempatan_divisi', compact('permohonans', 'divisis'));
    }

    public function processPlace(Request $request, $id)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $permohonan = Permohonan::findOrFail($id);
        $divisi = Divisi::findOrFail($request->divisi_id);

        // Cek Kuota
        if ($divisi->jumlah_magang >= $divisi->kebutuhan_magang) {
            return back()->with('error', 'Gagal! Divisi ' . $divisi->nama_divisi . ' sudah penuh.');
        }

        $divisi->increment('jumlah_magang');

        $permohonan->update([
            'divisi_id' => $request->divisi_id,
            'status'    => 'PENDING_LETTER',
            'feedback'  => null,
        ]);

        return back()->with('success', 'Peserta berhasil ditempatkan di ' . $divisi->nama_divisi);
    }

    public function processReject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:1000',
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $permohonan = Permohonan::findOrFail($id);

        $permohonan->update([
            'status'    => 'REJECTED',
            'divisi_id' => null,
            'feedback'  => $request->alasan,
        ]);

        $permohonan->user->notify(new PermohonanRejectedNotification($permohonan));

        return back()->with('success', 'Peserta berhasil ditolak.');
    }

    public function edit(Divisi $divisi)
    {
        return view('divisis.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $validated = $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $divisi->id,
        ]);

        $divisi->update($validated);

        return redirect()->route('divisis.index')
            ->with('success', 'Data divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();
        return redirect()->route('divisis.index')
            ->with('success', 'Divisi berhasil dihapus.');
    }
}
