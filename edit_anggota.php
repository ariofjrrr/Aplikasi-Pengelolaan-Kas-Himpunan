<?php
include 'koneksi.php';

// Cek apakah ada parameter ID pada URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data anggota berdasarkan ID
    $query = "SELECT * FROM anggota WHERE id = '$id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();

    // Jika anggota tidak ditemukan
    if (!$row) {
        echo "Anggota tidak ditemukan.";
        exit;
    }
}

// Proses update data anggota
if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    // Query untuk memperbarui data anggota
    $updateQuery = "UPDATE anggota SET nama = '$nama', alamat = '$alamat', no_hp = '$no_hp' WHERE id = '$id'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Data anggota berhasil diperbarui!'); window.location = 'anggota.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
        <!-- Header Section -->
        <header>
            <h1>Edit Anggota</h1>
        </header>

        <form class="form-container"action="edit_anggota.php?id=<?= $row['id'] ?>" method="POST">
            <label for="nama">Nama Anggota:</label>
            <input type="text" name="nama" value="<?= $row['nama'] ?>" required>

            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" value="<?= $row['alamat'] ?>" required>

            <label for="no_hp">NO HP:</label>
            <input type="text" name="no_hp" value="<?= $row['no_hp'] ?>" required>

            <button type="submit" name="submit">Update Anggota</button>
        </form>
        <div class="back-button">
            <a href="anggota.php" class="btn">Kembali</a>
        </div>
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

</style>