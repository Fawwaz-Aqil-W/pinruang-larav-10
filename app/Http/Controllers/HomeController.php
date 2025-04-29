<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;  

class HomeController extends Controller
{
    public function index()
    {
        $gedungs = Ruangan::select('gedung')->distinct()->pluck('gedung');
        $roomsByGedung = Ruangan::all()->groupBy('gedung')->map(function($items) {
            return $items->map(function($r) {
                return ['id' => $r->id, 'nama' => $r->nama];
            });
        });
        return view('home', [
            'gedungs' => $gedungs,
            'roomsByGedung' => $roomsByGedung,
        ]);
    }
}