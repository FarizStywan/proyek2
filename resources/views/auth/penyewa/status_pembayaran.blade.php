@extends('layouts.app')

@section('title', 'Status Pembayaran')

@section('content')
<div class="container mt-5">
    <h3>Status Pembayaran</h3>

    @if ($tagihan)
        <div class="card mt-4">
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $tagihan->order_id }}</p>
                <p><strong>Jumlah:</strong> Rp {{ number_format($tagihan->jumlah, 0, ',', '.') }}</p>
                <p><strong>Jenis Pembayaran:</strong> {{ $tagihan->payment_type ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    @if ($tagihan->status == 'settlement')
                        <span class="badge bg-success">Lunas</span>
                    @elseif ($tagihan->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                    @else
                        <span class="badge bg-danger">Gagal</span>
                    @endif
                </p>
                <p><strong>Waktu:</strong> {{ $tagihan->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('auth.penyewa.histori') }}" class="btn btn-secondary mt-3">Lihat Histori Pembayaran</a>
    @else
        <div class="alert alert-info mt-4">
            Tidak ada pembayaran aktif saat ini.
        </div>
    @endif
</div>
@endsection
