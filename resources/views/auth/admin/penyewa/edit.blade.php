<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Penyewa - Sobat Kos</title>
    <script src="https://cdn.tailwindcss.com"></script>   
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-50 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Edit Data Penyewa</h2>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.penyewa.update', $penyewa->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama (readonly) -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Nama Penyewa</label>
                <input
                    type="text"
                    value="{{ $penyewa->nama }}"
                    disabled
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 text-gray-700 cursor-not-allowed"
                >
            </div>

            <!-- Nomor Kamar -->
            <div>
                <label for="nomor_kamar" class="block mb-1 font-medium text-gray-700">Nomor Kamar</label>
                <input
                    type="text"
                    name="nomor_kamar"
                    id="nomor_kamar"
                    value="{{ old('nomor_kamar', $penyewa->nomor_kamar) }}"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
                @error('nomor_kamar')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block mb-1 font-medium text-gray-700">Status</label>
                <select
                    name="status"
                    id="status"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 transition"
                >
                    <option value="Aktif" {{ $penyewa->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ $penyewa->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 rounded-lg hover:bg-blue-700 transition duration-200"
            >
                Simpan Perubahan
            </button>
        </form>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('admin.penyewa.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Kembali ke daftar penyewa
            </a>
        </div>
    </div>

</body>
</html>