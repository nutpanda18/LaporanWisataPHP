<?php
session_start();

// Configuration for our "Database"
$userFile = 'users.json';
if (!file_exists($userFile)) {
    file_put_contents($userFile, json_encode([]));
}

$error = "";
$success = "";

// Handle Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {
    $users = json_decode(file_get_contents($userFile), true);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password']; // In real apps, use password_hash()

    // Check if user already exists
    if (isset($users[$username])) {
        $error = "Username sudah terdaftar!";
    } else {
        $users[$username] = ['password' => $password];
        file_put_contents($userFile, json_encode($users));
        
        // Auto-login after registration
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php"); // Redirect to home
        exit();
    }
}

// Handle Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $users = json_decode(file_get_contents($userFile), true);
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Auth - Wisata Madiun</title>
</head>
<body class="bg-orange-50 flex items-center justify-center min-h-screen p-4">
    
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-8 border-orange-600">
        
        <?php if($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <div id="registerSection" class="<?php echo (isset($_POST['action']) && $_POST['action'] === 'login') ? 'hidden' : ''; ?>">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-orange-900">Daftar Akun</h1>
                <p class="text-stone-500 text-sm">Buat akun untuk melapor</p>
            </div>
            <form method="POST" action="Login.php" class="space-y-4">
                <input type="hidden" name="action" value="register">
                <div>
                    <label class="block text-sm font-semibold text-stone-700">Username</label>
                    <input type="text" name="username" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="Username baru" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-stone-700">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 bg-orange-50 border border-orange-200 rounded-lg outline-none focus:ring-2 focus:ring-orange-500" placeholder="••••••••" required>
                </div>
                <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 rounded-lg transition shadow-md">Daftar & Masuk</button>
            </form>
            <p class="mt-4 text-center text-sm text-stone-600">
                Sudah punya akun? <button onclick="toggleAuth()" class="text-orange-600 font-bold hover:underline">Login di sini</button>
            </p>
        </div>

        <div id="loginSection" class="<?php echo (isset($_POST['action']) && $_POST['action'] === 'login') ? '' : 'hidden'; ?>">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-orange-900">Login</h1>
                <p class="text-stone-500 text-sm">Masuk ke sistem laporan</p>
            </div>
            <form method="POST" action="Login.php" class="space-y-4">
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
    </div>

    <script>
        function toggleAuth() {
            document.getElementById('registerSection').classList.toggle('hidden');
            document.getElementById('loginSection').classList.toggle('hidden');
        }
    </script>
</body>
</html>