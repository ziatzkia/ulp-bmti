<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::all();
        return view('humas.dashboard_divisi', compact('divisis'));
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
}
