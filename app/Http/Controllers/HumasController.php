<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;

class HumasController extends Controller
{
    public function validasiIndex()
    {
        $permohonans = Permohonan::where('jenjang', 2)->get(); // step 2 = Operator Surat (Validasi)
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
            // lanjut ke jenjang berikutnya (3 = Humas)
            $permohonan->jenjang = 3;
            // $permohonan->status = 'proses';
            // $permohonan->feedback = null;
        } else {
            // kirim balik ke user
            $permohonan->jenjang = 1;
            // $permohonan->status = 'revisi';
            // $permohonan->feedback = $request->feedback;
        }

        $permohonan->save();

        return redirect()->route('humas.validasi.index')->with('success', 'Permohonan berhasil divalidasi.');
    }
}
