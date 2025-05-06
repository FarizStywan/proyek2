@extends('layouts.app')

@section('content')
<h2>Detail Pengaduan</h2>

<div class="mb-3">
    <strong>Kategori:</strong> {{ $pengaduan->kategori }}<br>
    <strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}<br>
    <strong>Status:</strong> {{ $pengaduan->status }}<br>
    <strong>Tanggal:</strong> {{ $pengaduan->created_at->format('d M Y H:i') }}
</div>

@if($pengaduan->foto)
<div class="mb-3">
    <strong>Foto Bukti:</strong><br>
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" width="300">
</div>
@endif

@if($pengaduan->tanggapan)
<div class="alert alert-info">
    <strong>Tanggapan Admin:</strong><br>
    {{ $pengaduan->tanggapan }}
</div>
@endif

<a href="{{ route('auth.penyewa.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
@endsection
