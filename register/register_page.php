<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Jurnal Ibadah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-4">Register</h2>
        
        <form action="register.php" method="post" class="space-y-4">
            <div>
                <input type="text" name="username" placeholder="Username" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>

            <div>
                <input type="password" name="password" placeholder="Password" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required />
            </div>

            <button type="submit" name="submit" class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600">Register</button>
        </form>
        
        <p class="text-center mt-4">Already have an account? <a href="../login/login_page.php" class="text-blue-500 hover:underline">Sign in here</a>.</p>
    </div>
</body>
</html>