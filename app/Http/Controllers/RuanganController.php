<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Pinjem;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('ruangan.index', compact('ruangan'));
    }

    public function show($kodeRuangan)
    {
        $ruangan = Ruangan::where('kode_ruangan', $kodeRuangan)
            ->firstOrFail();
        
        return view('ruangan.show', compact('ruangan'));
    }

    public function getRoomSchedule($roomId)
    {
        $userId = auth()->id();

        $events = \App\Models\Pinjem::where('id_ruangan', $roomId)
            ->where(function($q) use ($userId) {
                $q->where('status', '!=', 'ditolak')
                  ->orWhere(function($q2) use ($userId) {
                      $q2->where('status', 'ditolak')
                         ->where('user_id', $userId);
                  });
            })
            ->with(['user:id,name'])
            ->get()
            ->map(function($booking) {
                $color = match($booking->status) {
                    'pending' => '#D2B48C',
                    'disetujui' => 'rgb (46, 175, 184)',
                    'ditolak' => '#FF0000',
                    default => '#FFFFFF'
                };
                return [
                    'title' => 'Peminjaman ' . $booking->ruangan->nama . ' - ' . $booking->jurusan,
                    'start' => $booking->mulai,
                    'end' => $booking->selesai,
                    'color' => $color,
                    'nama_peminjam' => $booking->user->name,
                    'status' => $booking->status,
                ];
            })->values()->all();

        return response()->json($events);
    }
}