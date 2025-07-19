<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kamar - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>   
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-[#064469] p-4 text-white flex justify-between items-center shadow-lg">
    <div class="flex space-x-6">
        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold hover:text-gray-300 transition">Sobat Kos</a>
        <a href="{{ route('admin.penyewa.index') }}" class="text-sm flex items-center space-x-1 hover:text-gray-300 transition">
            <span>🏠</span><span>Data Penyewa</span>
        </a>
        <a href="{{ route('admin.kamar.index') }}" class="text-sm flex items-center space-x-1 font-bold border-b-2 border-white">
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
    <h1 class="text-2xl font-bold">Kelola Kamar</h1>
    <p class="text-lg">Atur kamar kos dengan mudah</p>
</div>

<div class="container mx-auto mt-10 px-4">

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Kamar -->
    <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
        <h3 class="text-lg font-bold mb-4">Tambah Kamar</h3>
        <form action="{{ route('admin.kamar.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <input 
                    type="text" 
                    name="nomor_kamar" 
                    placeholder="Nomor Kamar" 
                    required 
                    class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

                <select 
                    name="fasilitas" 
                    required 
                    class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Fasilitas</option>
                    <option value="AC">AC</option>
                    <option value="Non-AC">Non-AC</option>
                </select>

                <input 
                    type="text" 
                    id="harga_display" 
                    name="harga_display" 
                    placeholder="Rp 1.000.000" 
                    required 
                    class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                    oninput="formatRupiah(this)"
                >
                <input type="hidden" name="harga" id="harga_input">

                <select 
                    name="status" 
                    required 
                    class="border p-3 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Pilih Status</option>
                    <option value="Kosong">Kosong</option>
                    <option value="Terisi">Terisi</option>
                </select>
            </div>

            <button 
                type="submit" 
                class="w-full bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition duration-200">
                Tambah Kamar
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Kamar -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-4 bg-white border-b">
            <h2 class="text-xl font-semibold">Daftar Kamar</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nomor Kamar</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Fasilitas</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Harga</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($kamar as $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->nomor_kamar }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->fasilitas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Rp {{ number_format($data->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                    {{ $data->status == 'Kosong' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $data->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.kamar.edit', $data->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                <form action="{{ route('admin.kamar.destroy', $data->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada data kamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 bg-white">
            {{ $kamar->links() }}
        </div>
    </div>

</div>

<!-- Script Format Rupiah -->
<script>
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (!value) return;

        let formatted = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(value);

        input.value = formatted.replace(",00", "");
        document.getElementById('harga_input').value = value;
    }
</script>

</body>
</html>