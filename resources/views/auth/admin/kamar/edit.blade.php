<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 shadow-lg rounded-lg w-1/3">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Kamar</h2>
        
        <form action="{{ route('admin.kamar.update', $kamar->id) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="nomor_kamar" value="{{ $kamar->nomor_kamar }}" required 
                class="border p-2 rounded w-full mb-3" placeholder="Nomor Kamar">
            
            <select name="fasilitas" required class="border p-2 rounded w-full mb-3">
                <option value="AC" {{ $kamar->fasilitas == 'AC' ? 'selected' : '' }}>AC</option>
                <option value="Non-AC" {{ $kamar->fasilitas == 'Non-AC' ? 'selected' : '' }}>Non-AC</option>
            </select>
            
            <input type="text" id="harga" name="harga" value="Rp {{ number_format($kamar->harga, 0, ',', '.') }}" required 
                class="border p-2 rounded w-full mb-3" onkeyup="formatRupiah(this)">
            
            <select name="status" required class="border p-2 rounded w-full mb-3">
                <option value="Kosong" {{ $kamar->status == 'Kosong' ? 'selected' : '' }}>Kosong</option>
                <option value="Terisi" {{ $kamar->status == 'Terisi' ? 'selected' : '' }}>Terisi</option>
            </select>
            
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600 transition">
                Simpan Perubahan
            </button>
        </form>
        
        <a href="{{ route('admin.kamar.index') }}" class="block text-center text-blue-500 mt-4">Kembali</a>
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
