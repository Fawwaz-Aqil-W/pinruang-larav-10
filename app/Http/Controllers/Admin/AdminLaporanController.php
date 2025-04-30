<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjem;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use PDF;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pinjem::with(['user', 'ruangan']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->tanggal) $query->whereDate('mulai', $request->tanggal);
        if ($request->ruangan) $query->where('id_ruangan', $request->ruangan);

        $peminjaman = $query->orderBy('created_at', 'desc')->get();
        $ruangan = Ruangan::all();

        return view('admin.laporan.index', compact('peminjaman', 'ruangan'));
    }

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
}
