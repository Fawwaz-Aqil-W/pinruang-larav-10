<?php

namespace Database\Seeders;

use App\Models\Ruangan;
use Illuminate\Database\Seeder;

class RuanganSeeder extends Seeder
{
    public function run(): void
    {
        $ruangan = [
            [
                'kode_ruangan' => 'R001',
                'nama' => 'Aula FT',
                'gedung' => 'FTI',
                'kapasitas' => 40,
                'gambar_url' => 'https://loremflickr.com/320/240/building'
            ],
            [
                'kode_ruangan' => 'R002',
                'nama' => 'Lab Komputer A',
                'gedung' => 'Teknik Informatika',
                'kapasitas' => 25,
                'gambar_url' => 'https://loremflickr.com/320/240/computer'
            ],
            [
                'kode_ruangan' => 'R003',
                'nama' => 'Aula Serbaguna',
                'gedung' => 'Rektorat',
                'kapasitas' => 100,
                'gambar_url' => 'https://loremflickr.com/320/240/hall'
            ],
            [
                'kode_ruangan' => 'R004',
                'nama' => 'Ruang Sidang',
                'gedung' => 'Pascasarjana',
                'kapasitas' => 20,
                'gambar_url' => 'https://loremflickr.com/320/240/meeting'
            ],
            [
                'kode_ruangan' => 'R005',
                'nama' => 'Studio Musik',
                'gedung' => 'Kesenian',
                'kapasitas' => 15,
                'gambar_url' => 'https://loremflickr.com/320/240/music'
            ]
        ];

        foreach ($ruangan as $r) {
            Ruangan::create($r);
        }
    }
}
