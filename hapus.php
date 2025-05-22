<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include "koneksi/db.php";

// Debug: Cek apakah ID diterima
if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

// Debug: Cek koneksi database
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Hapus foto jika bukan default
$result = mysqli_query($conn, "SELECT foto FROM users WHERE id=$id");
if (!$result) {
    die("Error mengambil data: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);
if ($row && $row['foto'] != 'default.jpg') {
    $foto_path = 'foto/' . $row['foto'];
    if (file_exists($foto_path)) {
        unlink($foto_path);
    }
}

// Hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM users WHERE id=$id");

if ($delete) {
    echo "<script>
        alert('Data berhasil dihapus!');
        window.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menghapus data: " . mysqli_error($conn) . "');
        window.location.href = 'index.php';
    </script>";
}
?>