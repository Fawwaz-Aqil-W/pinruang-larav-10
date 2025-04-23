<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('ruangan.index', compact('ruangan'));
    }

    public function show($kodeRuangan)
    {
        $ruangan = Ruangan::where('kode_ruangan', $kodeRuangan)->firstOrFail();
        return view('ruangan.show', compact('ruangan'));
    }
}