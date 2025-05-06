<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kamar - Sobat Kos</title>
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

    <!-- Header Section -->
    <div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
        <h1 class="text-2xl font-bold">Kelola Kamar</h1>
        <p class="text-lg">Atur kamar kos dengan mudah</p>
    </div>

    <div class="container mx-auto mt-10">
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tambah Kamar -->
        <div class="bg-white p-6 shadow-lg rounded-lg mb-6">
            <h3 class="text-lg font-bold mb-3">Tambah Kamar</h3>
            <form action="{{ route('admin.kamar.store') }}" method="POST">
                @csrf
                <input type="text" name="nomor_kamar" placeholder="Nomor Kamar" required class="border p-2 rounded w-full mb-3">
            
                <select name="fasilitas" required class="border p-2 rounded w-full mb-3">
                    <option value="AC">AC</option>
                    <option value="Non-AC">Non-AC</option>
                </select>
            
                <!-- Input Harga dengan Format Rupiah -->
                <input type="text" id="harga" name="harga" placeholder="Rp 1.000.000" required 
                    class="border p-2 rounded w-full mb-3" onkeyup="formatRupiah(this)">
            
                <select name="status" required class="border p-2 rounded w-full mb-3">
                    <option value="Kosong">Kosong</option>
                    <option value="Terisi">Terisi</option>
                </select>
            
                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600 transition">
                    Tambah Kamar
                </button>
            </form>
        </div>

        <!-- List Kamar -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="text-lg font-bold mb-3">Daftar Kamar</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 p-2">Nomor Kamar</th>
                        <th class="border border-gray-300 p-2">Fasilitas</th>
                        <th class="border border-gray-300 p-2">Harga</th>
                        <th class="border border-gray-300 p-2">Status</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kamar as $data)
                        <tr class="bg-gray-50 hover:bg-gray-100 transition">
                            <td class="border border-gray-300 p-2">{{ $data->nomor_kamar }}</td>
                            <td class="border border-gray-300 p-2">{{ $data->fasilitas }}</td>
                            <td class="border border-gray-300 p-2">Rp {{ number_format($data->harga, 0, ',', '.') }}</td>
                            <td class="border border-gray-300 p-2">{{ $data->status }}</td>
                            <td class="border border-gray-300 p-2 flex space-x-2">
                                <a href="{{ route('admin.kamar.edit', $data->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">Edit</a>
                                <form action="{{ route('admin.kamar.destroy', $data->id) }}" method="POST">
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

    <!-- Script Format Rupiah -->
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

</body>
</html>
