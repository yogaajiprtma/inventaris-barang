<?php
include_once 'header.php';

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Data Peminjaman Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item active">Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-15">
                <div class="row">

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown" title="Pilih Filter pada Table"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Tanggal Pinjam</h6>
                                    </li>
                                    <form method="post">
                                        <li title="Semua data"><button class="dropdown-item <?php if (isset($_POST['filter-all'])) {
                                                                                                echo "active";
                                                                                            } ?>" name="filter-all">Semua</button></li>

                                        <li title="Hari <?= $today_indo ?> ( <?= $currentdate ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-today'])) {
                                                                                                                                        echo "active";
                                                                                                                                    } ?>" name="filter-today">Hari Ini</button></li>

                                        <li title="Minggu ini ( <?= $filter_upweek ?> - <?= $filter_endweek ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-week'])) {
                                                                                                                                                    echo "active";
                                                                                                                                                } ?>" name="filter-week">Minggu Ini</button></li>

                                        <li title="Bulan <?= $currentmonth ?> ( <?= $filter_upmonth ?> - <?= $filter_endmonth ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-month'])) {
                                                                                                                                                                        echo "active";
                                                                                                                                                                    } ?>" name="filter-month">Bulan Ini</button></li>

                                        <li title="Tahun <?= $currentyear ?> ( <?= $filter_upyear ?> - <?= $filter_endyear ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-year'])) {
                                                                                                                                                                    echo "active";
                                                                                                                                                                } ?>" name="filter-year">Tahun Ini</button></li>
                                    </form>
                                </ul>
                            </div>

                            <div class="card-body">
                                <div class="card-body">
                                    <h5 class="card-title m-0">Tambah Data Peminjaman</h5>

                                    <?php
                                    if (isset($_POST['tanggal_awal'])) {
                                        $tanggal_awal = $_POST['tanggal_awal'];
                                        $tanggal_akhir = $_POST['tanggal_akhir'];
                                    }
                                    ?>

                                    <form method="post" <?php if (isset($_POST['adakan'])) {
                                                            echo "hidden";
                                                        } ?>>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <label class="form-label">Barang yang akan Dipinjam</label>
                                                    <select class="form-select" name="adakan_name" required>
                                                        <option value="" hidden>Tekan untuk memilih barang yang akan Dipinjam</option>
                                                        <?php
                                                        $adakan_query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori WHERE keluar='0' OR alasan2='pinjam' ");
                                                        while ($adakan = mysqli_fetch_array($adakan_query)) {
                                                            $stok = intval($adakan['kondisi_barang_bagus']) + intval($adakan['kondisi_barang_rusak']);
                                                        ?>
                                                            <option value="<?= $adakan['id_barang'] ?>"><?= $adakan['nama_barang'] ?> - <?= $adakan['nama_kategori'] ?> - <?= $stok ?> <?= $adakan['satuan'] ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button title="Cari laporan barang berdasarkan input Tanggal" name="adakan" class="btn btn-primary" style="margin-top: 30px;"><i class="bi bi-search"></i> Pinjam Barang</button>
                                                    <button title="Reset semua Input" type="reset" style="margin-top: 30px;" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form method="post" action="assets/CRUD/crud-pinjaman.php" <?php if (isset($_POST['adakan'])) {
                                                                                                    $id_adakan = $_POST['adakan_name'];

                                                                                                    $query_tambah = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori WHERE id_barang='$id_adakan' ");
                                                                                                    $tambah = mysqli_fetch_array($query_tambah);
                                                                                                    $stok = intval($tambah['kondisi_barang_bagus']) + intval($tambah['kondisi_barang_rusak']);

                                                                                                    echo "";
                                                                                                } else {
                                                                                                    echo "hidden";
                                                                                                } ?>>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Tanggal Pinjam</label>
                                                    <input type="date" name="tanggal_pinjam" class="form-control" value="<?php echo date("Y-m-d") ?>" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Nama Peminjam</label>
                                                    <input type="text" name="nama_peminjam" class="form-control" placeholder="Input Nama Peminjam" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <label class="form-label">Barang yang akan Dipinjam</label>
                                                    <input type="hidden" name="barang_terpinjam" value="<?= $tambah['id_barang'] ?>">
                                                    <input type="text" class="form-control" value="<?= $tambah['nama_barang'] ?> - <?= $tambah['nama_kategori'] ?> - <?= $stok ?> <?= $tambah['satuan'] ?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Stok Barang Bagus</label>
                                                    <input type="number" name="pinjaman_bagus" class="form-control" placeholder="( Stok Barang kondisi Bagus : <?= $tambah['kondisi_barang_bagus'] ?> )" max="<?= $tambah['kondisi_barang_bagus'] ?>">
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Stok Barang Rusak</label>
                                                    <input type="number" name="pinjaman_rusak" class="form-control" placeholder="( Stok Barang kondisi Rusak : <?= $tambah['kondisi_barang_rusak'] ?> )" max="<?= $tambah['kondisi_barang_rusak'] ?>">
                                                </div>
                                                <div class="col-lg-3">
                                                    <button title="Cari laporan barang berdasarkan input Tanggal" name="simpan-pinjam" class="btn btn-success" style="margin-top: 30px;">+ Pinjam Barang</button>
                                                    <a title="Reset semua Input" href="?page=pinjaman" style="margin-top: 30px;" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                </div>

                                <h5 class="card-title m-0">Daftar Semua Data Pinjaman
                                    <?php
                                    if (isset($_POST['tanggal_awal'])) {
                                        echo '> <small>' . $tanggal_awal . ' s/d ' . $tanggal_akhir . '</small>';
                                    } elseif (isset($_POST['filter-today'])) {
                                        echo '> <small> Hari ini ( Tanggal ' . $currentdateD . ' - ' . $today_indo . ' ) </small>';
                                    } elseif (isset($_POST['filter-week'])) {
                                        echo '> <small> Minggu ini ( ' . $filter_upweek . ' - ' . $filter_endweek . ' ) </small>';
                                    } elseif (isset($_POST['filter-month'])) {
                                        echo '> <small> Bulan ini ( ' . $currentyear . ' - ' . $currentmonth . ' ) </small>';
                                    } elseif (isset($_POST['filter-year'])) {
                                        echo '> <small> Tahun ini ( ' . $currentyear . ' ) </small>';
                                    }
                                    ?>

                                </h5>

                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal Pinjam</th>
                                            <th scope="col">Kode Pinjam</th>
                                            <th scope="col">Nama Peminjam</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Nama Kategori</th>
                                            <th scope="col">Detail Barang</th>
                                            <th scope="col">Barang Kembali</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (isset($_POST['filter-today'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE tanggal_pinjam='$currentdate' ");
                                        } elseif (isset($_POST['filter-week'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE tanggal_pinjam BETWEEN '$filter_upweek' AND '$filter_endweek' ");
                                        } elseif (isset($_POST['filter-month'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE tanggal_pinjam BETWEEN '$filter_upmonth' AND '$filter_endmonth' ");
                                        } elseif (isset($_POST['filter-year'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE tanggal_pinjam BETWEEN '$filter_upyear' AND '$filter_endyear' ");
                                        } elseif (isset($_POST['filter-all'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang ");
                                        } else {
                                            $query = mysqli_query($koneksi, "SELECT * FROM pinjam INNER JOIN barang ON pinjam.barang_terpinjam=barang.id_barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang ");
                                        }
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id = $data['barang_terpinjam'];
                                            $stok = intval($data['pinjaman_bagus']) + intval($data['pinjaman_rusak']);
                                        ?>
                                            <tr>

                                                <td><strong><?php echo $i++ ?></strong></td>
                                                <td><?php echo $data['tanggal_pinjam'] ?></td>
                                                <td><?php echo $data['kode_pinjam'] ?></td>
                                                <td><?php echo $data['nama_peminjam'] ?></td>
                                                <td><?php echo $data['nama_barang'] ?></td>
                                                <td><?php echo $data['nama_kategori'] ?></td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#detailbarang<?php echo $data['kode_barang'] ?>" class="btn btn-secondary btn-sm" title="Detail Informasi Barang"><i class="bi bi-chat-right-text"></i> Details</a>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#pinjambarang<?php echo $data['id_peminjam'] ?>" title="Tekan untuk melihat data Pinjaman"><i class="bi bi-person-lines-fill"></i> Terpinjam</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editpinjam<?php echo $data['id_peminjam'] ?>" title="Tekan untuk mengedit data Pinjaman"><i class="bi bi-card-checklist"></i> Pengembalian</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['id_peminjam'] ?>" title="Tekan untuk mengedit data Pinjaman">Edit</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Pinjam -->
                                            <div class="modal fade" id="edit<?php echo $data['id_peminjam'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Pinjaman Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-pinjaman.php">
                                                            <input type="hidden" name="id_peminjam" value="<?= $data['id_peminjam'] ?>">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Tanggal Pinjam</label>
                                                                        <input type="date" name="tanggal_pinjam" class="form-control" value="<?php echo $data['tanggal_pinjam'] ?>">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama Peminjam</label>
                                                                        <input type="text" name="nama_peminjam" class="form-control" value="<?php echo $data['nama_peminjam'] ?>">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label">Pengembalian stok barang terpinjam </label>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="mb-1">
                                                                        <label class="form-label">Berapa stok barang yang akan dikembalikan?</label>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                                                        <input type="number" name="pinjaman_bagus" class="form-control" value="<?= ($data['pinjaman_bagus'] == '' || $data['pinjaman_bagus'] == '0' ? '0' : $data['pinjaman_bagus']) ?>">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                                                        <input type="number" name="pinjaman_rusak" class="form-control" value="<?= ($data['pinjaman_rusak'] == '' || $data['pinjaman_rusak'] == '0' ? '0' : $data['pinjaman_rusak']) ?>">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label"><small>Satuan</small></label>
                                                                        <input type="text" class="form-control" value="<?= ucwords($data['satuan']) ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" title="Konfirmasi Edit data Pinjam Barang" class="btn btn-success" name="edit-pinjam">Konfirmasi</button>
                                                                        <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Akhir Modal Edit Pinjam-->

                                            <!-- Modal Pengembalian -->
                                            <div class="modal fade" id="editpinjam<?php echo $data['id_peminjam'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Pengembalian Pinjaman Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-pinjaman.php">
                                                            <input type="hidden" name="pinjam_bagus" value="<?= $data['pinjaman_bagus'] ?>">
                                                            <input type="hidden" name="pinjam_rusak" value="<?= $data['pinjaman_rusak'] ?>">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <input type="hidden" name="id_peminjam" value="<?= $data['id_peminjam'] ?>">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Tanggal Pinjam</label>
                                                                        <input type="date" class="form-control" value="<?php echo $data['tanggal_pinjam'] ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama barang</label>
                                                                        <input type="text" class="form-control" value="<?php echo $data['nama_peminjam'] ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label">Pengembalian stok barang terpinjam </label>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="mb-1">
                                                                        <label class="form-label">Berapa stok barang yang akan dikembalikan?</label>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                                                        <input type="number" name="pinjaman_bagus" class="form-control" value="" placeholder="( Stok terpinjam : <?= ($data['pinjaman_bagus'] == '' || $data['pinjaman_bagus'] == '0' ? '0' : $data['pinjaman_bagus']) ?> )" max="<?= (empty($data['pinjaman_bagus']) ? '0' : $data['pinjaman_bagus']) ?>">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                                                        <input type="number" name="pinjaman_rusak" class="form-control" value="" placeholder="( Stok terpinjam : <?= ($data['pinjaman_rusak'] == '' || $data['pinjaman_rusak'] == '0' ? '0' : $data['pinjaman_rusak']) ?> )" max="<?= (empty($data['pinjaman_rusak']) ? '0' : $data['pinjaman_rusak']) ?>">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label"><small>Satuan</small></label>
                                                                        <input type="text" class="form-control" value="<?= ucwords($data['satuan']) ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" title="Konfirmasi pengembalian Barang" class="btn btn-success" name="kembalikan-pinjaman">Konfirmasi</button>
                                                                        <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                                        <hr>
                                                                        <button type="submit" title="Konfirmasi pengembalian Semua Barang" class="btn btn-primary" name="kembalikan-semua-pinjaman">Kembalikan Semua</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Akhir Modal Pengembalian-->

                                            <!-- Modal Detail Pinjam -->
                                            <div class="modal fade" id="pinjambarang<?php echo $data['id_peminjam'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Pinjaman Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-4">
                                                                    <label class="form-label">Tanggal Pinjam</label>
                                                                    <input type="date" class="form-control" value="<?php echo $data['tanggal_pinjam'] ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label">Nama Peminjam</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data['nama_peminjam'] ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label">Nama Barang</label>
                                                                    <input type="text" class="form-control" value="<?php echo $data['nama_barang'] ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label">Stok Barang Terpinjam </label>
                                                                </div>
                                                                <hr>
                                                                <div class="mb-1">
                                                                    <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                                                    <input type="text" class="form-control" value="<?= (empty($data['pinjaman_bagus']) ? '--' : $data['pinjaman_bagus']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                                                    <input type="text" class="form-control" value="<?= (empty($data['pinjaman_rusak']) ? '--' : $data['pinjaman_rusak']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label"><small>Satuan</small></label>
                                                                    <input type="text" class="form-control" value="<?= ucwords($data['satuan']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Akhir Modal Detail Pinjam-->

                                            <!-- Modal Detail Barang-->
                                            <div class="modal fade" id="detailbarang<?php echo $data['kode_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="kode_barang" value="<?= $data['kode_barang'] ?>">
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="mb-4">
                                                                    <label class="form-label">Tanggal masuk</label>
                                                                    <input type="date" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?>" class="form-control" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label">Nama barang</label>
                                                                    <input type="text" name="nama_barang" value="<?= $data['nama_barang'] ?>" class="form-control" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label">Nama kategori</label>
                                                                    <input type="text" name="id_kategori" value="<?= $data['nama_kategori'] ?>" class="form-control" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label">Stok Barang </label>
                                                                </div>
                                                                <hr>
                                                                <div class="mb-1">
                                                                    <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                                                    <input type="text" name="kondisi_bagus" class="form-control" value="<?= (empty($data['kondisi_barang_bagus']) ? '--' : $data['kondisi_barang_bagus']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                                                    <input type="text" name="kondisi_rusak" class="form-control" value="<?= (empty($data['kondisi_barang_rusak']) ? '--' : $data['kondisi_barang_rusak']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <?php
                                                                    $cek_pinjam_query = mysqli_query($koneksi, "SELECT SUM(pinjaman_bagus) as pin_bagus,SUM(pinjaman_rusak) as pin_rusak FROM pinjam WHERE barang_terpinjam='$id' ");
                                                                    $cek = mysqli_fetch_array($cek_pinjam_query);
                                                                    ?>
                                                                    <label class="form-label"><small>Kondisi Barang Terpinjam</small></label>
                                                                    <input type="text" name="kondisi_rusak" class="form-control" value="<?= $cek['pin_bagus'] + $cek['pin_rusak'] ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-4">
                                                                    <label class="form-label"><small>Satuan</small></label>
                                                                    <input type="text" class="form-control" value="<?= ucwords($data['satuan']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <hr>
                                                                <div class="mb-4">
                                                                    <label class="form-label">Nama Ruangan</label>
                                                                    <input type="text" name="id_ruang" value="<?= $data['nama_ruang'] ?>" class="form-control" style="background-color: whitesmoke;" readonly>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal Detail Barang-->

                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->

                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>

    </div>
    </div>


</main><!-- End #main -->