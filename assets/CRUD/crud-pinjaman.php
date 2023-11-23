<?php
include "../../koneksi.php";

if (isset($_POST['kembalikan-pinjaman'])) {
    $id = $_POST['id_barang'];
    $id_p = $_POST['id_peminjam'];

    $pinjaman_bagus = intval($_POST['pinjaman_bagus']);
    $pinjaman_rusak = intval($_POST['pinjaman_rusak']);

    $cek_query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang WHERE barang_terpinjam='$id' ");
    $cek = mysqli_fetch_array($cek_query);

    $stok_bagus = intval($cek['pinjaman_bagus']);
    $stok_rusak = intval($cek['pinjaman_rusak']);
    $stok_pinjam_bagus = intval($cek['kondisi_barang_bagus']);
    $stok_pinjam_rusak = intval($cek['kondisi_barang_rusak']);

    $stok_akhir_bagus = $stok_pinjam_bagus + $pinjaman_bagus;
    $stok_akhir_rusak = $stok_pinjam_rusak + $pinjaman_rusak;

    $stok_akhir_pinjam_bagus = $stok_bagus - $pinjaman_bagus;
    $stok_akhir_pinjam_rusak = $stok_rusak - $pinjaman_rusak;

    if ($pinjaman_bagus == '' && $pinjaman_rusak = '' || empty($pinjaman_bagus) && empty($pinjaman_rusak)) {
        echo "<script>alert('Semua input Stok pengembalian masih Kosong!');location.href ='../../index.php?page=pinjaman';</script>";
    } else {
        if ($pinjaman_bagus == $stok_bagus && $pinjaman_rusak == $stok_rusak) {
            $query = mysqli_query($koneksi, "UPDATE barang SET kondisi_barang_bagus='$stok_akhir_bagus',kondisi_barang_rusak='$stok_akhir_rusak',alasan2='' WHERE id_barang='$id' ");
            $query2 = mysqli_query($koneksi, "UPDATE pinjam SET pinjaman_bagus='0',pinjaman_rusak='0' WHERE barang_terpinjam='$id' ");
            if ($query && $query2) {
                $query_last = mysqli_query($koneksi, "DELETE FROM pinjam WHERE id_peminjam='$id_p' ");

                if ($query_last) {
                    echo "<script>alert('Berhasil mengembalikan semua stok barang');location.href ='../../index.php?page=pinjaman';</script>";
                } else {
                    echo "<script>alert('Gagal mengembalikan stok barang');location.href ='../../index.php?page=pinjaman';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengembalikan stok barang');location.href ='../../index.php?page=pinjaman';</script>";
            }
        } else {
            $query = mysqli_query($koneksi, "UPDATE barang SET kondisi_barang_bagus='$stok_akhir_bagus',kondisi_barang_rusak='$stok_akhir_rusak' WHERE id_barang='$id' ");
            $query2 = mysqli_query($koneksi, "UPDATE pinjam SET pinjaman_bagus='$stok_akhir_pinjam_bagus',pinjaman_rusak='$stok_akhir_pinjam_rusak' WHERE barang_terpinjam='$id' ");
            if ($query && $query2) {
                echo "<script>alert('Berhasil mengembalikan stok barang');location.href ='../../index.php?page=pinjaman';</script>";
            } else {
                echo "<script>alert('Gagal mengembalikan stok barang');location.href ='../../index.php?page=pinjaman';</script>";
            }
        }
    }
}

if (isset($_POST['kembalikan-semua-pinjaman'])) {
    $id = $_POST['id_barang'];
    $id_p = $_POST['id_peminjam'];

    $stok_bagus = intval($_POST['pinjam_bagus']);
    $stok_rusak = intval($_POST['pinjam_rusak']);

    $cek_query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id' ");
    $cek = mysqli_fetch_array($cek_query);

    $stok_pinjam_bagus = intval($cek['kondisi_barang_bagus']);
    $stok_pinjam_rusak = intval($cek['kondisi_barang_rusak']);

    $akhir_bagus = $stok_pinjam_bagus + $stok_bagus;
    $akhir_rusak = $stok_pinjam_rusak + $stok_rusak;

    $query = mysqli_query($koneksi, "UPDATE barang SET kondisi_barang_bagus='$akhir_bagus',kondisi_barang_rusak='$akhir_rusak',alasan2='' WHERE id_barang='$id' ");

    if ($query) {
        $query_last = mysqli_query($koneksi, "DELETE FROM pinjam WHERE id_peminjam='$id_p' ");

        if ($query_last) {
            echo "<script>alert('Berhasil mengembalikan semua stok barang');location.href ='../../index.php?page=pinjaman';</script>";
        } else {
            echo "<script>alert('Gagal mengembalikan stok barang');location.href ='../../index.php?page=pinjaman';</script>";
        }
    }
}

if (isset($_POST['simpan-pinjam'])) {
    $id = $_POST['barang_terpinjam'];

    do {
        $kode = rand(100000, 999999);
        $cekk = mysqli_query($koneksi, "SELECT kode_pinjam FROM pinjam WHERE kode_pinjam='$kode' ");
        $cek2 = mysqli_num_rows($cekk);

        if ($cek2 == 1) {
            unset($kode);
        }
    } while (!isset($kode));

    $cek_query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id' ");
    $cek = mysqli_fetch_array($cek_query);

    $tanggal = $_POST['tanggal_pinjam'];
    $nama = $_POST['nama_peminjam'];
    $bagus = $_POST['pinjaman_bagus'];
    $rusak = $_POST['pinjaman_rusak'];

    $akhir_bagus = $cek['kondisi_barang_bagus'] - intval($bagus);
    $akhir_rusak = $cek['kondisi_barang_rusak'] - intval($rusak);

    if ($tanggal == '' || $nama == '' || $id == '' || $bagus == '' && $rusak == '') {
        echo "<script>alert('Tolong isi Semua Data yang Diperlukan!');location.href ='../../index.php?page=pinjaman';</script>";
    } else {
        $query_tam = mysqli_query($koneksi, "INSERT INTO pinjam (kode_pinjam,nama_peminjam,barang_terpinjam,pinjaman_bagus,pinjaman_rusak,tanggal_pinjam) VALUES ('$kode','$nama','$id','$bagus','$rusak','$tanggal') ");

        if ($query_tam) {
            $hapus = mysqli_query($koneksi, "UPDATE barang SET kondisi_barang_bagus='$akhir_bagus',kondisi_barang_rusak='$akhir_rusak',alasan2='pinjam' WHERE id_barang='$id' ");

            echo "<script>alert('Data pinjaman Berhasil ditambahkan');location.href ='../../index.php?page=pinjaman';</script>";
        } else {
            echo "<script>alert('Data pinjaman Gagal ditambahkan');location.href ='../../index.php?page=pinjaman';</script>";
        }
    }
}

if (isset($_POST['edit-pinjam'])) {
    $id = $_POST['id_barang'];
    $id_p = $_POST['id_peminjam'];

    $pinjaman_bagus = intval($_POST['pinjaman_bagus']);
    $pinjaman_rusak = intval($_POST['pinjaman_rusak']);

    $cek_query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang WHERE barang_terpinjam='$id' ");
    $cek = mysqli_fetch_array($cek_query);

    $pinjaman_bagus_awal = intval($cek['pinjaman_bagus']);
    $pinjaman_rusak_awal = intval($cek['pinjaman_rusak']);
    $stok_pinjam_bagus = intval($cek['kondisi_barang_bagus']);
    $stok_pinjam_rusak = intval($cek['kondisi_barang_rusak']);

    $bagus = $pinjaman_bagus_awal - $pinjaman_bagus;
    $rusak = $pinjaman_rusak_awal - $pinjaman_rusak;

    $bagus_akhir = $stok_pinjam_bagus + $bagus;
    $rusak_akhir = $stok_pinjam_rusak + $rusak;

    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $nama_peminjam = $_POST['nama_peminjam'];

    if ($pinjaman_bagus == '' && $pinjaman_rusak = '' || empty($pinjaman_bagus) && empty($pinjaman_rusak)) {
        echo "<script>alert('Semua input Stok pengembalian masih Kosong!');location.href ='../../index.php?page=pinjaman';</script>";
    } elseif ($pinjaman_bagus == $pinjaman_bagus_awal && $pinjaman_rusak == $pinjaman_rusak_awal) {
        $query2 = mysqli_query($koneksi, "UPDATE pinjam SET tanggal_pinjam='$tanggal_pinjam',nama_peminjam='$nama_peminjam' WHERE id_peminjam='$id_p' ");
        if ($query2) {
            echo "<script>alert('Berhasil mengubah data pinjaman barang');location.href ='../../index.php?page=pinjaman';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data pinjaman barang');location.href ='../../index.php?page=pinjaman';</script>";
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE barang SET kondisi_barang_bagus='$bagus_akhir',kondisi_barang_rusak='$rusak_akhir' WHERE id_barang='$id' ");
        $query2 = mysqli_query($koneksi, "UPDATE pinjam SET tanggal_pinjam='$tanggal_pinjam',nama_peminjam='$nama_peminjam',pinjaman_bagus='$pinjaman_bagus',pinjaman_rusak='$pinjaman_rusak' WHERE id_peminjam='$id_p' ");
        if ($query && $query2) {
            echo "<script>alert('Berhasil mengubah data pinjaman barang');location.href ='../../index.php?page=pinjaman';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data pinjaman barang');location.href ='../../index.php?page=pinjaman';</script>";
        }
    }
}
