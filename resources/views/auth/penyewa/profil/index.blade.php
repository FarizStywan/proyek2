@extends('layouts.app')

@section('content')
<h2>Profil Penyewa</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Nama: {{ $user->nama }}</h5>
        <p class="card-text">Email: {{ $user->email }}</p>

        <a href="{{ route('auth.penyewa.profil.edit') }}" class="btn btn-warning">Edit Profil</a>
    </div>
</div>

@endsection
