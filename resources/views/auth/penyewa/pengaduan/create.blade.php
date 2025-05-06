@extends('layouts.app')

@section('content')
<h2>Buat Pengaduan Baru</h2>

<form method="POST" action="{{ route('auth.penyewa.pengaduan.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select name="kategori" id="kategori" class="form-select" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($kategoriList as $kategori)
                <option value="{{ $kategori }}">{{ $kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Foto (Opsional)</label>
        <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
    </div>

    <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
    <a href="{{ route('auth.penyewa.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
