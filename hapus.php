<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login/login_page.php");
    exit();
}

include 'config.php';

if (isset($_GET['tanggal'])) {
    $tanggal = $_GET['tanggal'];

    // Hapus data berdasarkan tanggal
    $sql = "DELETE FROM ibadah WHERE tanggal = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tanggal);

    if ($stmt->execute()) {
        header("Location: index.php?status=deleted");
        exit();
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Tanggal tidak ditemukan.";
}
?>
