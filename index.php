<?php 
include "koneksi/db.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Data Akun</h2>
    
    <a href="tambah.php" class="btn btn-primary mb-3">+ Tambah Akun</a>
    
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Foto Profil</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM users");
            
            while ($row = mysqli_fetch_assoc($result)) {
                $foto = !empty($row['foto']) ? $row['foto'] : 'default.jpg';
                echo "<tr>
                    <td>$no</td>
                    <td><img src='foto/$foto' width='50' height='50' class='rounded-circle'></td>
                    <td>{$row['username']}</td>
                    <td>
                        <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                        <a href='hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus akun ini?\")'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3">
        <a href="login.php" class="btn btn-primary">Login</a>
    </div>
</body>
</html>
