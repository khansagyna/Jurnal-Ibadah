<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_tanggal = $_POST['old_tanggal'];
    $tanggal = $_POST['tanggal'];
    $sholat = $_POST['sholat'];
    $puasa = isset($_POST['puasa']) ? 1 : 0;
    $sedekah = $_POST['sedekah'];
    $tadarus = $_POST['tadarus'];

    // Cek apakah user mengubah tanggal
    if ($old_tanggal !== $tanggal) {
        // Periksa apakah tanggal baru sudah ada di database
        $check_sql = "SELECT * FROM ibadah WHERE tanggal = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $tanggal);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika tanggal sudah ada, beri notifikasi dan kembali
            header("Location: index.php?status=error-tanggal");
            exit();
        }
    }

    // Update data berdasarkan tanggal lama
    $sql = "UPDATE ibadah SET tanggal=?, sholat=?, puasa=?, sedekah=?, tadarus=? WHERE tanggal=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiss", $tanggal, $sholat, $puasa, $sedekah, $tadarus, $old_tanggal);

    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
