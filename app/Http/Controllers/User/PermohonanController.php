<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Notifications\PermohonanAcceptedNotification;
use App\Notifications\PermohonanRejectedNotification;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::where('user_id', Auth::id())->first();
        return view('user.permohonan', compact('permohonan'));
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = $request->status ?? 'DRAFT';

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:pdf|max:2048'
            ]);
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('permohonan', $filename, 'public');
            $data['image'] = $filename;
        }

        Permohonan::create($data);
        return redirect()->route('permohonan.index')->with('success', 'Permohonan tersimpan!');
    }

    public function edit(Permohonan $permohonan)
    {
        return response()->json($permohonan);
    }

    public function update(Request $request, Permohonan $permohonan)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:pdf|max:2048'
            ]);
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('permohonan', $filename, 'public');
            $data['image'] = $filename;
        }

        $permohonan->update($data);
        return redirect()->route('permohonan.index')->with('success', 'Permohonan diperbarui!');
    }

    public function destroy(Permohonan $permohonan)
    {
        $permohonan->delete();
        return redirect()->route('permohonan.index')->with('success', 'Permohonan dihapus!');
    }

     public function acc($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->status = 'ACCEPTED';
        $permohonan->save();

        // kirim notifikasi ke email user terkait
        if ($permohonan->user) {
            $permohonan->user->notify(new PermohonanAcceptedNotification($permohonan));
        }

        return back()->with('success', 'Permohonan berhasil diterima.');
    }
    
}
