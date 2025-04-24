<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $cacheKey = "room_schedule_{$roomId}";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function() use ($roomId) {
            return Pinjem::where('id_ruangan', $roomId)
                ->select('id', 'mulai as start', 'selesai as end', 'status', 'jurusan')
                ->with(['user:id,name'])
                ->get()
                ->map(function($booking) {
                    $color = match($booking->status) {
                        'pending' => '#D2B48C',
                        'disetujui' => '#0000FF',
                        'ditolak' => '#FF0000',
                        default => '#FFFFFF'
                    };

                    return [
                        'title' => "{$booking->status} - {$booking->user->name} - {$booking->jurusan}",
                        'start' => $booking->start,
                        'end' => $booking->end,
                        'color' => $color,
                        'status' => $booking->status
                    ];
                });
        });
    }
}