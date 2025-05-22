<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include "koneksi/db.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Akun</h2>
        <div>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>
        <div class="mb-3">
            <label class="form-label">Foto Profil</label>
            <?php if(!empty($data['foto'])): ?>
                <div class="mb-2">
                    <img src="foto/<?= $data['foto'] ?>" width="100" height="100" class="rounded-circle">
                </div>
            <?php endif; ?>
            <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <button type="submit" name="update" class="btn btn-warning">Update</button>
        <a href="data_akun.php" class="btn btn-secondary">Kembali</a>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $username = $_POST['username'];
        
        // Handle file upload
        $foto = $data['foto'];
        if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "foto/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            // Hapus foto lama jika bukan default
            if ($foto != 'default.jpg') {
                unlink('foto/' . $foto);
            }
            $foto = time() . '_' . basename($_FILES["foto"]["name"]);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
        }
        
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET username='$username', password='$password', foto='$foto' WHERE id=$id");
        } else {
            mysqli_query($conn, "UPDATE users SET username='$username', foto='$foto' WHERE id=$id");
        }
        
        echo "<div class='alert alert-success mt-3'>Akun berhasil diupdate.</div>
        <script>
            alert('Akun Berhasil Diupdate');
            window.location.href = 'index.php';
        </script>";
    }
    ?>
</body>
</html>