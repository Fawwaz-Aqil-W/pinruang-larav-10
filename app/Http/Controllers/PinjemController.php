<?php

namespace App\Http\Controllers;

use App\Models\Pinjem;
use App\Models\Ruangan;
use Illuminate\Http\Request;

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
}