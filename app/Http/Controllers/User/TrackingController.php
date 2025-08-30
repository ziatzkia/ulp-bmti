<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()
    {
        $permohonan = Permohonan::where('user_id', Auth::id())->first();
        return view('user.tracking', compact('permohonan'));
    }


    public function show(Permohonan $permohonan)
    {
        if ($permohonan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.tracking_detail', compact('permohonan'));
    }
}
