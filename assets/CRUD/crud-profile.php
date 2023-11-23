<?php
include "../../koneksi.php";
if (isset($_POST['simpan-edit-profile'])) {
    $nama = $_POST['nama_user'];
    $username = $_POST['username'];
    $id = $_SESSION['user']['id_user'];

    $queryfoto = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' ");
    $datafoto = mysqli_fetch_array($queryfoto);

    if (isset($_FILES['foto']) && $_FILES['foto']['size'] > 0) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        $fotobaru = rand() . '_' . $foto;

        $path = "../img/avatars/" . $fotobaru;

        $check = getimagesize($_FILES['foto']['tmp_name']);

        if ($check !== false) {
            if (move_uploaded_file($foto_tmp, $path)) {
                if (is_file("../img/avatars/" . $datafoto['foto']))
                    unlink("../img/avatars/" . $datafoto['foto']);

                $query = mysqli_query($koneksi, "UPDATE user SET username='$username', nama_user='$nama', foto='$fotobaru' WHERE id_user='$id' ");
                $session = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' ");

                if ($query) {
                    $_SESSION['user'] = mysqli_fetch_array($session);
                    echo "<script>alert('Data Berhasil Diubah'); location.href='../../index.php?page=profile&profile=index'</script>";
                } else {
                    echo "<script>alert('Data Gagal Diubah'); location.href='../../index.php?page=profile&profile=edit'</script>";
                }
            }
        } else {
            echo "<script>alert('File Bukan Foto'); location.href='../../index.php?page=profile&profile=edit'</script>";
        }
    }

    $query = mysqli_query($koneksi, "UPDATE user SET username='$username', nama_user='$nama' WHERE id_user='$id' ");
    $session = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' ");

    if ($query) {
        $_SESSION['user'] = mysqli_fetch_array($session);
        echo "<script>alert('Data Berhasil Diubah'); location.href='../../index.php?page=profile&profile=index'</script>";
    } else {
        echo "<script>alert('Data Gagal Diubah'); location.href='../../index.php?page=profile&profile=edit'</script>";
    }
}

if (isset($_POST['change-password'])) {
    $id = $_SESSION['user']['id_user'];
    $passwordlama = md5($_POST['password-lama']);
    $passwordbaru = md5($_POST['password-baru']);
    $konfirmasipassword = md5($_POST['konfirmasi-password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id' AND password='$passwordlama' ");
    $cek2 = mysqli_num_rows($cek);

    if ($cek2 == 1 && $passwordbaru == $konfirmasipassword) {
        $query = mysqli_query($koneksi, "UPDATE user SET password='$passwordbaru' WHERE id_user='$id' ");

        if ($query) {
            echo "<script>alert('Password Berhasil Diubah'); location.href='../../index.php?page=profile&profile=index'; </script>";
        }
    } else {
        echo "<script>alert('Password Lama atau Konfirmasi Password Salah'); location.href='../../index.php?page=profile&profile=pw'; </script>";
    }
}
