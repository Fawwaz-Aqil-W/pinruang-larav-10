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
                'kode_ruangan' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'gedung' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gambar_url' => 'nullable|string|max:512', 
                'fasilitas' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Manual check kode_ruangan
            if (Ruangan::where('kode_ruangan', $request->kode_ruangan)->exists()) {
                return response()->json([
                    'message' => 'Kode ruangan sudah digunakan, silakan pilih yang lain.'
                ], 422);
            }

            if (!$request->hasFile('gambar') && !$request->filled('gambar_url')) {
                return response()->json([
                    'message' => 'Gambar atau URL gambar harus diisi.'
                ], 422);
            }

            $data = $validator->validated();

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('ruangan', 'public');
                $data['gambar_url'] = null;
            } elseif ($request->filled('gambar_url')) {
                $data['gambar'] = null;
                $data['gambar_url'] = $request->input('gambar_url');
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
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'gedung' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_url' => 'nullable|url',
            'fasilitas' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'kode_ruangan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.ruangan.edit', $ruangan->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Manual check kode_ruangan, ignore current id
        if (Ruangan::where('kode_ruangan', $request->kode_ruangan)
            ->where('id', '!=', $ruangan->id)
            ->exists()) {
            return redirect()
                ->route('admin.ruangan.edit', $ruangan->id)
                ->with('error', 'Kode ruangan sudah digunakan, silakan pilih yang lain.')
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('gambar')) {
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

        return redirect()->route('admin.ruangan.index')->with('success', 'Ruangan berhasil diperbarui');
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