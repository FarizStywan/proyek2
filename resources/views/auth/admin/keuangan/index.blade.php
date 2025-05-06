<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemasukan & Pengeluaran - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <a href="{{ route('admin.kamar.index') }}" 
               class="text-sm flex items-center space-x-1 {{ request()->routeIs('admin.kamar.index') ? 'font-bold border-b-2 border-white' : 'hover:text-gray-300' }}">
                <span>🛏️</span><span>Kelola Kamar</span>
            </a>
            <a href="{{ route('admin.verifikasi.index') }}"  class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>💳</span><span>Verifikasi Pembayaran</span>
            </a>
            <a href="{{ route('admin.keuangan.index') }}" class="text-sm flex items-center space-x-1 font-bold border-b-2 border-white">
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

    <!-- Header -->
    <div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
        <h1 class="text-2xl font-bold">Pemasukan & Pengeluaran</h1>
        <p class="text-lg">Kelola keuangan kos dengan mudah</p>
    </div>

    <div class="container mx-auto mt-10">
        <!-- Statistik -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-xl font-bold">Total Pemasukan</h3>
                <p class="text-3xl font-semibold mt-2 text-green-600">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-xl font-bold">Total Pengeluaran</h3>
                <p class="text-3xl font-semibold mt-2 text-red-600">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 shadow-lg rounded-lg text-center">
                <h3 class="text-xl font-bold">Keuntungan Bersih</h3>
                <p class="text-3xl font-semibold mt-2 text-blue-600">Rp {{ number_format($keuntungan, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <!-- Form Tambah Pengeluaran -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-lg font-bold mb-3">Tambah Pengeluaran</h3>
            <form action="{{ route('admin.keuangan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis" value="Pengeluaran">
                <input type="text" id="jumlah" name="jumlah" placeholder="Rp 0" required class="border p-2 rounded w-full mb-3" onkeyup="formatRupiah(this)">
                <input type="text" name="deskripsi" placeholder="Deskripsi" required class="border p-2 rounded w-full mb-3">
                <input type="date" name="tanggal" required class="border p-2 rounded w-full mb-3">
                <button type="submit" class="bg-red-500 text-white p-2 rounded w-full hover:bg-red-600">
                    Tambah Pengeluaran
                </button>
            </form>
        </div>
    </div>

    <!-- Diagram Batang Keuntungan Bersih Per Bulan -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
        <h3 class="text-lg font-bold mb-3">Grafik Keuntungan Bersih Per Bulan</h3>
        <canvas id="keuntunganChart"></canvas>
    </div>

    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^0-9]/g, ""); // Hanya angka
            let formatted = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(value);
            
            input.value = formatted.replace(",00", ""); // Hilangkan ",00" di belakang
        }
    </script>

    <script>
        const ctx = document.getElementById('keuntunganChart').getContext('2d');
        const keuntunganChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($keuntunganPerBulan)) !!},
                datasets: [{
                    label: 'Keuntungan Bersih',
                    data: {!! json_encode(array_values($keuntunganPerBulan)) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
