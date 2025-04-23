<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjem extends Model
{
    use HasFactory;

    protected $table = 'peminjaman'; // Specify table name

    protected $fillable = [
        'user_id',
        'id_ruangan',
        'jurusan',
        'mulai',
        'selesai',
        'alasan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }
}
