<?php
include "../../koneksi.php";

if (isset($_POST['bsimpan'])) {
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $kondisi_bagus = $_POST['kondisi_bagus'];
    $kondisi_rusak = $_POST['kondisi_rusak'];
    $satuan = $_POST['satuan'];
    $id_ruang = $_POST['id_ruang'];

    do {
        $kode = rand(100000,999999);
        $cek = mysqli_query($koneksi, "SELECT kode_barang FROM barang WHERE kode_barang='$kode' ");
        $cek2 = mysqli_num_rows($cek);

        if ($cek2 == 1) {
            unset($kode);
        }

    } while (!isset($kode));

    if ($tanggal_masuk == '' || $nama_barang == '' || $id_kategori == '' || $satuan == '' || $id_ruang == '') {
        echo '<script>alert("Mohon isi Semua Data Barang!"); location.href="../../index.php?page=barang"</script>';

    }elseif ($kondisi_bagus == '0' && $kondisi_rusak == '0' || $kondisi_bagus == '' && $kondisi_rusak == '' || $kondisi_bagus == '0' && $kondisi_rusak == '' || $kondisi_bagus == '' && $kondisi_rusak == '0') {
        echo '<script>alert("Mohon isi Salah satu Stok Barang!"); location.href="../../index.php?page=barang"</script>';

    }else{
        $simpan = mysqli_query($koneksi, "INSERT INTO barang (kode_barang,tanggal_masuk,nama_barang,id_kategori,kondisi_barang_bagus,kondisi_barang_rusak,satuan,id_ruang,keluar) VALUES('$kode','$tanggal_masuk','$nama_barang','$id_kategori','$kondisi_bagus','$kondisi_rusak','$satuan','$id_ruang','0')");
        if ($simpan) {
            echo '<script>alert("Berhasil Menambahkan Data Barang!"); location.href="../../index.php?page=barang"</script>';
        } else {
            echo '<script>alert("Gagal Menambahkan Data Barang!"); location.href="../../index.php?page=barang"</script>';
        }
    }
}

if (isset($_POST['bedit'])) {
    $id_barang = $_POST['id_barang'];

    $tanggal_masuk = $_POST['tanggal_masuk'];
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $kondisi_bagus = $_POST['kondisi_bagus'];
    $kondisi_rusak = $_POST['kondisi_rusak'];
    $satuan = $_POST['satuan'];
    $id_ruang = $_POST['id_ruang'];

    if ($tanggal_masuk == '' || $nama_barang == '' || $id_kategori == '' || $satuan == '' || $id_ruang == '') {
        echo '<script>alert("Mohon isi Semua Data Barang!"); location.href="../../index.php?page=barang"</script>';

    }elseif ($kondisi_bagus == '0' && $kondisi_rusak == '0' || $kondisi_bagus == '' && $kondisi_rusak == '' || $kondisi_bagus == '0' && $kondisi_rusak == '' || $kondisi_bagus == '' && $kondisi_rusak == '0') {
        echo '<script>alert("Mohon isi Salah satu Stok Barang!"); location.href="../../index.php?page=barang"</script>';

    }else{
        $edit = mysqli_query($koneksi, "UPDATE barang SET tanggal_masuk='$tanggal_masuk',nama_barang='$nama_barang',id_kategori='$id_kategori',kondisi_barang_bagus='$kondisi_bagus',kondisi_barang_rusak='$kondisi_rusak',satuan='$satuan',id_ruang='$id_ruang' WHERE id_barang='$id_barang'");
        if ($edit) {
            echo '<script>alert("Berhasil Ubah Data Barang!"); location.href="../../index.php?page=barang"</script>';
        } else {
            echo '<script>alert("Gagal Ubah Data Barang!"); location.href="../../index.php?page=barang"</script>';
        }
    }
}


if (isset($_POST['bhapus'])) {
    $id_barang = $_POST['id_barang'];

    date_default_timezone_set('Asia/Jakarta');
    $tanggal_keluar = date("Y-m-d");

    $cek_query = mysqli_query($koneksi, "SELECT * FROM pinjam WHERE barang_terpinjam='$id_barang' ");
    $cek = mysqli_num_rows($cek_query);

    if ($cek >= 1) {
        echo '<script>alert("Barang tidak bisa dihapus karena masih ada stok yang Terpinjam"); location.href="../../index.php?page=barang"</script>';
    }else{
        $query = mysqli_query($koneksi, "UPDATE barang SET keluar='1', tanggal_keluar='$tanggal_keluar', alasan='hapus' WHERE id_barang='$id_barang' ");

        if ($query) {
            echo '<script>alert("Berhasil Hapus Data Barang!"); location.href="../../index.php?page=barang"</script>';
        } else {
            echo '<script>alert("Gagal Hapus Data Barang!"); location.href="../../index.php?page=barang"</script>';
        }
    }
}
