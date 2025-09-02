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

    /**
     * Aksi validasi permohonan (diterima atau ditolak).
     */
    public function validasiAction(Request $request, Permohonan $permohonan)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
            'feedback' => 'nullable|string|max:500',
        ]);

        if ($request->action === 'accept') {
            $permohonan->status = 'APPROVED_ADMINISTRATION';
        } else {
            $permohonan->status = 'REJECTED';
            $permohonan->feedback = $request->feedback;
        }

        $permohonan->save();

        return redirect()->route('humas.validasi.index')->with('success', 'Permohonan berhasil divalidasi.');
    }

    public function unduhanIndex()
    {
        $permohonans = Permohonan::where('status', 'APPROVED_ADMINISTRATION')->get();
        return view('humas.unduhan', compact('permohonans'));
    }

    public function unduhanAction(Request $request, Permohonan $permohonan)
    {
        $permohonan->status = 'DIVISION_REVIEW';

        $permohonan->save();

        return redirect()->route('unduhan')->with('success', 'Permohonan berhasil divalidasi.');
    }

    public function balasanIndex()
    {
        $permohonans = Permohonan::where('status', 'PENDING_LETTER')->get();
        return view('humas.balasan', compact('permohonans'));
    }

    public function balasanAction(Request $request, Permohonan $permohonan)
    {
        $permohonan->status = 'ACCEPTED';

        $permohonan->save();

        return redirect()->route('balasan')->with('success', 'Permohonan berhasil divalidasi.');
    }
}
