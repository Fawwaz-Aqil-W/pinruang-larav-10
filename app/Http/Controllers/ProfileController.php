<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function updateFoto(Request $request)
    {
        $request->validate(['foto' => 'image|max:2048']);
        $user = auth()->user();
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto_url = '/storage/' . $path;
            $user->save();
        }
        return back()->with('success', 'Foto profil berhasil diubah');
    }

    public function destroy($id)
    {
        $notif = Notifikasi::where('user_id', auth()->id())->findOrFail($id);
        $notif->delete();
        return back()->with('success', 'Notifikasi dihapus');
    }
}