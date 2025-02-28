<?php
session_start();
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Ambil user dari database
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Cek password
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["username"] = $username;
        header("Location: ../index.php");
        exit();
    } else {
        echo "Username atau password salah!";
    }
}
?>