@extends('layouts.app')

@section('title', 'Status Peminjaman')

@section('content')
<section class="status-section py-5">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header custom-header">
                <h4>Status Peminjaman</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>ID Peminjaman</th>
                                <th>Nama Ruangan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $pinjem)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pinjem->id }}</td>
                                <td>{{ $pinjem->ruangan->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($pinjem->mulai)->format('d-m-Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pinjem->selesai)->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if($pinjem->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($pinjem->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($pinjem->status == 'pending')
                                        <button class="btn btn-primary btn-sm">Edit</button>
                                        <form action="{{ route('pinjem.destroy', $pinjem->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Edit</button>
                                        <button class="btn btn-danger btn-sm" disabled>Hapus</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection