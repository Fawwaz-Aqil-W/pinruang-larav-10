<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminRuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangan'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'gedung' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
                'gambar' => 'required_without:gambar_url|nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_url' => 'required_without:gambar|nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('ruangan', 'public');
                $data['gambar_url'] = null;
            } elseif ($request->filled('gambar_url')) {
                $data['gambar'] = null;
            }

            Ruangan::create($data);

            return response()->json([
                'message' => 'Ruangan berhasil ditambahkan'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit(Ruangan $ruangan)
    {
        return response()->json($ruangan);
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'gedung' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_url' => 'nullable|url'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('gambar')) {
                // Delete old file if exists
                if ($ruangan->gambar) {
                    Storage::disk('public')->delete($ruangan->gambar);
                }
                $data['gambar'] = $request->file('gambar')->store('ruangan', 'public');
                $data['gambar_url'] = null;
            } elseif ($request->filled('gambar_url')) {
                if ($ruangan->gambar) {
                    Storage::disk('public')->delete($ruangan->gambar);
                }
                $data['gambar'] = null;
            }

            $ruangan->update($data);

            return response()->json([
                'message' => 'Ruangan berhasil diperbarui'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Ruangan $ruangan)
    {
        if ($ruangan->gambar) {
            Storage::disk('public')->delete($ruangan->gambar);
        }
        
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
                        ->with('success', 'Ruangan berhasil dihapus');
    }
}