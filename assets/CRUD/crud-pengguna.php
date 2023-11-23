<?php
include "../../koneksi.php";

if (isset($_POST['simpan-pengguna'])) {
    $username = $_POST['username'];
    $nama_user = $_POST['nama_user'];
    $hak_akses = $_POST['hak_akses'];
    $password = md5($_POST['password']);
    $konfirmasi_password_baru = md5($_POST['konfirmasi_password_baru']);

    do {
        $kode = rand(1000, 9999);
        $cekk = mysqli_query($koneksi, "SELECT kode_akun FROM user WHERE kode_akun='$kode' ");
        $cek2 = mysqli_num_rows($cekk);

        if ($cek2 == 1) {
            unset($kode);
        }
    } while (!isset($kode));

    if ($username == '' || $nama_user == '' || $hak_akses == '' || $password == '') {
        echo "<script>alert('Mohon Isi Data-Data yang Diperlukan!');location.href ='../../index.php?page=pengguna';</script>";
    } else {
        if ($password != $konfirmasi_password_baru) {
            echo "<script>alert('Password dan Konfirmasi Password tidak sama!');location.href ='../../index.php?page=pengguna';</script>";
        } else {
            if (isset($_FILES['foto'])) {
                $foto = $_FILES['foto']['name'];
                $foto_tmp = $_FILES['foto']['tmp_name'];

                $fotobaru = rand() . '_' . $foto;

                $path = "../img/avatars/" . $fotobaru;

                move_uploaded_file($foto_tmp, $path);

                $query = mysqli_query($koneksi, "INSERT INTO user (kode_akun,username,nama_user,hak_akses,password,foto) VALUES('$kode','$username','$nama_user','$hak_akses','$konfirmasi_password_baru','$fotobaru')");
                if ($query) {
                    echo "<script>alert('Data Berhasil Ditambahkan');location.href ='../../index.php?page=pengguna';</script>";
                } else {
                    echo "<script>alert('Data Gagal Ditambahkan');location.href ='../../index.php?page=pengguna';</script>";
                }
            } else {
                $query = mysqli_query($koneksi, "INSERT INTO user (kode_akun,username,nama_user,hak_akses,password) VALUES('$kode','$username','$nama_user','$hak_akses','$konfirmasi_password_baru')");
                // echo 'w';
                if ($query) {
                    echo "<script>alert('Data Berhasil Ditambahkan');location.href ='../../index.php?page=pengguna';</script>";
                } else {
                    echo "<script>alert('Data Gagal Ditambahkan');location.href ='../../index.php?page=pengguna';</script>";
                }
            }
        }
    }
}

if (isset($_POST['edit-pengguna'])) {
    $id = $_POST['id_user'];
    $username = $_POST['username'];
    $nama_user = $_POST['nama_user'];
    $hak_akses = $_POST['hak_akses'];
    $password = md5($_POST['password']);
    $konfirmasi_password_baru = md5($_POST['konfirmasi_password_baru']);

    if ($username == '' || $nama_user == '' || $hak_akses == '' || $password == '') {
        echo "<script>alert('Mohon Isi Data-Data yang Diperlukan!');location.href ='../../index.php?page=pengguna';</script>";
        // PASSWORD
    } elseif (!empty($_POST['password']) && isset($_FILES['foto'])) {
        $foto = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];

        $fotobaru = rand() . '_' . $foto;

        $path = "../img/avatars/" . $fotobaru;

        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");
        $data = mysqli_fetch_array($query);

        if (move_uploaded_file($foto_tmp, $path)) {
            if (is_file("../img/avatars/" . $data['foto']))
                unlink("../img/avatars/" . $data['foto']);

            $query = mysqli_query($koneksi, "UPDATE user SET nama_user='$nama_user',username='$username',hak_akses='$hak_akses',password='$password',foto='$fotobaru' WHERE id_user = '$id'");

            if ($query) {
                echo "<script>alert('Data Berhasil Diupdate');location.href ='../../index.php?page=pengguna';</script>";
            } else {
                echo "<script>alert('Data Gagal Diupdate');location.href ='../../index.php?page=pengguna';</script>";
            }
        }

        if ($password != $konfirmasi_password_baru) {
            echo "<script>alert('Password dan Konfirmasi Password tidak sama!');location.href ='../../index.php?page=pengguna';</script>";
        }
    } elseif (!empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE user SET nama_user='$nama_user',username='$username',password='$password' WHERE id_user = '$id'");

        if ($query) {
            echo "<script>alert('Data Berhasil Diupdate');location.href ='../../index.php?page=pengguna';</script>";
        } else {
            echo "<script>alert('Data Gagal Diupdate');location.href ='../../index.php?page=pengguna';</script>";
        }

        if ($password != $konfirmasi_password_baru) {
            echo "<script>alert('Password dan Konfirmasi Password tidak sama!');location.href ='../../index.php?page=pengguna';</script>";
        }
        // END PASSWORD
    } else {
        if (isset($_FILES['foto'])) {
            $foto = $_FILES['foto']['name'];
            $foto_tmp = $_FILES['foto']['tmp_name'];

            $fotobaru = rand() . '_' . $foto;

            $path = "../img/avatars/" . $fotobaru;

            $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");
            $data = mysqli_fetch_array($query);

            if (move_uploaded_file($foto_tmp, $path)) {
                if (is_file("../img/avatars/" . $data['foto']))
                    unlink("../img/avatars/" . $data['foto']);

                $query = mysqli_query($koneksi, "UPDATE user SET nama_user='$nama_user',username='$username',hak_akses='$hak_akses',foto='$fotobaru' WHERE id_user = '$id'");

                if ($query) {
                    echo "<script>alert('Data Berhasil Diupdate');location.href ='../../index.php?page=pengguna';</script>";
                } else {
                    echo "<script>alert('Data Gagal Diupdate');location.href ='../../index.php?page=pengguna';</script>";
                }
            }
        } else {
            $query = mysqli_query($koneksi, "UPDATE user SET nama_user='$nama_user',username='$username' WHERE id_user = '$id'");

            if ($query) {
                echo "<script>alert('Data Berhasil Diupdate');location.href ='../../index.php?page=pengguna';</script>";
            } else {
                echo "<script>alert('Data Gagal Diupdate');location.href ='../../index.php?page=pengguna';</script>";
            }
        }
    }
}

if (isset($_POST['hapus-pengguna'])) {
    $id = $_POST['id_user'];

    $queryy = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user='$id'");
    $data = mysqli_fetch_array($queryy);

    $_SESSION['status'] = "Data Pengguna Berhasil Dihapus";
    if (is_file("../img/avatars/" . $data['foto'])) {
        $bruh = unlink("../img/avatars/" . $data['foto']);
        if ($bruh) {
            $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id'");
            if ($query) {
                echo "<script>alert('Data Pengguna Berhasil Dihapus');location.href ='../../index.php?page=pengguna';</script>";
            } else {
                echo "<script>alert('Data Pengguna Gagal Dihapus');location.href ='../../index.php?page=pengguna';</script>";
            }
        } else {
            echo "<script>alert('Data Pengguna Gagal Dihapus');location.href ='../../index.php?page=pengguna';</script>";
        }
    } else {
        $query = mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id'");
        if ($query) {
            echo "<script>alert('Data Pengguna Berhasil Dihapus');location.href ='../../index.php?page=pengguna';</script>";
        } else {
            echo "<script>alert('Data Pengguna Gagal Dihapus');location.href ='../../index.php?page=pengguna';</script>";
        }
    }
}
