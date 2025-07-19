@extends('layouts.app')

@section('title', 'Proses Pembayaran')

@section('content')
<div class="container mt-5 text-center">
    <h3>Memproses Pembayaran...</h3>
    <div class="alert alert-info mt-3">
        Snap Token: <strong>{{ $snapToken }}</strong>
    </div>
    <button id="pay-button" class="btn btn-primary mt-3">Bayar Sekarang</button>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM loaded, initializing Snap...");

        const payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            console.log("Pay button clicked");
            console.log("Calling snap.pay with token: {{ $snapToken }}");

            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log("Payment Success", result);
                    alert("Pembayaran sukses!");
                },
                onPending: function(result) {
                    console.log("Payment Pending", result);
                    alert("Pembayaran sedang diproses.");
                },
                onError: function(result) {
                    console.error("Payment Error", result);
                    alert("Pembayaran gagal!");
                },
                onClose: function() {
                    alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                }
            });
        });
    });
</script>
@endpush
