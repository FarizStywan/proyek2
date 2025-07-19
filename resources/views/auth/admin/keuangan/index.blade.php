<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penyewa - Sobat Kos</title>
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

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mx-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Bulan -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6 mx-4">
        <form action="{{ route('admin.keuangan.index') }}" method="GET">
            <label for="bulan" class="block font-medium mb-2">Pilih Bulan</label>
            <div class="flex items-center space-x-4">
                <input type="month" name="bulan" id="bulan"
                       value="{{ request('bulan', now()->format('Y-m')) }}"
                       class="border p-2 rounded w-full">

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 px-4">
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Total Pemasukan</h3>
            <p class="text-3xl font-semibold mt-2 text-green-600">
                Rp {{ number_format((float)($pemasukan ?? 0), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Total Pengeluaran</h3>
            <p class="text-3xl font-semibold mt-2 text-red-600">
                Rp {{ number_format((float)($pengeluaran ?? 0), 0, ',', '.') }}
            </p>
        </div>
        <div class="bg-white p-6 shadow-lg rounded-lg text-center">
            <h3 class="text-xl font-bold">Keuntungan Bersih</h3>
            <p class="text-3xl font-semibold mt-2 text-blue-600">
                Rp {{ number_format((float)($keuntungan ?? 0), 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Form Tambah Pengeluaran -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6 mx-4">
        <h3 class="text-lg font-bold mb-3">Tambah Pengeluaran</h3>
        <form action="{{ route('admin.keuangan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jenis" value="Pengeluaran">

            <label for="jumlah_display" class="block font-medium mb-1">Jumlah</label>
            <input type="text" id="jumlah_display" placeholder="Rp 0" required class="border p-2 rounded w-full mb-3" oninput="formatRupiah(this)">
            <input type="hidden" name="jumlah" id="jumlah">

            <label for="deskripsi" class="block font-medium mb-1">Deskripsi</label>
            <input type="text" name="deskripsi" placeholder="Deskripsi pengeluaran" required class="border p-2 rounded w-full mb-3">

            <label for="tanggal" class="block font-medium mb-1">Tanggal</label>
            <input type="date" name="tanggal" required class="border p-2 rounded w-full mb-3">

            <button type="submit" class="bg-red-500 text-white p-2 rounded w-full hover:bg-red-600">
                Tambah Pengeluaran
            </button>
        </form>
    </div>

    <!-- Grafik Keuntungan Bersih -->
    @if(!empty($labels))
        <div class="bg-white p-6 shadow-lg rounded-lg mx-4 mb-6">
            <h3 class="text-lg font-bold mb-3">Grafik Keuntungan Bersih Per Bulan</h3>
            <canvas id="keuntunganChart" height="120"></canvas>
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-6 rounded mx-4 mb-6 text-center">
            Belum ada data untuk ditampilkan.
        </div>
    @endif

</div>

<!-- Format Rupiah Script -->
<script>
    function formatRupiah(input) {
        let numberString = input.value.replace(/[^0-9]/g, '');
        if (!numberString) return;

        let formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(numberString);

        input.value = formatted.replace(",00", "");
        document.getElementById('jumlah').value = (parseInt(numberString) / 100).toFixed(2);
    }
</script>

<!-- Chart JS -->
<script>
    const ctx = document.getElementById('keuntunganChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels ?? []) !!},
            datasets: [{
                label: 'Keuntungan Bersih',
                data: {!! json_encode(array_map('floatval', $data ?? [])) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.6)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>