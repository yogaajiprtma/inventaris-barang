<?php
include_once 'header.php';
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Laporan Barang Keluar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item">Laporan</li>
                <li class="breadcrumb-item active" >Laporan Barang Keluar</li>
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
                                        <h6>Tanggal Keluar</h6>
                                    </li>
                                    <form method="post">
                                        <li title="Semua data"><button class="dropdown-item <?php if (isset($_POST['filter-all'])) {echo "active";} ?>" name="filter-all">Semua</button></li>

                                        <li title="Hari <?= $today_indo ?> ( <?= $currentdate ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-today'])) {echo "active";} ?>" name="filter-today">Hari Ini</button></li>

                                        <li title="Minggu ini ( <?= $filter_upweek ?> - <?= $filter_endweek ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-week'])) {echo "active";} ?>" name="filter-week">Minggu Ini</button></li>

                                        <li title="Bulan <?= $currentmonth ?> ( <?= $filter_upmonth ?> - <?= $filter_endmonth ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-month'])) {echo "active";} ?>" name="filter-month">Bulan Ini</button></li>

                                        <li title="Tahun <?= $currentyear ?> ( <?= $filter_upyear ?> - <?= $filter_endyear ?> )"><button class="dropdown-item <?php if (isset($_POST['filter-year'])) {echo "active";} ?>" name="filter-year">Tahun Ini</button></li>
                                    </form>
                                </ul>
                            </div>

                            <div class="card-body">

                            <div class="card-body">
                                    <h5 class="card-title m-0"> Input Tanggal Laporan (Tanggal Keluar)</h5>

                                    <?php  
                                    if (isset($_POST['tanggal_awal'])) {
                                        $tanggal_awal = $_POST['tanggal_awal'];
                                        $tanggal_akhir = $_POST['tanggal_akhir'];
                                    }
                                    ?>

                                    <form method="post">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <label class="form-label">Tanggal Awal</label>
                                                    <input type="date" name="tanggal_awal" class="form-control" value="<?php echo ($tanggal_awal ? $tanggal_awal : '') ?>" required>
                                                </div>
                                                <div class="col-lg-4">
                                                    <label class="form-label">Tanggal Akhir</label>
                                                    <input type="date" name="tanggal_akhir" class="form-control" value="<?php echo ($tanggal_akhir ? $tanggal_akhir : '') ?>" required>
                                                </div>
                                                <div class="col-lg-3">
                                                    <button title="Cari laporan barang berdasarkan input Tanggal" name="cari-tanggal" class="btn btn-primary" style="margin-top: 30px;"><i class="bi bi-search"></i></button>
                                                    <button title="Refresh Page" type="reset" onclick="location.href='?page=laporan-barang-keluar'" style="margin-top: 30px;" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    </form>
                                </div>

                                <a style="float: right; margin-top: 20px;" target="_blank" class="btn btn-primary btn-sm" href="cetak-laporan-keluar.php<?php  
                                    if (isset($_POST['tanggal_awal'])) {
                                        echo '?print=tanggal&awal=' . $tanggal_awal . '&akhir=' . $tanggal_akhir ;

                                    }elseif (isset($_POST['filter-today'])) {
                                        echo '?print=day' ;

                                    }elseif (isset($_POST['filter-week'])) {
                                        echo '?print=week' ;

                                    }elseif (isset($_POST['filter-month'])) {
                                        echo '?print=month' ;

                                    }elseif (isset($_POST['filter-year'])) {
                                        echo '?print=year' ;

                                    }else{
                                        echo '?print=all' ;
                                    }
                                    ?>
                                    "><i class="bi bi-printer-fill"></i> Print Data pada Table</a>

                                <label style="float: right; margin-top: 20px; margin-right: 10px;"><big><big>|</big></big></label>
                                <label style="float: right; margin-top: 20px; margin-right: 10px;" data-bs-toggle="modal" data-bs-target="#semuapilihan"><a class="btn btn-secondary btn-sm"><i class="bi bi-check2-all"></i> Opsi Semua Data</a></label>
                                <label style="float: right; margin-top: 20px; margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#hapussemuapilihan"><a class="btn btn-danger btn-sm"><i class="bi bi-arrow-down-right-circle"></i> Hapus Data Terpilih</a></label>
                                <label style="float: right; margin-top: 20px; margin-right: 5px;" data-bs-toggle="modal" data-bs-target="#pulihkansemuapilihan"><a class="btn btn-success btn-sm"><i class="bi bi-arrow-down-right-circle"></i> Pulihkan Data Terpilih</a></label>

                                <h5 class="card-title m-0">Riwayat Barang Keluar 
                                    <?php 
                                    if (isset($_POST['tanggal_awal'])) {
                                        echo '> <small>' . $tanggal_awal . ' s/d ' . $tanggal_akhir . '</small>' ;

                                    }elseif (isset($_POST['filter-today'])) {
                                        echo '> <small> Hari ini ( Tanggal ' . $currentdateD . ' - ' . $today_indo . ' ) </small>' ;

                                    }elseif (isset($_POST['filter-week'])) {
                                        echo '> <small> Minggu ini ( ' . $filter_upweek . ' - ' . $filter_endweek . ' ) </small>' ;

                                    }elseif (isset($_POST['filter-month'])) {
                                        echo '> <small> Bulan ini ( ' . $currentyear . ' - ' . $currentmonth . ' ) </small>' ;

                                    }elseif (isset($_POST['filter-year'])) {
                                        echo '> <small> Tahun ini ( ' . $currentyear . ' ) </small>' ;

                                    }
                                    ?>
                                    
                                </h5>

                                <form method="post" action="assets/CRUD/crud-laporan-keluar.php" id="form">
                                <?php
                                    if (isset($_POST['filter-today'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar='$currentdate' ");

                                    }elseif (isset($_POST['filter-week'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upweek' AND '$filter_endweek' ");

                                    }elseif (isset($_POST['filter-month'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upmonth' AND '$filter_endmonth' ");

                                    }elseif (isset($_POST['filter-year'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upyear' AND '$filter_endyear' ");

                                    }elseif (isset($_POST['filter-all'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' ");

                                    }elseif (isset($_POST['cari-tanggal'])) {
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

                                    }else{
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' ");
                                    }
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <input type="checkbox" class="checkbox" name="select_id[]" id="select_id_<?= $data['id_barang'] ?>" value="<?= $data['id_barang'] ?>" hidden>
                                    <?php
                                    }
                                    ?>
                                    <button type="submit" name="select_pulih" id="select_pulih" hidden>OK</button>
                                    <button type="submit" name="select_hapus" id="select_hapus" hidden>hapus</button>
                                    <button type="submit" name="semua_pulih" id="semua_pulih" hidden>hapus</button>
                                    <button type="submit" name="semua_hapus" id="semua_hapus" hidden>hapus</button>
                                    </form>

                                    <!-- Modal Pulihkan Pilihan-->
                                    <div class="modal fade" id="pulihkansemuapilihan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                        <div class="text-center">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Pulihkan Data Barang Terpilih</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 cl class="text-center">Apakah Yakin ingin Memulihkan Semua Data Barang ini?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <label class="btn btn-success" for="select_pulih">Iya Yakin!</label>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal Pulihkan Pilihan-->

                                    <!-- Modal Hapus Pilihan-->
                                    <div class="modal fade" id="hapussemuapilihan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                        <div class="text-center">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data Barang Terpilih</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 cl class="text-center">Apakah Yakin ingin Menghapus Semua Data Barang ini?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <label class="btn btn-success" for="select_hapus">Iya Yakin!</label>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal Hapus Pilihan-->

                                    <!-- Modal Semua Pilihan-->
                                    <div class="modal fade" id="semuapilihan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                        <div class="text-center">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Pilih Opsi untuk semua data</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 cl class="text-center">Silahkan memilih Opsi untuk semua data pada pada laporan barang keluar</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <label class="btn btn-success" data-bs-toggle="modal" data-bs-target="#semuapilihan-pulih">Pulihkan Semua Data</label>
                                                            <label class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#semuapilihan-hapus">Hapus Semua Data</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal Semua Pilihan Pulih-->

                                    <!-- Modal Semua Pilihan-->
                                    <div class="modal fade" id="semuapilihan-pulih" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                        <div class="text-center">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Apakah anda yakin?</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 cl class="text-center text-success">Apakah anda benar yakin ingin memulihkan semua data barang keluar?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <label class="btn btn-success" for="semua_pulih">Yakin!</label>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal Semua Pilihan Pulih-->

                                    <!-- Modal Semua Pilihan Hapus-->
                                    <div class="modal fade" id="semuapilihan-hapus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                        <div class="text-center">
                                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Apakah anda yakin?</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 cl class="text-center text-danger">Apakah anda benar yakin ingin menghapus semua data barang keluar?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <label class="btn btn-success" for="semua_hapus">Yakin!</label>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Akhir Modal Semua Pilihan Hapus-->

                                <table class="table table-border datatable" id="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Select</th>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal masuk</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Nama Kategori</th>
                                            <th scope="col">Ruangan</th>
                                            <th scope="col">Tanggal Keluar</th>
                                            <th scope="col">Alasan</th>
                                            <th scope="col">Detail Barang</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php                                        
                                        $i = 1;
                                        if (isset($_POST['filter-today'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar='$currentdate' ");

                                        }elseif (isset($_POST['filter-week'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upweek' AND '$filter_endweek' ");

                                        }elseif (isset($_POST['filter-month'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upmonth' AND '$filter_endmonth' ");

                                        }elseif (isset($_POST['filter-year'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$filter_upyear' AND '$filter_endyear' ");

                                        }elseif (isset($_POST['filter-all'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' ");

                                        }elseif (isset($_POST['cari-tanggal'])) {
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' AND tanggal_keluar BETWEEN '$tanggal_awal' AND '$tanggal_akhir' ");

                                        }else{
                                            $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='1' ");
                                        }
                                        while ($data = mysqli_fetch_array($query)) {
                                            $id = $data['id_barang'];
                                            $stok = $data['kondisi_barang_bagus'] + $data['kondisi_barang_rusak'];
                                        ?>
                                            <tr>
                                                <td><label for="select_id_<?= $data['id_barang'] ?>" onclick="if (this.innerHTML == innerSquare) {this.innerHTML = innerCheck;}else{this.innerHTML = innerSquare;}"><i class="bi bi-square"></i></label></td>
                                                <td><strong><?php echo $i++ ?></strong></td>
                                                <td><?php echo $data['tanggal_masuk'] ?></td>
                                                <td><?php echo $data['kode_barang'] ?></td>
                                                <td><?php echo $data['nama_barang'] ?></td>
                                                <td><?php echo $data['nama_kategori'] ?></td>
                                                <td><?php echo $data['nama_ruang'] ?></td>
                                                <td><?php echo ($data['alasan2'] == 'pinjam' ? '--' : $data['tanggal_keluar']) ?></td>
                                                <td>
                                                    <?php 
                                                    if ($data['keluar'] == '1' && $data['alasan'] == 'hapus') {
                                                        echo '<span class="btn btn-danger btn-sm">Terhapus</span>';                                               
                                                    }elseif ($data['alasan2'] == 'pinjam'){
                                                        echo '<span class="btn btn-warning btn-sm">Terpinjam</span>';
                                                    }else{
                                                        echo '<span class="btn btn-success btn-sm">Ada</span>';
                                                    } 
                                                    ?>
                                                </td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#detailbarang<?php echo $data['id_barang'] ?>" class="btn btn-secondary btn-sm" title="Detail Informasi Barang"><i class="bi bi-chat-right-text"></i> Details</a>
                                                </td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#pulihkanbarang<?php echo $data['id_barang'] ?>" class="btn btn-success btn-sm" title="Detail Informasi Barang"><i class="bi bi-arrow-down-right-circle"></i></i> Pulihkan</a>

                                                    <a data-bs-toggle="modal" data-bs-target="#hapushistory<?php echo $data['id_barang'] ?>" class="btn btn-danger btn-sm" title="Detail Informasi Barang"><i class="bi bi-trash"></i> Hapus</a>
                                                </td>
                                            </tr>    

                                            <!-- Modal Detail Barang-->
                                            <div class="modal fade" id="detailbarang<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                        <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
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
                                                                </div><div class="mb-1" <?= ($data['alasan2'] == '' ? 'hidden' : '' ) ?>>
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

                                            <!-- Modal Pulihkan Barang-->
                                            <div class="modal fade" id="pulihkanbarang<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Pulihkan Data Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-laporan-keluar.php">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <input type="hidden" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?>">
                                                            <input type="hidden" name="nama_barang" value="<?= $data['nama_barang'] ?>">
                                                            <input type="hidden" name="id_kategori" value="<?= $data['id_kategori'] ?>">
                                                            <input type="hidden" name="kondisi_bagus" value="<?= $data['kondisi_barang_bagus'] ?>">
                                                            <input type="hidden" name="kondisi_rusak" value="<?= $data['kondisi_barang_rusak'] ?>">
                                                            <input type="hidden" name="satuan" value="<?= $data['satuan'] ?>">
                                                            <input type="hidden" name="id_ruang" value="<?= $data['id_ruang'] ?>">
                                                            <div class="modal-body">
                                                                <h5 cl class="text-center">Apakah Yakin ingin Memulihkan Data Barang ini? <br>
                                                                    <span class="text-success"><?= $data['nama_barang'] ?> - <?= $data['nama_kategori'] ?> - <?= $stok ?> <?= $data['satuan'] ?> </span>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="pulihkan-barang">Iya Yakin!</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal Pulihkan Barang-->

                                            <!-- Modal Hapus-->
                                            <div class="modal fade" id="hapushistory<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-laporan-keluar.php">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <div class="modal-body">
                                                                <h5 cl class="text-center">Apakah Yakin ingin Menghapus History Data Barang ini? <br>
                                                                <span class="text-danger"><strong><?= $data['nama_barang'] ?></strong> - <?= $data['nama_kategori'] ?> - <?= $stok ?> <?= $data['satuan'] ?> </span>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="hapus-history">Iya Yakin!</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal Hapus-->

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

    <script src="assets/js/laporan-barang-keluar/script.js"></script>

</main><!-- End #main -->