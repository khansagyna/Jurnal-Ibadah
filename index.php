<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login/login_page.php");
    exit();
}

include 'config.php';

// Ambil user_id dari session
$user_id = $_SESSION["user_id"];

// Query untuk mengambil hanya data user yang sedang login
$query = "SELECT * FROM ibadah WHERE user_id = ? ORDER BY tanggal DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $tanggal = $_POST['tanggal'];
    $sholat = $_POST['sholat'];
    $puasa = isset($_POST['puasa']) ? 1 : 0;
    $sedekah = $_POST['sedekah'];
    $tadarus = $_POST['tadarus'];

    if ($id) {
        // Update data berdasarkan ID dan user_id
        $stmt = $conn->prepare("UPDATE ibadah SET tanggal=?, sholat=?, puasa=?, sedekah=?, tadarus=? WHERE id=? AND user_id=?");
        $stmt->bind_param("siiiiii", $tanggal, $sholat, $puasa, $sedekah, $tadarus, $id, $user_id);
    } else {
        // Insert data baru
        $stmt = $conn->prepare("INSERT INTO ibadah (user_id, tanggal, sholat, puasa, sedekah, tadarus) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiiii", $user_id, $tanggal, $sholat, $puasa, $sedekah, $tadarus);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Ibadah</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body style="background-color: #CAE0BC;">
    
    <div class="utama">
        <div>
<h3 class="slmt font-bold py-1">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h3>
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center text-gray-700 mb-8">Jurnal Ibadah Ramadhan 📖</h2>

    <!-- Tombol Modal -->
    <div class="flex justify-between">
        <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded mb-4" onclick="document.getElementById('modal').classList.remove('hidden')">
            Tambah Data
        </button>
        <a href="logout.php" class="ms-5 mb-4 px-4 py-2 bg-red-600 text-white rounded flex items-center gap-2 hover:bg-red-700 transition">
  Logout <i class="fa-solid fa-right-from-bracket"></i>
</a>

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
    <div class="max-w-3xl mx-auto mt-2 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Riwayat Ibadah</h2>
    <?php
$query = "SELECT * FROM ibadah WHERE user_id = ? ORDER BY tanggal DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<table class="w-full border border-gray-300">
    <tr class="bg-gray-200 text-center">
        <th class="border p-2">Tanggal</th>
        <th class="border p-2">Sholat</th>
        <th class="border p-2">Puasa</th>
        <th class="border p-2">Sedekah</th>
        <th class="border p-2">Tadarus</th>
        <th class="border p-2">Aksi</th>
    </tr>
    <?php foreach ($data as $row) { ?>
        <tr class="text-center">
            <td class="border p-2"><?= htmlspecialchars($row['tanggal']) ?></td>
            <td class="border p-2"><?= htmlspecialchars($row['sholat']) ?>x</td>
            <td class="border p-2"><?= $row['puasa'] ? "✅" : "❌" ?></td>
            <td class="border p-2">Rp<?= number_format($row['sedekah']) ?></td>
            <td class="border p-2"><?= htmlspecialchars($row['tadarus']) ?> halaman</td>
            <td class="border p-2">
                <div class="flex justify-center gap-2">
                    <button class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600 flex items-center justify-center"
                        data-old-tanggal="<?= htmlspecialchars($row['tanggal']) ?>"
                        data-tanggal="<?= htmlspecialchars($row['tanggal']) ?>"
                        data-sholat="<?= htmlspecialchars($row['sholat']) ?>"
                        data-puasa="<?= htmlspecialchars($row['puasa']) ?>"
                        data-sedekah="<?= htmlspecialchars($row['sedekah']) ?>"
                        data-tadarus="<?= htmlspecialchars($row['tadarus']) ?>"
                        onclick="openEditModal(this)">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <a href="hapus.php?tanggal=<?= urlencode($row['tanggal']) ?>" 
                        class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600 flex items-center justify-center"
                        onclick="return confirm('Apakah Anda yakin ingin menghapus data pada tanggal <?= htmlspecialchars($row['tanggal']) ?>?')">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </td>
        </tr>
    <?php } ?>
</table>

</div>

    <!-- Modal Edit -->
    <div id="editModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-xl font-bold mb-4">Edit Ibadah</h1>
        <form action="edit.php" method="post" class="space-y-4">
            <!-- Input untuk menyimpan tanggal lama -->
            <input type="hidden" name="old_tanggal" id="oldTanggal">

            <!-- Tanggal Baru -->
            <label class="block">Tanggal:</label>
            <input type="date" name="tanggal" id="editTanggal" required class="w-full p-2 border rounded">

            <!-- Sholat -->
            <label class="block">Sholat Wajib (0-5):</label>
            <input type="number" name="sholat" id="editSholat" min="0" max="5" required class="w-full p-2 border rounded">

            <!-- Puasa -->
            <label class="block flex items-center">
                <input type="checkbox" name="puasa" id="editPuasa" class="mr-2"> Puasa
            </label>

            <!-- Sedekah -->
            <label class="block">Sedekah (Rp):</label>
            <input type="number" name="sedekah" id="editSedekah" min="0" class="w-full p-2 border rounded">

            <!-- Tadarus -->
            <label class="block">Tadarus (Halaman):</label>
            <input type="number" name="tadarus" id="editTadarus" min="0" class="w-full p-2 border rounded">

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>
</div>
<script src="https://kit.fontawesome.com/c1808f546b.js" crossorigin="anonymous"></script>
<script>
function openEditModal(button) {
    // Ambil data dari tombol edit
    document.getElementById("oldTanggal").value = button.getAttribute("data-old-tanggal")
    document.getElementById("editTanggal").value = button.getAttribute("data-tanggal");
    document.getElementById("editSholat").value = button.getAttribute("data-sholat");
    document.getElementById("editSedekah").value = button.getAttribute("data-sedekah");
    document.getElementById("editTadarus").value = button.getAttribute("data-tadarus");

    // Cek status puasa
    let puasa = button.getAttribute("data-puasa") == "1";
    document.getElementById("editPuasa").checked = puasa;

    // Tampilkan modal
    document.getElementById("editModal").classList.remove("hidden");
}

function closeEditModal() {
    document.getElementById("editModal").classList.add("hidden");
}
</script>

</body>
</html>
