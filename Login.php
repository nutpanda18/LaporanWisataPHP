<?php
session_start();

// --- NEW LOGIC: Handle Logout within Login.php ---
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: Login.php");
    exit();
}
// ------------------------------------------------

// 1. Handle Form Submissions
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; 
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action === 'register') {
        $_SESSION['registered_user'] = $username;
        $_SESSION['registered_pass'] = $password;
        
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        
        header("Location: Home.php");
        exit();

    } elseif ($action === 'login') {
        $stored_user = isset($_SESSION['registered_user']) ? $_SESSION['registered_user'] : null;
        $stored_pass = isset($_SESSION['registered_pass']) ? $_SESSION['registered_pass'] : null;

        if ($username === $stored_user && $password === $stored_pass) {
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['username'] = $username;
            header("Location: Home.php");
            exit();
        } else {
            $error_message = "Username atau Password salah!";
        }
    }
}

// Check if user is already logged in to show a "Welcome Back" message instead of the form
$isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Auth - Wisata Madiun</title>
</head>
<body class="bg-orange-50 flex items-center justify-center min-h-screen p-4">
    
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-8 border-orange-600 text-center">
        
        <?php if ($isLoggedIn): ?>
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-orange-900">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p class="text-stone-500 text-sm mt-2">Anda sudah masuk ke dalam sistem.</p>
            </div>
            <div class="space-y-3">
                <a href="Home.php" class="block w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition shadow-md">
                    Kembali ke Dashboard
                </a>
                <a href="Login.php?logout=true" class="block w-full bg-red-100 hover:bg-red-200 text-red-700 font-bold py-3 rounded-lg transition">
                    Logout (Keluar)
                </a>
            </div>

        <?php else: ?>
            <?php if ($error_message): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 text-sm rounded-lg border border-red-200">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <div id="registerSection">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-orange-900">Daftar Akun</h1>
                    <p class="text-stone-500 text-sm">Buat akun untuk melapor</p>
                </div>
                <form action="Login.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="register">
                    <div>
                        <label class="block text-left text-sm font-semibold text-stone-700">Username</label>
                        <input type="text" name="username" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="Username baru" required>
                    </div>
                    <div>
                        <label class="block text-left text-sm font-semibold text-stone-700">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition shadow-md">Daftar & Masuk</button>
                </form>
                <p class="mt-4 text-center text-sm text-stone-600">
                    Sudah punya akun? <button onclick="toggleAuth()" class="text-orange-600 font-bold hover:underline">Login di sini</button>
                </p>
            </div>

            <div id="loginSection" class="hidden text-left">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold text-orange-900">Login</h1>
                    <p class="text-stone-500 text-sm">Masuk ke sistem laporan</p>
                </div>
                <form action="Login.php" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="login">
                    <div>
                        <label class="block text-sm font-semibold text-stone-700">Username</label>
                        <input type="text" name="username" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="Username Anda" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-stone-700">Password</label>
                        <input type="password" name="password" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg transition shadow-md">Masuk Sekarang</button>
                </form>
                <p class="mt-4 text-center text-sm text-stone-600">
                    Belum punya akun? <button onclick="toggleAuth()" class="text-orange-600 font-bold hover:underline">Daftar di sini</button>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function toggleAuth() {
            document.getElementById('registerSection').classList.toggle('hidden');
            document.getElementById('loginSection').classList.toggle('hidden');
        }
    </script>
</body>
</html>