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
    $cacheKey = "room_schedule_{$roomId}";

    $events = Cache::remember($cacheKey, now()->addMinutes(5), function() use ($roomId) {
        return \App\Models\Pinjem::where('id_ruangan', $roomId)
            ->whereIn('status', ['pending', 'disetujui', 'ditolak'])
            ->with(['user:id,name'])
            ->get()
            ->map(function($booking) {
                $color = match($booking->status) {
                    'pending' => '#D2B48C',
                    'disetujui' =>'rgb(46, 175, 184)',
                    'ditolak' => '#FF0000',
                    default => '#FFFFFF'
                };
                return [
                    'title' => "{$booking->status} - {$booking->user->name} - {$booking->jurusan}",
                    'start' => $booking->mulai,
                    'end' => $booking->selesai,
                    'color' => $color,
                    'status' => $booking->status
                ];
            })->values()->all(); // pastikan array, bukan collection
    });

    return response()->json($events); // pastikan response JSON
    }
}