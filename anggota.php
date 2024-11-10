<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <h1>Data Anggota</h1>
        </header>

        <!-- Tombol Aksi -->
        <section class="actions">
            <a href="tambah_anggota.php" class="btn btn-primary">Tambah Anggota</a>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </section> 

        <!-- Tabel Data Anggota -->
        <section class="table-section-anggota">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM anggota";
                    $result = $conn->query($query);
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['alamat']}</td>
                                <td>{$row['no_hp']}</td>
                                <td>
                                    <a href='edit_anggota.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                    <a href='hapus_anggota.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Anda yakin ingin menghapus anggota ini?\")'>Hapus</a>
                                </td>
                              </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
<style>
    /* Reset Dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Warna Dasar */
:root {
    --primary-color: #3498db;
    --secondary-color: #2ecc71;
    --warning-color: #f1c40f;
    --danger-color: #e74c3c;
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

/* Tombol Aksi */
.actions {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.actions .btn {
    padding: 12px 20px;
    text-decoration: none;
    color: white;
    border-radius: 5px;
    font-size: 1.1em;
    text-align: center;
    transition: background-color 0.3s ease;
}

.btn-primary { background-color: var(--primary-color); }
.btn-secondary { background-color: var(--secondary-color); }

.btn:hover {
    opacity: 0.9;
}

/* Judul Daftar Anggota dengan Background Biru */
.section-title {
    background-color: var(--primary-color);
    color: white;
    padding: 15px;
    text-align: center;
    margin-bottom: 20px;
    border-radius: 8px;
}

/* Tabel Data Anggota */
.table-section-anggota {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    font-size: 1em;
}

table th {
    background-color: var(--primary-color);
    color: white;
    text-align: center;
}

table tbody tr:nth-child(even) {
    background-color: var(--light-gray);
}

table tbody tr:hover {
    background-color: #eaf6ff;
}

/* Tombol Edit dan Hapus */
.btn-edit {
    background-color: var(--warning-color);
    padding: 8px 15px;
    font-size: 1em;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    transition: background-color 0.3s ease;
}

.btn-delete {
    background-color: var(--danger-color);
    padding: 8px 15px;
    font-size: 1em;
    border-radius: 5px;
    text-decoration: none;
    color: white;
    transition: background-color 0.3s ease;
}

.btn-edit:hover {
    background-color: #d4ac0d;
}

.btn-delete:hover {
    background-color: #c0392b;
}

/* Responsif untuk Tabel */
@media (max-width: 768px) {
    .actions .btn {
        padding: 10px 15px;
        font-size: 1em;
    }

    table th, table td {
        font-size: 0.9em;
        padding: 10px;
    }

    table {
        font-size: 0.9em;
    }
}

</style>