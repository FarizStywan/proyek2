@extends('layouts.app')

@section('title', 'Dashboard Penyewa - Sobat Kos')
@section('page-title', 'Dashboard Penyewa')

@section('content')
<!-- Main Content -->
<div class="container-fluid px-4">
    
    <!-- Header Section -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card text-white rounded-bottom shadow" style="background-color: #0C4E6C;">
                <div class="card-body">
                    <h4 class="card-title mb-2">Hallo Penyewa,</h4>
                    <p class="card-text fs-5">Kelola kosmu dengan mudah dan cek status tagihanmu dengan cepat!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tagihan -->
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <h5 class="card-title text-dark fs-4">Total Tagihan Bulan Ini</h5>
                    <p class="card-text fs-2 fw-bold text-primary">
                        Rp {{ number_format($totalTagihan, 0, ',', '.') }}
                    </p>
                    <p class="text-muted">Berdasarkan harga kamar yang tersedia pada bulan ini</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Fitur Lainnya -->
    <div class="row mt-4">
        <!-- Biaya Sewa -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <h5 class="card-title text-dark fs-4">Biaya Sewa</h5>
                    <a href="{{ route('auth.penyewa.bayar') }}" class="btn btn-primary btn-lg mt-4 rounded-pill">Bayar Sekarang</a>
                </div>
            </div>
        </div>

        <!-- Histori Pembayaran -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <h5 class="card-title text-dark fs-4">Histori Pembayaran</h5>
                    <a href="#" class="btn btn-success btn-lg mt-4 rounded-pill">Lihat Riwayat</a>
                </div>
            </div>
        </div>

        <!-- Pengaduan -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <h5 class="card-title text-dark fs-4">Pengaduan</h5>
                    <a href="#" class="btn btn-warning btn-lg mt-4 rounded-pill text-white">Kirim Pengaduan</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Progres Pembayaran -->
    <div class="row mt-5">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body text-center p-5">
                    <h5 class="card-title text-dark fs-4">Progres Pembayaran</h5>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $paymentProgress }}%;" aria-valuenow="{{ $paymentProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="mt-3 text-muted fs-5">{{ number_format($paymentProgress, 2) }}% Terpenuhi</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
