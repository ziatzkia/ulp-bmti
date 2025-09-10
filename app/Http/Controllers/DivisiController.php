<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Permohonan;
use Illuminate\Http\Request;

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

    public function penempatanAction(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $divisi = Divisi::find($request->divisi_id);
        if ($divisi->jumlah_magang >= $divisi->kebutuhan_magang) {
            return redirect()->route('divisi.penempatan')->with('error', 'Divisi sudah mencapai batas kebutuhan magang.');
        }

        $divisi->jumlah_magang += 1;
        $divisi->save();

        $permohonan->divisi_id = $request->divisi_id;
        $permohonan->status = 'PENDING_LETTER';
        $permohonan->save();

        return redirect()->route('divisi.penempatan')->with('success', 'Peserta magang berhasil ditempatkan di divisi.');
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
