<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Penyewa - Sobat Kos</title>
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
            <a href="{{ route('admin.keuangan.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
                <span>📈</span><span>Pemasukan & Pengeluaran</span>
            </a>
            <a href="{{ route('auth.admin.pengaduan.index') }}" class="text-sm flex items-center space-x-1 font-bold border-b-2 border-white">
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
        <h1 class="text-2xl font-bold">Pelaporan Penyewa</h1>
        <p class="text-lg">Daftar pengaduan yang masuk</p>
    </div>

    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Pengaduan Penyewa</h2>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 shadow-lg rounded-lg">
            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Penyewa</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">Foto</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengaduans as $pengaduan)
                    <tr class="bg-gray-50 hover:bg-gray-100 transition">
                        <td class="border p-2">{{ $pengaduan->penyewa->nama }}</td>
                        <td class="border p-2">{{ $pengaduan->kategori }}</td>
                        <td class="border p-2 text-center">
                            @if($pengaduan->foto)
                                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="border p-2">
                            <span class="px-3 py-1 rounded 
                                @if($pengaduan->status == 'Pending') bg-yellow-400 text-white 
                                @elseif($pengaduan->status == 'Diproses') bg-blue-500 text-white 
                                @else bg-green-500 text-white @endif">
                                {{ $pengaduan->status }}
                            </span>
                        </td>
                        <td class="border p-2">
                            <a href="{{ route('admin.pengaduan.show', $pengaduan->id) }}" 
                               class="text-blue-500 hover:underline">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>                
            </table>
        </div>
    </div>

</body>
</html>
