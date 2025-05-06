<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penyewa - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Penyewa</h2>

        <div class="bg-white p-6 shadow-lg rounded-lg">
            <form action="{{ route('admin.penyewa.update', $penyewa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="text" name="nomor_kamar" value="{{ $penyewa->nomor_kamar }}" required class="border p-2 rounded w-full mb-3">
                
                <select name="status" required class="border p-2 rounded w-full mb-3">
                    <option value="Aktif" {{ $penyewa->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ $penyewa->status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>

                <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full hover:bg-blue-600">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

</body>
</html>
