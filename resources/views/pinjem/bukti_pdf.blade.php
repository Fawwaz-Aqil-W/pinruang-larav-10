<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Peminjaman Ruangan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .main-table { width: 100%; border-collapse: collapse; border: 1px solid #000; }
        .main-table td, .main-table th { border: 1px solid #000; padding: 6px; vertical-align: top; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { border: none; }
        .logo { width: 60px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .ttd-table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        .ttd-table td { border: 1px solid #000; text-align: center; height: 70px; vertical-align: bottom; }
        .no-border { border: none !important; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td class="center" style="width: 15%;">
                <img src="{{ public_path('logo-univ.png') }}" class="logo">
            </td>
            <td class="center" style="width: 70%;">
                <span class="bold" style="font-size:16px;">Formulir Peminjaman<br>Ruangan FT UNTIRTA</span>
            </td>
            <td class="center" style="width: 15%;">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>
        </tr>
    </table>
    <table class="main-table" style="margin-top:10px;">
        <tr>
            <td style="width:33%;">
                <span class="bold">Kepada :</span><br>
                Bagian TU
            </td>
            <td style="width:33%;">
                <span class="bold">Penyelenggara :</span><br>
                {{ $pinjam->user->jurusan ?? '-' }}
            </td>
            <td style="width:34%;">
                <span class="bold">Identitas Pemohon :</span><br>
                {{ $pinjam->user->name ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>
                <span class="bold">Tanggal Peminjaman :</span><br>
                {{ \Carbon\Carbon::parse($pinjam->mulai)->translatedFormat('j F Y') }}
            </td>
            <td>
                <span class="bold">Waktu Peminjaman :</span><br>
                {{ \Carbon\Carbon::parse($pinjam->mulai)->format('H.i') }} - {{ \Carbon\Carbon::parse($pinjam->selesai)->format('H.i') }} WIB
            </td>
            <td>
                <span class="bold">Tempat :</span><br>
                Ruang-{{ $pinjam->ruangan->nama }} ({{ $pinjam->ruangan->gedung }})
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="bold">Tujuan Peminjaman :</span><br>
                {{ $pinjam->alasan ?? '-' }}
            </td>
        </tr>
    </table>
    <table class="main-table" style="margin-top:0;">
        <tr>
            <th style="width:33%; text-align:center;">Menyetujui<br>Bagian TU</th>
            <th style="width:34%; text-align:center;">Mengetahui,<br>Admin Si Pinjam</th>
            <th style="width:33%; text-align:center;">Tanggal Disetujui</th>
        </tr>
        <tr>
            <td style="height:70px;"></td>
            <td></td>
            <td style="vertical-align:bottom;">
                {{ \Carbon\Carbon::parse($pinjam->updated_at)->translatedFormat('j F Y') }}
            </td>
        </tr>
    </table>
</body>
</html>