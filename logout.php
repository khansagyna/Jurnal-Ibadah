<?php
session_start();
session_destroy(); // Hapus semua sesi
header("Location: login/login_page.php"); // Redirect ke halaman login
exit();
?>
