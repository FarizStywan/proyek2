<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-[#064469] p-4 text-white flex justify-between items-center shadow-lg">
        <div class="flex space-x-6">
            <!-- Logo "Sobat Kos" yang bisa diklik untuk kembali ke Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold hover:text-gray-300 transition">
                Sobat Kos
            </a>
    
            <!-- Navigasi -->
            <a href="{{ route('admin.penyewa.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>🏠</span><span>Data Penyewa</span>
            </a>
            <a href="{{ route('admin.kamar.index') }}" 
               class="text-sm flex items-center space-x-1 {{ request()->routeIs('admin.kamar.index') ? 'font-bold border-b-2 border-white' : 'hover:text-gray-300' }}">
                <span>🛏️</span><span>Kelola Kamar</span>
            </a>
            <a href="{{ route('admin.verifikasi.index') }}" 
               class="text-sm flex items-center space-x-1 {{ request()->routeIs('admin.verifikasi.index') ? 'font-bold border-b-2 border-white' : 'hover:text-gray-300' }}">
                <span>💳</span><span>Verifikasi Pembayaran</span>
            </a>
            <a href="{{ route('admin.keuangan.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>📈</span><span>Pemasukan & Pengeluaran</span>
            </a>
            <a href="{{ route('auth.admin.pengaduan.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>⚠️</span><span>Pelaporan Penyewa</span>
            </a>
        </div>
    
        <!-- Tombol Logout -->
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="border px-4 py-2 rounded-md hover:bg-red-500 hover:text-white transition">
                Keluar ➡️
            </button>
        </form>
    </nav>
    

    <!-- Header Section -->
    <div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
        <h1 class="text-2xl font-bold">Verifikasi Pembayaran</h1>
        <p class="text-lg">Cek dan verifikasi pembayaran penyewa</p>
    </div>

    <div class="container mx-auto mt-10">
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Daftar Pembayaran -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-bold mb-3">Pembayaran Menunggu Verifikasi</h3>

            @if ($pembayaranTertunda->count() > 0)
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 p-2">Nama Penyewa</th>
                            <th class="border border-gray-300 p-2">Jumlah</th>
                            <th class="border border-gray-300 p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayaranTertunda as $pembayaran)
                            <tr class="bg-gray-50 hover:bg-gray-100 transition">
                                <td class="border border-gray-300 p-2">{{ $pembayaran->penyewa->nama }}</td>
                                <td class="border border-gray-300 p-2">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                <td class="border border-gray-300 p-2">
                                    <form action="{{ route('admin.verifikasi.proses', $pembayaran->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                            Verifikasi ✅
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center text-gray-500">Tidak ada pembayaran yang perlu diverifikasi saat ini.</p>
            @endif
        </div>
    </div>

</body>
</html>
