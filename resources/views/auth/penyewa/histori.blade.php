@extends('layouts.app')

@section('title', 'Histori Pembayaran')

@section('content')
<div class="container mt-5">
    <h3>Histori Pembayaran</h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Jumlah</th>
                <th>Jenis Pembayaran</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->order_id }}</td>
                    <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $item->payment_type ?? '-' }}</td>
                    <td>
                        @if ($item->status == 'settlement')
                            <span class="badge bg-success">Lunas</span>
                        @elseif ($item->status == 'pending')
                            <span class="badge bg-warning text-dark">Menunggu</span>
                        @else
                            <span class="badge bg-danger">Gagal</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
