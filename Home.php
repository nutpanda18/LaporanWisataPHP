<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'Anonim';

// Simulating a database with a JSON file (standard PHP approach without SQL)
$databaseFile = 'reports.json';
if (!file_exists($databaseFile)) {
    file_put_contents($databaseFile, json_encode([]));
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
    $reports = json_decode(file_get_contents($databaseFile), true);
    
    $newReport = [
        'date' => date('d/m/Y'),
        'nama' => $currentUser,
        'lokasi' => htmlspecialchars($_POST['lokasi']),
        'isi' => htmlspecialchars($_POST['isi']),
        'status' => 'Diproses'
    ];
    
    array_unshift($reports, $newReport); // Add to the beginning of array
    file_put_contents($databaseFile, json_encode($reports));
    
    header("Location: index.php?status=success");
    exit();
}

// Logout Logic
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Load Reports
$reports = json_decode(file_get_contents($databaseFile), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sistem Laporan Keluhan Wisata - Home</title>
</head>
<body class="bg-orange-50 text-stone-800">
    <nav class="bg-orange-950 text-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="font-bold text-lg tracking-wide flex items-center gap-2">
                <span class="text-amber-400"></span> Sistem Laporan Keluhan Wisata
            </h1>
            <div id="navAuth" class="space-x-6 text-sm font-medium">
                <a href="index.php" class="hover:text-amber-400 underline decoration-2 underline-offset-8">Home</a>
                <a href="Tentang.php" class="hover:text-amber-400">Tentang</a>
                
                <?php if ($isLoggedIn): ?>
                    <span class="text-amber-200 text-xs">Halo, <?php echo $currentUser; ?></span>
                    <a href="?action=logout" class="bg-red-700 px-4 py-2 rounded-full hover:bg-red-800 transition text-white">Logout</a>
                <?php else: ?>
                    <a href="Login.php" class="bg-amber-500 px-4 py-2 rounded-full hover:bg-amber-600 transition text-white">Login / Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <header class="relative rounded-3xl overflow-hidden shadow-2xl mb-12 group border-4 border-amber-200">
            <img src="https://static.promediateknologi.id/crop/0x0:0x0/0x0/webp/photo/p2/220/2024/04/04/CaptureJPG-1596998515.jpg" 
                 alt="Wisata Madiun" class="w-full h-72 object-cover transition duration-500 group-hover:scale-105">
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
                                <th class="p-4">Cakupan Laporan</th>
                                <th class="p-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50">
                            <tr class="hover:bg-amber-50/50 transition">
                                <td class="p-4 font-bold text-orange-300">01</td>
                                <td class="p-4 font-bold text-orange-800">Fasilitas Umum</td>
                                <td class="p-4 text-sm text-stone-600">Toilet rusak, gazebo rapuh.</td>
                                <td class="p-4 text-center"><span class="bg-green-100 text-green-700 px-2 py-1 rounded text-[10px] font-bold">AKTIF</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <?php if ($isLoggedIn): ?>
                    <div id="formSection" class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-amber-500">
                        <h3 class="text-lg font-bold mb-6 text-orange-900">Buat Pengaduan</h3>
                        <form method="POST" action="index.php" class="space-y-4">
                            <div>
                                <label class="text-xs font-bold text-stone-400 uppercase">Nama Pelapor</label>
                                <input type="text" value="<?php echo $currentUser; ?>" class="w-full mt-1 p-2 bg-stone-100 border rounded outline-none" readonly>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-stone-500 uppercase">Lokasi Wisata</label>
                                <input type="text" name="lokasi" class="w-full mt-1 p-2 bg-orange-50 border border-orange-200 rounded focus:border-orange-500 outline-none" placeholder="Contoh: Waduk Bening" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-stone-500 uppercase">Isi Laporan</label>
                                <textarea name="isi" rows="4" class="w-full mt-1 p-2 bg-orange-50 border border-orange-200 rounded focus:border-orange-500 outline-none" placeholder="Detail keluhan..." required></textarea>
                            </div>
                            <button type="submit" name="submit_report" class="w-full bg-orange-600 text-white py-3 rounded-xl font-bold hover:bg-orange-700 transition shadow-lg shadow-orange-200">Kirim Sekarang</button>
                        </form>
                    </div>
                <?php else: ?>
                    <div id="loginPrompt" class="bg-amber-100 p-8 rounded-2xl border-2 border-dashed border-amber-300 text-center">
                        <p class="text-orange-900 font-bold mb-4 text-sm">Ingin Melapor?</p>
                        <a href="Login.php" class="inline-block bg-orange-600 text-white px-8 py-2 rounded-full font-bold hover:bg-orange-700 transition shadow-md">Login / Daftar</a>
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
                    <tbody id="historyBody" class="divide-y divide-orange-50">
                        <?php if (empty($reports)): ?>
                            <tr><td colspan="5" class="p-8 text-center text-stone-400 italic">Belum ada laporan.</td></tr>
                        <?php else: ?>
                            <?php foreach ($reports as $r): ?>
                                <tr class="text-sm border-b hover:bg-orange-50 transition">
                                    <td class="p-4 text-stone-500"><?php echo $r['date']; ?></td>
                                    <td class="p-4 font-bold text-orange-700"><?php echo $r['nama']; ?></td>
                                    <td class="p-4 font-semibold text-stone-800"><?php echo $r['lokasi']; ?></td>
                                    <td class="p-4 text-stone-600"><?php echo $r['isi']; ?></td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-1 bg-amber-100 text-orange-800 rounded text-[10px] font-bold">DIPROSES</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <script>alert('Laporan berhasil dikirim!');</script>
    <?php endif; ?>
</body>
</html>