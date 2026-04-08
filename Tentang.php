<?php
session_start();


$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tentang - Sistem Laporan Keluhan Wisata</title>
</head>
<body class="bg-orange-50 text-stone-800">

    <nav class="bg-orange-950 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg tracking-wide flex items-center gap-2">
                <span class="text-amber-400">🍂</span> Sistem Laporan Keluhan Wisata
            </h1>
            <div class="space-x-6 text-sm font-medium">
                <a href="index.php" class="hover:text-amber-400">Home</a>
                <a href="Tentang.php" class="hover:text-amber-400 underline decoration-2 underline-offset-8">Tentang</a>
                
                <?php if ($isLoggedIn): ?>
                    <a href="?action=logout" class="bg-red-700 px-4 py-2 rounded-full hover:bg-red-800 transition text-white">Logout</a>
                <?php else: ?>
                    <a href="Login.php" class="bg-amber-500 px-4 py-2 rounded-full hover:bg-amber-600 transition text-white">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-orange-900 to-orange-800 py-20 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Membangun Pariwisata Madiun Lebih Baik</h2>
            <p class="text-orange-100 max-w-2xl mx-auto">Sistem Laporan Wisata adalah platform aspirasi demi menjaga keindahan dan kenyamanan aset kota Madiun.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 -mt-10 mb-20">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-amber-500">
                <div class="text-orange-600 mb-4 text-3xl">🏗️</div>
                <h3 class="text-xl font-bold mb-2 text-orange-900">Respon Cepat</h3>
                <p class="text-stone-600 text-sm">Menghubungkan laporan Anda langsung ke pengelola wisata.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-orange-500">
                <div class="text-orange-600 mb-4 text-3xl">⚖️</div>
                <h3 class="text-xl font-bold mb-2 text-orange-900">Transparansi</h3>
                <p class="text-stone-600 text-sm">Semua status laporan dapat dipantau secara terbuka.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-amber-700">
                <div class="text-orange-600 mb-4 text-3xl">🤝</div>
                <h3 class="text-xl font-bold mb-2 text-orange-900">Partisipasi</h3>
                <p class="text-stone-600 text-sm">Masyarakat ikut andil dalam menjaga fasilitas publik.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12">
        <div class="text-center mb-16">
            <h3 class="text-3xl font-bold text-orange-950">Cara Kerja Sistem</h3>
            <p class="text-stone-500 mt-2">Empat langkah mudah untuk memperbaiki pariwisata kita.</p>
        </div>

        <div class="grid md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold">1</div>
                <h4 class="font-bold text-orange-900">Login Akun</h4>
                <p class="text-xs text-stone-500">Masuk untuk memvalidasi identitas pelapor.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold">2</div>
                <h4 class="font-bold text-orange-900">Isi Formulir</h4>
                <p class="text-xs text-stone-500">Pilih lokasi dan jelaskan kendala yang ditemukan.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold">3</div>
                <h4 class="font-bold text-orange-900">Verifikasi</h4>
                <p class="text-xs text-stone-500">Admin mengecek kebenaran laporan di lapangan.</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 font-bold">4</div>
                <h4 class="font-bold text-orange-900">Tindakan</h4>
                <p class="text-xs text-stone-500">Perbaikan dilakukan oleh dinas terkait.</p>
            </div>
        </div>

        <div class="mt-20 bg-orange-950 rounded-3xl p-10 text-white flex flex-col md:flex-row items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold">Ada Pertanyaan Darurat?</h3>
                <p class="text-orange-200 mt-2">Hubungi Dinas Pariwisata Kota Madiun secara langsung.</p>
            </div>
            <div class="mt-6 md:mt-0 space-y-2">
                <p class="flex items-center gap-2"><span class="text-amber-400">📍</span> Jl. Pahlawan No. 1, Madiun</p>
                <p class="flex items-center gap-2"><span class="text-amber-400">📞</span> (0351) 123456</p>
                <p class="flex items-center gap-2"><span class="text-amber-400">✉️</span> info@wisatamadiun.go.id</p>
            </div>
        </div>
    </div>

</body>
</html>