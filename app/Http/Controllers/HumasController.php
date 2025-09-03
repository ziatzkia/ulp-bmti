<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class HumasController extends Controller
{
    public function validasiIndex()
    {
        $permohonans = Permohonan::where('status', 'SUBMITTED')->get();
        return view('humas.validasi_surat', compact('permohonans'));
    }

    public function validasiAction(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',    
            'feedback' => 'required_if:action,reject|string|max:500',
        ]);

        if ($request->action === 'accept') {
            $permohonan->status = 'APPROVED_ADMINISTRATION';
            $message = 'Permohonan berhasil diterima untuk verifikasi.';
        } else {
            $permohonan->status = 'REJECTED';
            $permohonan->feedback = $request->feedback;
            $message = 'Permohonan berhasil ditolak.';
        }

        $permohonan->save();

        return redirect()->route('humas.validasi.index')->with('success', $message);
    }

    public function unduhanIndex()
    {
        // Status 'APPROVED_ADMINISTRATION' sudah benar, siap diteruskan
        $permohonans = Permohonan::where('status', 'APPROVED_ADMINISTRATION')->get();
        return view('humas.unduhan', compact('permohonans'));
    }

    public function unduhanAction(Request $request, Permohonan $permohonan)
    {
        // Mengubah status agar bisa dilihat oleh Divisi
        $permohonan->status = 'DIVISION_REVIEW';
        $permohonan->save();

        return redirect()->route('unduhan')->with('success', 'Permohonan berhasil diteruskan ke Divisi.');
    }

    public function balasanIndex()
    {
        // Status 'PENDING_LETTER' sudah benar, menunggu upload surat balasan
        $permohonans = Permohonan::where('status', 'PENDING_LETTER')->get();
        return view('humas.balasan', compact('permohonans'));
    }

public function balasanAction(Request $request, Permohonan $permohonan)
{
    $request->validate([
        'surat_balasan' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($request->hasFile('surat_balasan')) {
        $filePath = $request->file('surat_balasan')->store('surat_balasan', 'public');

        $permohonan->status = 'ACCEPTED'; 
        $permohonan->surat_balasan = $filePath;

        $permohonan->save();

        return redirect()->route('balasan')->with('success', 'Surat balasan berhasil diupload.');
    }

    return back()->with('error', 'Gagal mengupload file.');
}
}