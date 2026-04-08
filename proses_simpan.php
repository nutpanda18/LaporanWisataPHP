<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama    = $_POST['nama_pelapor'];
    $lokasi  = $_POST['lokasi_wisata'];
    $isi     = $_POST['isi_laporan'];
    $tanggal = date('Y-m-d'); // Auto-sets today's date
    $status  = "PENDING";

    $query = "INSERT INTO laporan (nama_pelapor, lokasi_wisata, isi_laporan, tanggal_laporan, status) 
              VALUES ('$nama', '$lokasi', '$isi', '$tanggal', '$status')";

    if (mysqli_query($koneksi, $query)) {
        // Redirect back to home after success
        header("Location: Home.php?status=success");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>