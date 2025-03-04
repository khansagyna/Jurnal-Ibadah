<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username dan password wajib diisi!";
        exit();
    }

    // Ambil data user berdasarkan username
    $stmt = $conn->prepare("SELECT id, username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Cek apakah user ditemukan dan password cocok
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // Amankan sesi

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];

        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.'); window.location.href='login_page.php';</script>";
        exit();
    }
}
?>

