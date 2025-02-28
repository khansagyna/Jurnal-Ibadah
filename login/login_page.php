<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Jurnal Ibadah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container">
    <div class="columns-md-4">
            <div class="register-container w-100 p-5 shadow rounded-5">
                <h2 class="font-bold mb-4 text-center">Sign In</h2>

                

                <form action="login.php" method="post">
                    <div class="form-outline mb-3">
                        <input type="text" name="username" placeholder="Username" id="form2Example1" class="form-control text-black" required />
                    </div>

                    <div class="form-outline mb-3">
                        <input type="password" name="password" id="form2Example2" placeholder="Password" class="form-control text-black" required />
                    </div>

                    <button type="submit" value="Sign In" name="submit" class="btn btn-primary btn-block mb-4 text-white fs-6 w-100">Sign In</button>
                </form>
                <p class="text-center">Don't have an account? <a href="../register/register_page.php">Register here</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>