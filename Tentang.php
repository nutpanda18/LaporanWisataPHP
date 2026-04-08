<?php
session_start();
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
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
                <span class="text-amber-400">🍂</span> Sistem Laporan Wisata
            </h1>
            <div class="space-x-6 text-sm font-medium">
                <a href="Home.php" class="hover:text-amber-400">Home</a>
                <a href="Tentang.php" class="hover:text-amber-400 underline decoration-2 underline-offset-8">Tentang</a>
                
                <?php if (!$isLoggedIn): ?>
                    <a href="Login.php" class="bg-amber-500 px-4 py-2 rounded-full hover:bg-amber-600 transition">Login</a>
                <?php else: ?>
                    <span class="text-orange-200 mr-2">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="Login.php?logout=true" class="bg-red-700 px-4 py-2 rounded-full hover:bg-red-800 transition">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-orange-900 to-orange-800 py-20 text-white">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Membangun Pariwisata Madiun Lebih Baik</h2>
            <p class="text-orange-100 max-w-2xl mx-auto">Platform aspirasi demi menjaga keindahan dan kenyamanan aset kota Madiun.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-12">
        <div class="grid md:grid-cols-3 gap-8 -mt-20">
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-amber-500">
                <h3 class="text-xl font-bold mb-2 text-orange-900">Respon Cepat</h3>
                <p class="text-stone-600 text-sm">Menghubungkan laporan Anda langsung ke pengelola.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-orange-500">
                <h3 class="text-xl font-bold mb-2 text-orange-900">Transparansi</h3>
                <p class="text-stone-600 text-sm">Status laporan dapat dipantau secara terbuka.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-amber-700">
                <h3 class="text-xl font-bold mb-2 text-orange-900">Partisipasi</h3>
                <p class="text-stone-600 text-sm">Masyarakat ikut menjaga fasilitas publik.</p>
            </div>
        </div>
    </div>
</body>
</html>