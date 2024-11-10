<?php
include 'koneksi.php';

// Ambil data transaksi
$query = "SELECT transaksi.*, anggota.nama AS nama_anggota 
          FROM transaksi 
          LEFT JOIN anggota ON transaksi.id_anggota = anggota.id";
$result = $conn->query($query);

// Hitung total kas masuk dan keluar
$totalMasuk = 0;
$totalKeluar = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['tipe'] == 'masuk') {
        $totalMasuk += $row['jumlah'];
    } else {
        $totalKeluar += $row['jumlah'];
    }
}

// Ambil kembali data transaksi untuk ditampilkan
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelolaan Kas Kelas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header>
        <h1>Pengelolaan Kas HMIF</h1>
        <p>Selamat Datang di Pengelolaan Kas.</p>
        <div class="actions">
            <a href="tambah.php" class="btn btn-primary">Tambah Transaksi</a>
            <a href="anggota.php" class="btn btn-secondary">Data Anggota</a>
        </div>
    </header>

    <main>
        <section class="summary">
            <div class="card masuk">
                <h2><i class="icon fa fa-arrow-down"></i> Total Kas Masuk</h2>
                <p>Rp <?= number_format($totalMasuk, 0, ',', '.') ?></p>
            </div>
            <div class="card keluar">
                <h2><i class="icon fa fa-arrow-up"></i> Total Kas Keluar</h2>
                <p>Rp <?= number_format($totalKeluar, 0, ',', '.') ?></p>
            </div>
            <div class="card saldo">
                <h2><i class="icon fa fa-wallet"></i> Saldo Kas</h2>
                <p>Rp <?= number_format($totalMasuk - $totalKeluar, 0, ',', '.') ?></p>
                <div class="progress-bar">
                    <div class="progress" style="width: <?= ($totalMasuk - $totalKeluar) / $totalMasuk * 100 ?>%;"></div>
                </div>
            </div>
        </section>

        <section class="table-section">
            <h2>Data Transaksi</h2>
            <table id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Anggota</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Tipe</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='" . ($row['tipe'] == 'masuk' ? 'kas-masuk' : 'kas-keluar') . "'>
                                <td>{$no}</td>
                                <td>{$row['tanggal']}</td>
                                <td>{$row['nama_anggota']}</td>
                                <td>{$row['keterangan']}</td>
                                <td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>
                                <td>" . ucfirst($row['tipe']) . "</td>
                                <td>
                                    <a href='edit.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                    <a href='hapus.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus transaksi ini?\")'>Hapus</a>
                                </td>
                              </tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>