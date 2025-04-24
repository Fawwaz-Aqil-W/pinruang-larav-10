<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman Ruangan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .signature { margin-top: 50px; text-align: right; }
        .sign-space { margin-top: 80px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Peminjaman Ruangan</h2>
    <p>Periode: {{ $tanggal ?? 'Semua Periode' }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemohon</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $index => $pinjam)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pinjam->user->name }}</td>
                <td>{{ $pinjam->ruangan->nama }}</td>
                <td>{{ $pinjam->mulai }}</td>
                <td>{{ $pinjam->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature">
        <p>Cilegon, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <div class="sign-space"></div>
        <p>{{ $penanggung_jawab }}</p>
    </div>
</body>
</html>