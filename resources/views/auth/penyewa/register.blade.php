<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen relative font-sans">

    <!-- Background Lingkaran -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
        <div class="absolute -top-32 -left-60 w-[900px] h-[900px] bg-[#064469] rounded-full opacity-80"></div>
        <div class="absolute -top-24 -left-60 w-[950px] h-[950px] bg-[#5790AB] rounded-full opacity-70"></div>
        <div class="absolute -top-20 -left-60 w-[1000px] h-[1000px] bg-[#064469] rounded-full opacity-60"></div>
    </div>

    <!-- Background Blur Gambar Kos -->
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center bg-no-repeat opacity-70 blur-sm" 
        style="background-image: url('{{ asset('images/kos.jpg') }}');">
    </div>

    <!-- Container Utama -->
    <div class="relative flex items-center justify-between w-10/12 max-w-5xl">

        <!-- Teks di Depan Lingkaran -->
        <div class="text-white font-bold text-5xl tracking-wide leading-snug drop-shadow-lg">
            Daftar Sekarang!
        </div>

        <!-- Kotak Register -->
        <div class="bg-white p-8 rounded-2xl shadow-xl w-96 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Buat Akun Baru</h2>

            <!-- Notifikasi Error -->
            @if ($errors->any())
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penyewa.register.submit') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="nama" placeholder="Nama Lengkap" 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" 
                    required value="{{ old('nama') }}">

                <input type="email" name="email" placeholder="Email" 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" 
                    required value="{{ old('email') }}">

                <input type="text" name="no_hp" placeholder="Nomor HP" 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" 
                    required value="{{ old('no_hp') }}">

                <select name="nomor_kamar" required 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none">
                    <option disabled selected value="">Pilih Nomor Kamar</option>
                    @foreach ($kamars as $kamar)
                    <option value="{{ $kamar->nomor_kamar }}">{{ $kamar->nomor_kamar }} - Rp{{ number_format($kamar->harga) }}</option>
                    @endforeach
                </select>
                
                
                <input type="date" name="tanggal_mulai" required 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" 
                    value="{{ old('tanggal_mulai') }}">

                <input type="password" name="password" placeholder="Password" 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" required>

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" 
                    class="w-full px-4 py-3 rounded-lg shadow-md focus:ring-0 focus:outline-none" required>

                <button type="submit" class="w-full bg-[#072D44] text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-[#064469] transition-all">
                    Daftar
                </button>
            </form>

            <!-- Link ke Login -->
            <p class="mt-4 text-gray-600">Sudah punya akun? 
                <a href="{{ route('penyewa.login') }}" class="text-[#5790AB] font-semibold hover:underline">Masuk</a>
            </p>
        </div>

    </div>

</body>
</html>
