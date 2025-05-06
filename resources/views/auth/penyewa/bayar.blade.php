@extends('layouts.app')

@section('title', 'Bayar Sewa - Sobat Kos')
@section('page-title', 'Bayar Sewa')

@section('content')
<!-- Main Content -->
<div class="container-fluid px-4">

    <!-- Header Section -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card text-white rounded-bottom shadow" style="background-color: #0C4E6C;">
                <div class="card-body">
                    <h4 class="card-title mb-2">Hallo Penyewa,</h4>
                    <p class="card-text fs-5">Yuk segera bayar tagihan kosmu agar tetap nyaman tinggal!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pembayaran -->
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow-lg border-0 rounded-3 text-center p-5">
                <div class="card-body">
                    <h5 class="card-title text-dark fs-4">Total Tagihan Bulan Ini</h5>
                    <h2 class="text-primary fw-bold fs-1 mt-3">
                        Rp {{ number_format($harga_kamar, 0, ',', '.') }}
                    </h2>
                    <p class="text-muted mt-3 fs-5">Bayar sebelum jatuh tempo untuk menghindari denda keterlambatan.</p>
                    
                    <form action="{{ route('auth.penyewa.bayar') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="tagihan_id" value="{{ $tagihan_id }}">
                        <input type="hidden" name="jumlah" value="{{ $jumlah }}">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">
                            Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
