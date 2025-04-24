<?php

namespace App\Exports;

use App\Models\Pinjem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $status, $tanggal, $ruangan;

    public function __construct($status = null, $tanggal = null, $ruangan = null)
    {
        $this->status = $status;
        $this->tanggal = $tanggal;
        $this->ruangan = $ruangan;
    }

    public function collection()
    {
        $query = Pinjem::with(['user', 'ruangan']);

        if ($this->status) {
            $query->where('status', $this->status);
        }
        if ($this->tanggal) {
            $query->whereDate('mulai', $this->tanggal);
        }
        if ($this->ruangan) {
            $query->where('id_ruangan', $this->ruangan);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pemohon',
            'Ruangan',
            'Tanggal',
            'Status',
            'Keterangan'
        ];
    }

    public function map($peminjaman): array
    {
        static $i = 1;
        return [
            $i++,
            $peminjaman->user->name,
            $peminjaman->ruangan->nama,
            $peminjaman->mulai,
            $peminjaman->status,
            $peminjaman->alasan_ditolak ?? '-'
        ];
    }
}