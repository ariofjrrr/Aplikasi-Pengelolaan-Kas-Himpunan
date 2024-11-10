<?php
include 'koneksi.php';
$id = $_GET['id'];
$query = "DELETE FROM transaksi WHERE id = '$id'";

if ($conn->query($query) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}
?>
