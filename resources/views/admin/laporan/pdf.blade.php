<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #222; padding: 4px; }
        th { background: #eee; }
        .logo-wrapper { text-align: center; margin-bottom: 10px; }
        .logo { height: 90px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Peminjaman Ruangan</h2>
    <p style="margin-top: 20px">periode {{$tanggal ?? 'Semua Periode'}} </p>
    <div class="logo-wrapper">
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>Ruangan</th>
                <th>Alasan Peminjaman</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>ACC/Ditolak Oleh</th>
                <th>Waktu ACC/Ditolak</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $index => $pinjam)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pinjam->user->name }}</td>
                <td>{{ $pinjam->ruangan->nama }}</td>
                <td>{{ $pinjam->alasan }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($pinjam->mulai)->translatedFormat('d F Y H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($pinjam->selesai)->translatedFormat('H:i') }}
                </td>
                <td>{{ $pinjam->status }}</td>
                <td>
                    @php
                        $admin = null;
                        if ($pinjam->status == 'disetujui' && $pinjam->disetujui_oleh) {
                            $admin = \App\Models\User::find($pinjam->disetujui_oleh);
                        } elseif ($pinjam->status == 'ditolak' && $pinjam->ditolak_oleh) {
                            $admin = \App\Models\User::find($pinjam->ditolak_oleh);
                        }
                    @endphp
                    {{ $admin ? $admin->name : '-' }}
                </td>
                <td>
                    @if($pinjam->status == 'disetujui')
                        {{ $pinjam->disetujui_pada ? \Carbon\Carbon::parse($pinjam->disetujui_pada)->translatedFormat('d F Y H:i') : '-' }}
                    @elseif($pinjam->status == 'ditolak')
                        {{ $pinjam->ditolak_pada ? \Carbon\Carbon::parse($pinjam->ditolak_pada)->translatedFormat('d F Y H:i') : '-' }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $pinjam->alasan_ditolak ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature" style="margin-top:40px; text-align:right;">
        <p>Cilegon, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <div style="height:60px;"></div>
        <p>{{ $penanggung_jawab }}</p>
    </div>
</body>
</html>
