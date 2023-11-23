<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $query = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES('$nama_kategori')");

    if ($query) {
        $_SESSION['status'] = "Data Berhasil Ditambahkan";
        echo "<script>alert('Data Berhasil Ditambahkan');location.href ='index.php?page=kategori';</script>";
    }
}
