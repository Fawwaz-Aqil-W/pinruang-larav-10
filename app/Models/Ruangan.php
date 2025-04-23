<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan'; // Specify table name

    protected $fillable = [
        'kode_ruangan',
        'nama',
        'gedung',
        'kapasitas',
        'gambar_url'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Pinjem::class, 'id_ruangan');
    }
}
