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
            <a href="{{ route('admin.penyewa.index') }}" class="text-sm flex items-center space-x-1 font-bold border-b-2 border-white">
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
        <h1 class="text-2xl font-bold">Data Penyewa</h1>
        <p class="text-lg">Kelola data penyewa kos</p>
    </div>

    <div class="container mx-auto mt-10">
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- List Penyewa -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-bold mb-3">Daftar Penyewa</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">Nama</th>
                        <th class="border border-gray-300 p-2">Nomor Kamar</th>
                        <th class="border border-gray-300 p-2">Status</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penyewa as $data)
                        <tr class="bg-gray-50 hover:bg-gray-100 transition">
                            <td class="border border-gray-300 p-2">{{ $data->nama }}</td>
                            <td class="border border-gray-300 p-2">{{ $data->nomor_kamar }}</td>
                            <td class="border border-gray-300 p-2">{{ $data->status }}</td>
                            <td class="border border-gray-300 p-2 flex space-x-2">
                                <a href="{{ route('admin.penyewa.edit', $data->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Edit</a>
                                <form action="{{ route('admin.penyewa.destroy', $data->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
