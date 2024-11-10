<?php
include 'koneksi.php';

// Cek apakah ada parameter ID pada URL
if (isset($_GET['id'])) {
    $id_anggota = $_GET['id'];

    // Query untuk menghapus anggota berdasarkan ID
    $queryHapus = "DELETE FROM anggota WHERE id = '$id_anggota'";

    $query = "DELETE FROM transaksi WHERE id_anggota = '$id_anggota'";

    if ($conn->query($query) === TRUE) {
        if ($conn->query($queryHapus) === TRUE) {
            // Jika berhasil dihapus, arahkan kembali ke halaman anggota
            echo "<script>alert('Anggota berhasil dihapus!'); window.location = 'anggota.php';</script>";
        } else {
            // echo "Error 123";
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Errrro";
        echo "Error: " . $conn->error;
    }


   
} else {
    // Jika tidak ada ID yang diterima di URL, arahkan ke halaman anggota
    echo "<script>alert('ID anggota tidak ditemukan!'); window.location = 'anggota.php';</script>";
}
?>
