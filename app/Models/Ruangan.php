<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan'; // Specify table name

    protected $fillable = [
        'nama',
        'gedung',
        'kapasitas',
        'gambar',
        'gambar_url'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Pinjem::class, 'id_ruangan');
    }

    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        
        if ($this->gambar_url) {
            return $this->gambar_url;
        }

        return 'https://via.placeholder.com/300x200';
    }
}

