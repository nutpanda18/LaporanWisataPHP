<?php
$host = "localhost";
$user = "root";      // Default XAMPP user
$pass = "";          // Default XAMPP password is empty
$db   = "LaporanKeluhanWisata"; 

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Check if connection works
if (!$koneksi) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>