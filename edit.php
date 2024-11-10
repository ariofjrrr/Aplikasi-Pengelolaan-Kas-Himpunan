<?php
include 'koneksi.php';

// Cek apakah ada parameter ID pada URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data transaksi berdasarkan ID dengan prepared statement
    $stmt = $conn->prepare("SELECT transaksi.*, anggota.nama AS nama_anggota 
                            FROM transaksi 
                            LEFT JOIN anggota ON transaksi.id_anggota = anggota.id
                            WHERE transaksi.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Jika transaksi tidak ditemukan
    if (!$row) {
        echo "Transaksi tidak ditemukan.";
        exit;
    }
    $stmt->close();
}

// Proses update data jika formulir disubmit
if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    $id_anggota = $_POST['id_anggota'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $tipe = $_POST['tipe'];

    // Sanitasi keterangan untuk menghindari karakter berbahaya
    $keterangan = htmlspecialchars($keterangan, ENT_QUOTES, 'UTF-8');  // Melakukan encoding karakter khusus seperti petik satu

    // Query untuk memperbarui data transaksi dengan prepared statement
    $updateStmt = $conn->prepare("UPDATE transaksi SET tanggal = ?, id_anggota = ?, keterangan = ?, jumlah = ?, tipe = ? WHERE id = ?");
    $updateStmt->bind_param("sssisi", $tanggal, $id_anggota, $keterangan, $jumlah, $tipe, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Transaksi berhasil diperbarui!'); window.location = 'index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $updateStmt->close();
}

// Ambil data anggota untuk pilihan select
$anggotaQuery = "SELECT * FROM anggota";
$anggotaResult = $conn->query($anggotaQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Edit Transaksi</h1>
        </header>

        <section class="form-container">
            <form action="edit.php?id=<?= $row['id'] ?>" method="POST">
                <label for="tanggal">Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $row['tanggal'] ?>" required>

                <label for="id_anggota">Nama Anggota:</label>
                <select name="id_anggota" required>
                    <?php while ($anggota = $anggotaResult->fetch_assoc()): ?>
                        <option value="<?= $anggota['id'] ?>" <?= $anggota['id'] == $row['id_anggota'] ? 'selected' : '' ?>>
                            <?= $anggota['nama'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="keterangan">Keterangan:</label>
                <input type="text" name="keterangan" value="<?= htmlspecialchars($row['keterangan'], ENT_QUOTES) ?>" required>

                <label for="jumlah">Jumlah:</label>
                <input type="number" name="jumlah" value="<?= $row['jumlah'] ?>" required>

                <label for="tipe">Tipe:</label>
                <select name="tipe" required>
                    <option value="masuk" <?= $row['tipe'] == 'masuk' ? 'selected' : '' ?>>Kas Masuk</option>
                    <option value="keluar" <?= $row['tipe'] == 'keluar' ? 'selected' : '' ?>>Kas Keluar</option>
                </select>

                <button type="submit" name="submit">Update Transaksi</button>
            </form>
        </section>

        <section class="back-button">
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </section>
    </div>
</body>
</html>

<style>
/* Reset dan Gaya Dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --text-color: #333;
    --background-color: #f9f9f9;
    --light-gray: #f1f1f1;
}

/* Container Utama */
.container {
    width: 90%;
    max-width: 1200px;
    margin: auto;
}

/* Header */
header {
    text-align: center;
    margin-bottom: 30px;
}

header h1 {
    font-size: 2em;
    color: white;
    background-color: var(--primary-color);
    padding: 20px;
    border-radius: 8px;
}

/* Formulir */
.form-container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

.form-container form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-container label {
    font-weight: bold;
    color: var(--text-color);
}

.form-container input,
.form-container select {
    padding: 10px;
    font-size: 1em;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

.form-container button {
    background-color: var(--primary-color);
    color: white;
    padding: 12px;
    font-size: 1.1em;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.form-container button:hover {
    background-color: #2980b9;
}

/* Tombol Kembali */
.back-button {
    text-align: center;
    margin-top: 20px;
}

.back-button .btn {
    padding: 12px 20px;
    font-size: 1.1em;
    background-color: var(--secondary-color);
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.back-button .btn:hover {
    background-color: #27ae60;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}

table th,
table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: var(--primary-color);
    color: white;
    font-size: 1.1em;
}

table td {
    font-size: 1em;
}

table td a {
    color: var(--primary-color);
    text-decoration: none;
    margin-right: 10px;
}

table td a:hover {
    text-decoration: underline;
}

/* Responsif */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
    }
    
    table th, table td {
        padding: 8px;
        font-size: 14px;
    }
    
    .form-container input,
    .form-container select,
    .form-container button {
        font-size: 1em;
    }
}

.success {
    color: green;
    font-weight: bold;
    margin-top: 10px;
}

.error {
    color: red;
    font-weight: bold;
    margin-top: 10px;
}

</style>