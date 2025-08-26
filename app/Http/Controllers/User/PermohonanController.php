<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    public function index()
    {
        $permohonans = Permohonan::orderBy('created_at', 'desc')->get();
        return view('user.permohonan', compact('permohonans'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = $request->status ?? 'draft';

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:pdf|max:2048'
            ]);
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/permohonan', $filename);
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
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/permohonan', $filename);
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
}
