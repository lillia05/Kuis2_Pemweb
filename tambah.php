<?php 
include "koneksi/db.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Tambah Akun Baru</h2>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        // Handle file upload
        $foto = 'default.jpg';
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "foto/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $foto = time() . '_' . basename($_FILES["foto"]["name"]);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }
        
        mysqli_query($conn, "INSERT INTO users (username, password, foto) VALUES ('$username', '$password', '$foto')");
        
        echo "<div class='alert alert-success mt-3'>Akun berhasil dibuat.</div>
        <script>
            alert('Akun Berhasil Ditambah');
            window.location.href = 'index.php';
        </script>";
    }
    ?>
</body>
</html>