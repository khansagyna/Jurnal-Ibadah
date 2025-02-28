<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login/login_page.php");
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $sholat = $_POST['sholat'];
    $puasa = isset($_POST['puasa']) ? 1 : 0;
    $sedekah = $_POST['sedekah'];
    $tadarus = $_POST['tadarus'];

    $sql = "INSERT INTO ibadah (tanggal, sholat, puasa, sedekah, tadarus) 
            VALUES ('$tanggal', '$sholat', '$puasa', '$sedekah', '$tadarus')";
    $conn->query($sql);
}

$result = $conn->query("SELECT * FROM ibadah ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Ibadah</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-4">Jurnal Ibadah Ramadhan 📖</h2>

    <!-- Tombol Modal -->
    <div class="flex justify-between">
        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="document.getElementById('modal').classList.remove('hidden')">
            Tambah Data
        </button>
    </div>

    <!-- Modal -->
    <div id="modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h1 class="text-xl font-bold mb-4">Tambah Ibadah</h1>
            <form action="" method="post" class="space-y-4">
                <label class="block">Tanggal:</label>
                <input type="date" name="tanggal" required class="w-full p-2 border rounded">
                
                <label class="block">Sholat Wajib (0-5):</label>
                <input type="number" name="sholat" min="0" max="5" required class="w-full p-2 border rounded">

                <label class="block flex items-center">
                    <input type="checkbox" name="puasa" class="mr-2"> Puasa
                </label>

                <label class="block">Sedekah (Rp):</label>
                <input type="number" name="sedekah" min="0" class="w-full p-2 border rounded">

                <label class="block">Tadarus (Halaman):</label>
                <input type="number" name="tadarus" min="0" class="w-full p-2 border rounded">
            
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="document.getElementById('modal').classList.add('hidden')">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Riwayat Ibadah -->
    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Riwayat Ibadah</h2>
        <table class="w-full border border-gray-300">
            <tr class="bg-gray-200">
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Sholat</th>
                <th class="border p-2">Puasa</th>
                <th class="border p-2">Sedekah</th>
                <th class="border p-2">Tadarus</th>
                <th class="border p-2">Aksi</th>
            </tr>
            <?php
            $conn = new mysqli("localhost", "root", "", "jurnal_ibadah");
            $result = $conn->query("SELECT * FROM ibadah ORDER BY tanggal DESC");
            while ($row = $result->fetch_assoc()) { ?>
                <tr class="text-center">
                    <td class="border p-2"><?= $row['tanggal'] ?></td>
                    <td class="border p-2"><?= $row['sholat'] ?>x</td>
                    <td class="border p-2"><?= $row['puasa'] ? "✅" : "❌" ?></td>
                    <td class="border p-2">Rp<?= number_format($row['sedekah']) ?></td>
                    <td class="border p-2"><?= $row['tadarus'] ?> halaman</td>
                    <td class="border p-2">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-500">Edit</a> |
                        <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-500">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
