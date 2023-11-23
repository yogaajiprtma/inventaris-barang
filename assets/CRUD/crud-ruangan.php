<?php
include "../../koneksi.php";

if (isset($_POST['simpan-ruangan'])) {
    $nama_ruang = $_POST['nama_ruangan'];
    $lokasi_ruang = $_POST['lokasi_ruangan'];
    $query = mysqli_query($koneksi, "INSERT INTO ruang (nama_ruang,lokasi_ruang) VALUES('$nama_ruang','$lokasi_ruang')");

    if ($query) {
        $_SESSION['status'] = "Data Berhasil Ditambahkan";
        echo "<script>alert('Data Berhasil Ditambahkan'); location.href ='../../index.php?page=ruangan';</script>";
    }
}

if (isset($_POST['edit-ruangan'])) {
    $id = $_POST['id_ruang'];
    $nama_ruang = $_POST['nama_ruangan'];
    $lokasi_ruang = $_POST['lokasi_ruangan'];
    $query = mysqli_query($koneksi, "UPDATE ruang SET nama_ruang='$nama_ruang',lokasi_ruang='$lokasi_ruang' WHERE id_ruang='$id' ");

    $_SESSION['status'] = "Data Berhasil Ditambahkan";
    if ($query) {
        echo "<script>alert('Data Berhasil Ditambahkan');location.href ='../../index.php?page=ruangan';</script>";
    }
}

if (isset($_POST['hapus-ruangan'])) {
    $id = $_POST['id_ruang'];
    $query = mysqli_query($koneksi, "DELETE FROM ruang WHERE id_ruang='$id'");

    $_SESSION['status'] = "Data Berhasil Dihapus";
    if ($query) {
        echo "<script>alert('Data Berhasil Dihapus');location.href ='../../index.php?page=ruangan';</script>";
    }
}

?>