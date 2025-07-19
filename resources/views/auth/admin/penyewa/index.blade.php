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
   
<!-- Header -->
<div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
    <h1 class="text-2xl font-bold">Data Penyewa</h1>
    <p class="text-lg">Kelola daftar penyewa kos dengan mudah</p>
</div>

<div class="container mx-auto mt-10 px-4">

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Pencarian -->
    <form action="{{ route('admin.penyewa.index') }}" method="GET" class="mb-6">
        <div class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Cari nama atau kamar..." value="{{ request('search') }}" class="border p-2 rounded w-full">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.penyewa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Reset</a>
            @endif
        </div>
    </form>

    <!-- Info Hasil Pencarian -->
    @if(request('search'))
        <div class="bg-blue-100 text-blue-800 p-3 rounded mb-4">
            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
        </div>
    @endif

    <!-- Tabel Data Penyewa -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 bg-white border-b">
            <h2 class="text-xl font-semibold">Daftar Penyewa</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No HP</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kamar</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Tanggal Mulai</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($penyewa as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->foto_profil)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $item->foto_profil) }}" alt="Foto Profil">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                            {{ strtoupper(substr($item->nama, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nama }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->no_hp }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->nomor_kamar }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs leading-5 font-semibold rounded-full 
                                    {{ $item->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.penyewa.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                <form action="{{ route('admin.penyewa.destroy', $item->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data penyewa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 bg-white">
            {{ $penyewa->links() }}
        </div>
    </div>
</div>

</body>
</html>