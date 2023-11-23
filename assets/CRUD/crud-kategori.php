<?php
include "../../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $query = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES('$nama_kategori')");

    if ($query) {
        echo "<script>alert('Data Berhasil Ditambahkan'); location.href ='../../index.php?page=kategori';</script>";
    }
}

if (isset($_POST['simpan_edit'])) {
    $id = $_POST['id_kategori'];
    $nama_kategori = $_POST['nama_kategori'];
    $query = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$id' ");

    if ($query) {
        echo "<script>alert('Data Berhasil Ditambahkan');location.href ='../../index.php?page=kategori';</script>";
    }
}

if (isset($_POST['simpan_hapus'])) {
    $id = $_POST['id_kategori'];
    $query = mysqli_query($koneksi, "DELETE FROM kategori WHERE id_kategori='$id'");

    if ($query) {
        echo "<script>alert('Data Berhasil Dihapus');location.href ='../../index.php?page=kategori';</script>";
    }
}

?>