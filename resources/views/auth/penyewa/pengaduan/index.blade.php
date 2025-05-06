@extends('layouts.app')

@section('content')
<h2>Daftar Pengaduan Saya</h2>

<a href="{{ route('penyewa.pengaduan.create') }}" class="btn btn-primary mb-3">Buat Pengaduan Baru</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Foto</th>
            <th>Status</th>
            <th>Tanggapan</th>
            <th>Dibuat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengaduan as $item)
        <tr>
            <td>{{ $item->kategori }}</td>
            <td>{{ Str::limit($item->deskripsi, 50) }}</td>
            <td>
                @if ($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Bukti Foto" width="80" class="rounded shadow">
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>
                <span class="badge 
                    @if($item->status == 'Pending') bg-warning text-white
                    @elseif($item->status == 'Diproses') bg-primary text-white
                    @elseif($item->status == 'Selesai') bg-success text-white
                    @endif">
                    {{ $item->status }}
                </span>
            </td>
            <td>
                @if ($item->tanggapan)
                    {{ Str::limit($item->tanggapan, 50) }}
                @else
                    <span class="text-muted">Belum ada</span>
                @endif
            </td>
            <td>{{ $item->created_at->format('d M Y') }}</td>
            <td class="d-flex gap-1">
                <a href="{{ route('auth.penyewa.pengaduan.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                <a href="{{ route('penyewa.pengaduan.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('penyewa.pengaduan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
