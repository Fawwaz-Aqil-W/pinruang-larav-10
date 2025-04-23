<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $ruangan = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function show($roomCode)
    {
        $room = Room::where('room_code', $roomCode)->firstOrFail();
        return view('rooms.show', compact('room'));
    }
}