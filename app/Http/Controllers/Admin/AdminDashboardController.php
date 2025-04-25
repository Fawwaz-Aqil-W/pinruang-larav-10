<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pinjem;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_ruangan' => Ruangan::count(),
            'total_user' => User::count(),
            'total_peminjaman' => Pinjem::count(),
            'recent_peminjaman' => Pinjem::with(['user', 'ruangan'])
                                      ->latest()
                                      ->take(10)
                                      ->get(),
            'calendar_events' => Pinjem::with(['ruangan', 'user'])
                                     ->get()
                                     ->map(function($pinjam) {
                                         return [
                                             'title' => "Peminjaman {$pinjam->ruangan->nama} - {$pinjam->jurusan}",
                                             'start' => $pinjam->mulai,
                                             'end' => $pinjam->selesai,
                                             'color' => $this->getStatusColor($pinjam->status),
                                             'nim' => $pinjam->user->nim ?? '-',
                                             'nama_peminjam' => $pinjam->user->name ?? '-',
                                             'alasan' => $pinjam->alasan ?? '-',
                                             'status' => $pinjam->status,
                                         ];
                                     })
        ];

        return view('admin.dashboard', $data);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'pending' => '#ffc107',
            'disetujui' => '#28a745',
            'ditolak' => '#dc3545',
            default => '#3788d8'
        };
    }
}