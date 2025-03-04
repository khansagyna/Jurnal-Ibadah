<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Jurnal Ibadah</title>
    <link rel="stylesheet" href="../css/register.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-4xl bg-white p-10 rounded-2xl shadow-lg grid grid-cols-2 gap-8">
        <!-- Bagian Gambar -->
        <div class="flex items-center">
            <img src="../css/8709883.jpg" alt="Login Image" class="w-full rounded-lg">
        </div>
        
        <!-- Bagian Form -->
        <div class="flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-center mb-6">Register</h2>
            <form action="register.php" method="post" class="space-y-4">
                <input type="text" name="username" placeholder="Username" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                
                <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>

                <button type="submit" name="submit" class="submit w-full from-purple-400 to-blue-500 text-white py-3 rounded-lg hover:opacity-90">Daftar</button>
            </form>
            
            <p class="text-center mt-4">Sudah punya akun? <a href="../login/login_page.php" class="text-blue-500 hover:underline">Masuk disini</a>.</p>
        </div>
    </div>
</body>
</html>
