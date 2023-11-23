<?php
include "../../koneksi.php";

if (isset($_POST['pulihkan-barang'])) {
    $id_barang = $_POST['id_barang'];

    $query = mysqli_query($koneksi, "UPDATE barang SET keluar='0', tanggal_keluar='', alasan='' WHERE id_barang='$id_barang' ");

    if ($query) {
        echo '<script>alert("Berhasil Memulihkan Data Barang!"); location.href="../../index.php?page=barang"</script>';
    } else {
        echo '<script>alert("Gagal Memulihkan Data Barang!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }

}

if (isset($_POST['hapus-history'])) {
    $id_barang = $_POST['id_barang'];

    $query = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang='$id_barang' ");

    if ($query) {
        echo '<script>alert("Berhasil Menghapus Data History!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';       
    } else {
        echo '<script>alert("Gagal Menghapus Data History!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }

}

if (isset($_POST['select_pulih'])) {
    $id_barang_array = $_POST['select_id'];

    $id_barang = implode(',', $id_barang_array);

    $query = mysqli_query($koneksi, "UPDATE barang SET keluar='0', tanggal_keluar='', alasan='' WHERE id_barang IN($id_barang) ");

    if ($query) {
        echo '<script>alert("Berhasil Memulihkan Semua Data Barang yang telah Dipilih!"); location.href="../../index.php?page=barang"</script>';
    } else {
        echo '<script>alert("Gagal Memulihkan Semua Data Barang yang telah Dipilih!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }
}

if (isset($_POST['select_hapus'])) {
    $id_barang_array = $_POST['select_id'];

    $id_barang = implode(',', $id_barang_array);

    $query = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang IN($id_barang) ");

    if ($query) {
        echo '<script>alert("Berhasil Menghapus Semua Data Barang yang telah Dipilih!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    } else {
        echo '<script>alert("Gagal Menghapus Semua Data Barang yang telah Dipilih!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }
}

if (isset($_POST['semua_pulih'])) {
    $query = mysqli_query($koneksi, "UPDATE barang SET keluar='0', tanggal_keluar='', alasan='' WHERE keluar='1' ");

    if ($query) {
        echo '<script>alert("Berhasil Memulihkan Semua Data Barang Keluar!"); location.href="../../index.php?page=barang"</script>';
    } else {
        echo '<script>alert("Gagal Memulihkan Semua Data Barang Keluar!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }
}

if (isset($_POST['semua_hapus'])) {
    $query = mysqli_query($koneksi, "DELETE FROM barang WHERE keluar='1' ");

    if ($query) {
        echo '<script>alert("Berhasil Menghapus Semua Data Barang Keluar!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    } else {
        echo '<script>alert("Gagal Menghapus Semua Data Barang Keluar!"); location.href="../../index.php?page=laporan-barang-keluar"</script>';
    }
}
?>