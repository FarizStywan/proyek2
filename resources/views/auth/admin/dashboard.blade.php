<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-[#064469] p-4 text-white flex justify-between items-center shadow-lg">
        <div class="flex space-x-6">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold hover:text-gray-300 transition">
                Sobat Kos
            </a>
            <a href="{{ route('admin.penyewa.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>🏠</span><span>Data Penyewa</span>
            </a>
            <a href="{{ route('admin.kamar.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>🛏️</span><span>Kelola Kamar</span>
            </a>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>💳</span><span>Verifikasi Pembayaran</span>
            </a>            
            <a href="{{ route('admin.keuangan.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>📈</span><span>Pemasukan & Pengeluaran</span>
            </a>
            <a href="{{ route('auth.admin.pengaduan.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>⚠️</span><span>Pelaporan Penyewa</span>
            </a>
            
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="border px-4 py-2 rounded-md hover:bg-red-500 hover:text-white transition">
                Keluar ➡️
            </button>
        </form>
    </nav>

    <!-- Header Section -->
    <div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
        <h1 class="text-2xl font-bold">Hallo Admin,</h1>
        <p class="text-lg">Yuk Kelola Kosmu Sekarang!</p>
    </div>

    <!-- Statistik Utama -->
    <div class="container mx-auto mt-10 grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Total Penyewa</h3>
            <p class="text-3xl font-semibold mt-2 text-[#064469]">{{ $totalPenyewa }}</p>
        </div>
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Penyewa Aktif</h3>
            <p class="text-3xl font-semibold mt-2 text-green-600">{{ $penyewaAktif }}</p>
        </div>
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Total Kamar</h3>
            <p class="text-3xl font-semibold mt-2 text-[#064469]">{{ $totalKamar }}</p>
        </div>
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Kamar Tersedia</h3>
            <p class="text-3xl font-semibold mt-2 text-blue-500">{{ $kamarTersedia }}</p>
        </div>
    </div>

    <!-- Pembayaran Tertunda -->
    <div class="mt-10 bg-white p-6 shadow-lg rounded-lg container mx-auto">
        <h2 class="text-xl font-bold mb-4">Pembayaran Menunggu Verifikasi</h2>
        
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
                                <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                                    Verifikasi
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center text-gray-500">Tidak ada pembayaran yang perlu diverifikasi saat ini.</p>
        @endif
    </div>

</body>
</html>
