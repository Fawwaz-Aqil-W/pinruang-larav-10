<?php

namespace App\Http\Controllers;

use App\Models\Pinjem;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PinjemController extends Controller
{
    public function create()
    {
        $ruangan = Ruangan::all();
        return view('pinjem.create', compact('ruangan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_ruangan' => 'required',
            'jurusan' => 'required',
            'mulai' => 'required|date',
            'selesai' => 'required|date|after:mulai',
            'alasan' => 'required|string'
        ]);

        // Check if room is already approved for the requested time
        $approvedBooking = Pinjem::where('id_ruangan', $validated['id_ruangan'])
            ->where('status', 'disetujui')
            ->where(function($query) use ($validated) {
                $query->whereBetween('mulai', [$validated['mulai'], $validated['selesai']])
                    ->orWhereBetween('selesai', [$validated['mulai'], $validated['selesai']])
                    ->orWhere(function($q) use ($validated) {
                        $q->where('mulai', '<=', $validated['mulai'])
                          ->where('selesai', '>=', $validated['selesai']);
                    });
            })->exists();

        if ($approvedBooking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ruangan sudah dibooking dan disetujui untuk waktu tersebut'
            ], 422);
        }

        $peminjaman = Pinjem::create([
            'user_id' => auth()->id(),
            'id_ruangan' => $validated['id_ruangan'],
            'jurusan' => $validated['jurusan'],
            'mulai' => $validated['mulai'],
            'selesai' => $validated['selesai'],
            'alasan' => $validated['alasan'],
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Peminjaman berhasil diajukan',
            'peminjaman' => $peminjaman
        ]);
    }

    public function status()
    {
        $peminjaman = Pinjem::where('user_id', auth()->id())
                           ->with('ruangan')
                           ->orderBy('created_at', 'desc')
                           ->get();
        
        return view('pinjem.status', compact('peminjaman'));
    }

    public function destroy($id)
    {
        $pinjem = Pinjem::findOrFail($id);
        
        if ($pinjem->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus peminjaman ini');
        }

        if ($pinjem->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman dengan status pending yang dapat dihapus');
        }

        $pinjem->delete();
        return back()->with('success', 'Peminjaman berhasil dihapus');
    }

    public function getRoomSchedule($roomId)
    {
        $bookings = Pinjem::where('id_ruangan', $roomId)
            ->whereIn('status', ['pending', 'disetujui', 'ditolak'])
            ->get()
            ->map(function($booking) {
                $color = match($booking->status) {
                    'pending' => '#D2B48C', // brown
                    'disetujui' => '#0000FF', // blue
                    'ditolak' => '#FF0000', // red
                    default => '#FFFFFF' // white
                };

                return [
                    'title' => $booking->user->name . ' - ' . $booking->jurusan,
                    'start' => $booking->mulai,
                    'end' => $booking->selesai,
                    'color' => $color,
                    'status' => $booking->status
                ];
            });

        return response()->json($bookings);
    }
}