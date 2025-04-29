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
public function getGedungSchedule($gedung, Request $request)
{
    $start = $request->query('start');
    $end = $request->query('end');
    $userId = auth()->id();

    $ruangan = \App\Models\Ruangan::where('gedung', $gedung)->pluck('id');

    $events = \App\Models\Pinjem::whereIn('id_ruangan', $ruangan)
        ->where(function($q) use ($start, $end) {
            $q->whereBetween('mulai', [$start, $end])
              ->orWhereBetween('selesai', [$start, $end]);
        })
        ->with(['ruangan', 'user'])
        ->get()
        // Filter: hanya tampilkan yang bukan ditolak, atau ditolak tapi milik user sendiri
        ->filter(function($pinjam) use ($userId) {
            return $pinjam->status != 'ditolak' || $pinjam->user_id == $userId;
        })
        ->map(function($pinjam) {
            return [
                'title' => $pinjam->ruangan->nama . ' - ' . ($pinjam->jurusan ?? ($pinjam->user->jurusan ?? '-')),
                'start' => $pinjam->mulai,
                'end' => $pinjam->selesai,
                'status' => $pinjam->status,
                'backgroundColor' => $pinjam->status == 'disetujui' ? '#198754' : ($pinjam->status == 'pending' ? '#ffc107' : '#dc3545'),
                'borderColor' => '#fff',
            ];
        })
        ->values();

    return response()->json($events);
}
}