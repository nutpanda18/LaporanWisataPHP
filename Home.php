<?php
// 1. Start session to manage login state
session_start();
include 'koneksi.php'; // Ensure this file has the correct $koneksi variable

// Check login status
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'Tamu';

// 2. Fetch reports from your actual database table
// FIX: Changed 'ORDER BY id' to 'ORDER BY tanggal_laporan' to prevent the Fatal Error
$query_text = "SELECT * FROM laporan ORDER BY tanggal_laporan DESC";
$reports_query = mysqli_query($koneksi, $query_text);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sistem Laporan Keluhan Wisata</title>
</head>
<body class="bg-orange-50 text-stone-800">

    <nav class="bg-orange-950 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg tracking-wide flex items-center gap-2">
                <span class="text-amber-400">🍂</span> Sistem Laporan Wisata
            </h1>
            <div class="space-x-6 text-sm font-medium">
                <a href="Home.php" class="hover:text-amber-400 underline decoration-2 underline-offset-8">Home</a>
                <a href="Tentang.php" class="hover:text-amber-400">Tentang</a>
                
                <?php if (!$isLoggedIn): ?>
                    <a href="Login.php" class="bg-amber-500 px-4 py-2 rounded-full hover:bg-amber-600 transition">Login / Register</a>
                <?php else: ?>
                    <span class="text-amber-400 mr-2">Hi, <?php echo htmlspecialchars($currentUser); ?></span>
                    <a href="Login.php?logout=true" class="bg-red-700 px-4 py-2 rounded-full hover:bg-red-800 transition">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <header class="relative rounded-3xl overflow-hidden shadow-2xl mb-12 border-4 border-amber-200">
            <img src="https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/220/2024/04/04/CaptureJPG-1596998515.jpg" 
                 class="w-full h-72 object-cover" alt="Wisata Madiun">
            <div class="absolute inset-0 bg-gradient-to-t from-orange-950/80 to-transparent flex items-end p-8">
                <h2 class="text-3xl font-bold text-white uppercase tracking-tight">Kota Madiun</h2>
            </div>
        </header>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <h3 class="text-xl font-bold border-l-4 border-amber-600 pl-4 text-orange-900">Kategori Keluhan</h3>
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-orange-100 mt-4">
                    <table class="w-full text-left">
                        <thead class="bg-amber-100 text-orange-900 uppercase text-[10px] font-black tracking-widest">
                            <tr>
                                <th class="p-4">No</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4">Cakupan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50">
                            <tr>
                                <td class="p-4 font-bold text-orange-300">01</td>
                                <td class="p-4 font-bold text-orange-800">Fasilitas</td>
                                <td class="p-4 text-sm text-stone-600">Toilet, Parkir, Lampu Jalan.</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-bold text-orange-300">02</td>
                                <td class="p-4 font-bold text-orange-800">Kebersihan</td>
                                <td class="p-4 text-sm text-stone-600">Sampah, Bau, Kolam kotor.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <?php if ($isLoggedIn): ?>
                    <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-amber-500">
                        <h3 class="text-lg font-bold mb-6 text-orange-900">Buat Pengaduan</h3>
                        <form action="proses_simpan.php" method="POST" class="space-y-4">
                            <div>
                                <label class="text-xs font-bold text-stone-400 uppercase">Nama Pelapor</label>
                                <input type="text" name="nama_pelapor" value="<?php echo htmlspecialchars($currentUser); ?>" class="w-full mt-1 p-2 bg-stone-100 border rounded outline-none" readonly>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-stone-500 uppercase">Lokasi Wisata</label>
                                <input type="text" name="lokasi_wisata" class="w-full mt-1 p-2 bg-orange-50 border border-orange-200 rounded outline-none" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-stone-500 uppercase">Isi Laporan</label>
                                <textarea name="isi_laporan" rows="4" class="w-full mt-1 p-2 bg-orange-50 border border-orange-200 rounded outline-none" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition">Kirim Laporan</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="bg-amber-100 p-8 rounded-2xl border-2 border-dashed border-amber-300 text-center">
                        <p class="text-orange-900 font-bold mb-4 text-sm">Ingin Melapor?</p>
                        <a href="Login.php" class="inline-block bg-orange-600 text-white px-8 py-2 rounded-full font-bold hover:bg-orange-700 transition shadow-md">Login Sekarang</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-12">
            <h3 class="text-xl font-bold border-l-4 border-orange-800 pl-4 mb-4 text-orange-900">Daftar Laporan Masuk</h3>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-orange-100">
                <table class="w-full text-left">
                    <thead class="bg-orange-900 text-amber-200 text-xs uppercase font-black">
                        <tr>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Pelapor</th>
                            <th class="p-4">Lokasi</th>
                            <th class="p-4">Keluhan</th>
                            <th class="p-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-orange-50">
                        <?php 
                        // Loop through real data from the database
                        if ($reports_query && mysqli_num_rows($reports_query) > 0) {
                            while ($r = mysqli_fetch_assoc($reports_query)): 
                        ?>
                        <tr class="text-sm border-b hover:bg-orange-50 transition">
                            <td class="p-4 text-stone-500"><?php echo htmlspecialchars($r['tanggal_laporan']); ?></td>
                            <td class="p-4 font-bold text-orange-700"><?php echo htmlspecialchars($r['nama_pelapor']); ?></td>
                            <td class="p-4 font-semibold text-stone-800"><?php echo htmlspecialchars($r['lokasi_wisata']); ?></td>
                            <td class="p-4 text-stone-600"><?php echo htmlspecialchars($r['isi_laporan']); ?></td>
                            <td class="p-4 text-center">
                                <span class="px-2 py-1 bg-amber-100 text-orange-800 rounded text-[10px] font-bold uppercase">
                                    <?php echo htmlspecialchars($r['status']); ?>
                                </span>
                            </td>
                        </tr>
                        <?php 
                            endwhile; 
                        } else {
                            echo "<tr><td colspan='5' class='p-10 text-center text-stone-400 italic'>Belum ada laporan yang masuk.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>