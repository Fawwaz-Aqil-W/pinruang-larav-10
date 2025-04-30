<?php

namespace App\Exports;

use App\Models\Pinjem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{   
    public function exportPDF(Request $request)
{
    $query = Pinjem::with(['user', 'ruangan']);
    if ($request->status) $query->where('status', $request->status);
    if ($request->tanggal) $query->whereDate('mulai', $request->tanggal);
    if ($request->ruangan) $query->where('id_ruangan', $request->ruangan);

    $peminjaman = $query->get();

    $tanggalFile = $request->tanggal
        ? \Carbon\Carbon::parse($request->tanggal)->translatedFormat('d-F-Y')
        : now()->translatedFormat('d-F-Y');
    $tanggalFile = str_replace(' ', '-', $tanggalFile);

    $pdf = \PDF::loadView('admin.laporan.pdf', [
        'peminjaman' => $peminjaman,
        'tanggal' => $request->tanggal,
        'penanggung_jawab' => auth()->user()->name
    ]);

    return $pdf->download('laporan-peminjaman-' . $tanggalFile . '.pdf');
}

public function exportExcel(Request $request)
{
    $tanggalFile = $request->tanggal
        ? \Carbon\Carbon::parse($request->tanggal)->translatedFormat('d-F-Y')
        : now()->translatedFormat('d-F-Y');
    $tanggalFile = str_replace(' ', '-', $tanggalFile);

    return \Excel::download(
        new \App\Exports\PeminjamanExport($request->status, $request->tanggal, $request->ruangan),
        'laporan-peminjaman-' . $tanggalFile . '.xlsx'
    );
}

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
            'Alasan Peminjaman',
            'Tanggal',
            'Status',
            'ACC/Ditolak Oleh',
            'Waktu ACC/Ditolak',
            'Keterangan'
        ];
    }

    public function map($peminjaman): array
    {
        static $i = 1;
        $tanggal = \Carbon\Carbon::parse($peminjaman->mulai)->translatedFormat('d F Y H:i') .
            ' - ' . \Carbon\Carbon::parse($peminjaman->selesai)->translatedFormat('H:i');
        // Ambil nama admin
        $admin = null;
        if ($peminjaman->status == 'disetujui' && $peminjaman->disetujui_oleh) {
            $adminUser = \App\Models\User::find($peminjaman->disetujui_oleh);
            $admin = $adminUser ? $adminUser->name : '-';
        } elseif ($peminjaman->status == 'ditolak' && $peminjaman->ditolak_oleh) {
            $adminUser = \App\Models\User::find($peminjaman->ditolak_oleh);
            $admin = $adminUser ? $adminUser->name : '-';
        } else {
            $admin = '-';
        }
        $accWaktu = $peminjaman->status == 'disetujui'
            ? ($peminjaman->disetujui_pada ? \Carbon\Carbon::parse($peminjaman->disetujui_pada)->translatedFormat('d F Y H:i') : '-')
            : ($peminjaman->status == 'ditolak' ? ($peminjaman->ditolak_pada ? \Carbon\Carbon::parse($peminjaman->ditolak_pada)->translatedFormat('d F Y H:i') : '-') : '-');
        return [
            $i++,
            $peminjaman->user->name,
            $peminjaman->ruangan->nama,
            $peminjaman->alasan,
            $tanggal,
            $peminjaman->status,
            $admin,
            $accWaktu,
            $peminjaman->alasan_ditolak ?? '-'
        ];
    }
}