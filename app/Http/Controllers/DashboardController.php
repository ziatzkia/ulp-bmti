<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Divisi;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'TOTAL' => Permohonan::count(),
            'PROCESS' => Permohonan::whereIn('status', [
                'SUBMITTED', 
                'APPROVED_ADMINISTRATION', 
                'DIVISION_REVIEW', 
                'PENDING_LETTER'
            ])->count(),
            'ACCEPTED' => Permohonan::where('status', 'ACCEPTED')->count(),
            'REJECTED' => Permohonan::where('status', 'REJECTED')->count(),
        ];

        $recentPermohonans = Permohonan::with('divisi')
                                       ->latest()
                                       ->take(7)
                                       ->get();

        $statusCounts = Permohonan::select('status', DB::raw('count(*) as total'))
                                    ->groupBy('status')
                                    ->pluck('total', 'status');
        
        $divisiChartData = Divisi::select('nama_divisi', 'kebutuhan_magang', 'jumlah_magang')->get();

        return view('dashboard', compact(
            'stats',
            'recentPermohonans',
            'statusCounts',
            'divisiChartData' // Kirim data divisi yang baru
        ));
        
    }
}