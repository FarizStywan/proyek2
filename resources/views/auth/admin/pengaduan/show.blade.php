<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-[#064469] p-4 text-white flex justify-between items-center shadow-lg">
        <div class="flex space-x-6">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold hover:text-gray-300 transition">
                Sobat Kos
            </a>
            <a href="{{ route('auth.admin.pengaduan.index') }}" class="text-sm flex items-center space-x-1 font-bold border-b-2 border-white">
                <span>⚠️</span><span>Pelaporan Penyewa</span>
            </a>
        </div>
    </nav>

    <!-- Header -->
    <div class="bg-[#064469] text-white p-6 rounded-b-2xl mt-4 mx-4 shadow-lg">
        <h1 class="text-2xl font-bold">Detail Pengaduan</h1>
    </div>

    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-6">
        <h2 class="text-xl font-bold mb-4">Informasi Pengaduan</h2>
        
        <p><strong>Nama Penyewa:</strong> {{ $pengaduan->penyewa->nama }}</p>
        <p><strong>Kategori:</strong> {{ $pengaduan->kategori }}</p>
        <p><strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}</p>

        @if ($pengaduan->foto)
    <p><strong>Bukti Foto:</strong></p>
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" 
         class="w-64 rounded-lg shadow-md cursor-pointer hover:scale-105 transition"
         onclick="openModal('{{ asset('storage/' . $pengaduan->foto) }}')">
@endif

<!-- Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <div class="relative">
        <button onclick="closeModal()" class="absolute top-0 right-0 text-white text-2xl font-bold px-3 py-1">×</button>
        <img id="modalImage" src="" class="max-w-full max-h-screen rounded-lg shadow-lg">
    </div>
</div>

<script>
    function openModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('modalImage').src = '';
    }

    // Optional: Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>


        <p class="mt-4"><strong>Status:</strong> 
            <span class="px-3 py-1 rounded 
                @if($pengaduan->status == 'Pending') bg-yellow-400 text-white 
                @elseif($pengaduan->status == 'Diproses') bg-blue-500 text-white 
                @else bg-green-500 text-white @endif">
                {{ $pengaduan->status }}
            </span>
        </p>

        <!-- Form Update Status -->
        <div class="mt-6">
            <h3 class="text-lg font-bold mb-2">Perbarui Status</h3>
            <form action="{{ route('admin.pengaduan.updateStatus', $pengaduan->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <select name="status" class="border p-2 rounded w-full mb-3">
                    <option value="Pending" {{ $pengaduan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Diproses" {{ $pengaduan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $pengaduan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <textarea name="tanggapan" placeholder="Tanggapan dari admin..." class="border p-2 rounded w-full mb-3">{{ $pengaduan->tanggapan }}</textarea>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</body>
</html>
