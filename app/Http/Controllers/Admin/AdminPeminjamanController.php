<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjem;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = \App\Models\Pinjem::with(['user', 'ruangan'])->orderBy('created_at', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjaman'));
    }
    public function cancel($id)
    {
        try {
            $peminjaman = \App\Models\Pinjem::findOrFail($id);
    
            // Ubah status ke pending
            $peminjaman->update([
                'status' => 'pending',
                'disetujui_pada' => null,
                'disetujui_oleh' => null,
                'ditolak_pada' => null,
                'ditolak_oleh' => null,
                'alasan_ditolak' => null,
            ]);
    
            return response()->json([
                'message' => 'Status peminjaman berhasil dibatalkan ke pending'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    public function approve($id)
    {
        try {
            $peminjaman = Pinjem::findOrFail($id);
            
            if ($peminjaman->status !== 'pending') {
                return response()->json([
                    'message' => 'Peminjaman sudah diproses'
                ], 422);
            }

            $peminjaman->update([
                'status' => 'disetujui',
                'disetujui_pada' => now(),
                'disetujui_oleh' => auth()->id()
            ]);

            return response()->json([
                'message' => 'Peminjaman berhasil disetujui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function reject(Request $request, $id)
    {
        try {
            $peminjaman = Pinjem::findOrFail($id);
            
            if ($peminjaman->status !== 'pending') {
                return response()->json([
                    'message' => 'Peminjaman sudah diproses'
                ], 422);
            }

            $peminjaman->update([
                'status' => 'ditolak',
                'ditolak_pada' => now(),
                'ditolak_oleh' => auth()->id(),
                'alasan_ditolak' => $request->input('reason')
            ]);

            return response()->json([
                'message' => 'Peminjaman berhasil ditolak'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}