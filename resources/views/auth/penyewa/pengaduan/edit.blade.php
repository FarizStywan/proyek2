@extends('layouts.app')

@section('content')
<h2>Edit Pengaduan</h2>

<form action="{{ route('penyewa.pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <input type="text" name="kategori" id="kategori" class="form-control" value="{{ old('kategori', $pengaduan->kategori) }}" required>
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Foto (Opsional)</label>
        <input type="file" name="foto" id="foto" class="form-control">
        @if ($pengaduan->foto)
        <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Bukti Foto" width="100" class="rounded shadow mt-2">
        @endif
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select" required>
            <option value="Pending" {{ $pengaduan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="tanggapan" class="form-label">Tanggapan (Opsional)</label>
        <textarea name="tanggapan" id="tanggapan" class="form-control" rows="4">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Pengaduan</button>
    <a href="{{ route('auth.penyewa.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
