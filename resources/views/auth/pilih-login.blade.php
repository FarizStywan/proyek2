<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Login - Kosmart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen relative font-sans">

    <!-- Background Blur Gambar Kos -->
    <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center bg-no-repeat opacity-70 blur-sm" 
        style="background-image: url('{{ asset('images/kos.jpg') }}');">
    </div>

    <!-- Kotak Pilih Login -->
    <div class="relative bg-white p-8 rounded-2xl shadow-xl w-96 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Masuk Sebagai</h2>
        
        <div class="space-y-4">
            <a href="{{ route('admin.login') }}" class="block bg-[#072D44] text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-[#064469] transition-all">
                Admin
            </a>
            <a href="{{ route('penyewa.login') }}" class="block bg-[#5790AB] text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-[#9CCDDB] transition-all">
                Penyewa
            </a>
        </div>
    </div>

</body>
</html>
