@extends('layouts.app')

@section('title', 'Bayar Sewa - Sobat Kos')
@section('page-title', 'Bayar Sewa')

@section('content')
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

                    @if($harga_kamar > 0)
                        <button id="pay-button" class="btn btn-primary btn-lg rounded-pill px-5 mt-4">
                            Bayar Sekarang
                        </button>
                    @else
                        <div class="alert alert-warning mt-4">
                            Tidak ada tagihan aktif.
                        </div>
                    @endif

                    <form id="payment-form" style="display: none;">
                        @csrf
                        <input type="hidden" id="tagihan_id" name="tagihan_id" value="{{ $tagihan_id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Load Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<!-- Script Bayar -->
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        // Kirim permintaan ke backend untuk dapatkan snap token
        fetch("{{ route('penyewa.bayar.process') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                tagihan_id: "{{ $tagihan_id }}"
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.snap_token) {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        alert("Pembayaran berhasil!");
                        location.reload();
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran...");
                        location.reload();
                    },
                    onError: function(result){
                        alert("Pembayaran gagal.");
                        console.log(result);
                    },
                    onClose: function(){
                        alert("Popup pembayaran ditutup.");
                    }
                });
            } else {
                alert("Gagal mendapatkan token pembayaran.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat memproses pembayaran.");
        });
    });
</script>

@endsection