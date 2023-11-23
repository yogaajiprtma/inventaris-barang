<?php
include_once 'header.php';
if (isset($_POST['ruangan'])) {
    $ruangan = $_POST['ruangan'];
} else {
    $ruangan = '';
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Daftar Barang </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="?page=ruangan">Ruangan</a></li>
                <li class="breadcrumb-item active">Daftar Barang</li>
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

                            <div class="filter" style="margin-right: 2%;">
                                <form action="" method="post">
                                    <select class="form-select" name="ruangan">
                                        <option value="" hidden>Pilih Ruangan</option>
                                        <?php
                                        $query = mysqli_query($koneksi, "SELECT * FROM ruang");
                                        while ($ruang = mysqli_fetch_array($query)) {
                                        ?>
                                            <option value="<?php echo $ruang['nama_ruang'] ?>" <?php echo ($ruang['nama_ruang'] == $ruangan ? 'selected' : '') ?>><?= $ruang['nama_ruang'] ?></option>
                                        <?php

                                        }
                                        ?>
                                    </select>
                                    <button class="btn btn-light mt-2"><i class="bi bi-search"></i></button>
                                    <button type="reset" onclick="location.href='?page=daftar-barang'" class="btn btn-light mt-2"><i class="bi bi-arrow-clockwise"></i></button>
                                </form>
                            </div>

                            <div class="card-body">
                                <table class="table table-border datatable">
                                    <thead>
                                        <h1 class="text-center mt-3"> Ruangan <?php echo $ruangan  ?> </h1>
                                        <br><br>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Tanggal masuk</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Nama Kategori</th>
                                            <th scope="col">Detail Barang</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_POST['ruangan'])) {
                                            $ruangan = $_POST['ruangan'];
                                            $i = 1;
                                            $query = mysqli_query($koneksi, "SELECT * FROM ruang INNER JOIN barang ON ruang.id_ruang=barang.id_ruang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori WHERE alasan!='hapus' AND nama_ruang='$ruangan'");
                                            while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><strong><?php echo $i++ ?></strong></td>
                                                <td><?php echo $data['kode_barang'] ?></td>
                                                <td><?php echo $data['tanggal_masuk'] ?></td>
                                                <td><?php echo $data['nama_barang'] ?></td>
                                                <td><?php echo $data['nama_kategori'] ?></td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#detailbarang<?php echo $data['id_barang'] ?>" class="btn btn-secondary btn-sm" title="Detail Informasi Barang"><i class="bi bi-chat-right-text"></i> Details</a>
                                                </td>
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
                                            </tr>  
                                            
                                            <!-- Modal Detail Barang-->
                                            <div class="modal fade" id="detailbarang<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <?php $id = $data['id_barang'] ?>
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
                                                                    <label class="form-label"><small>Kondisi Bagus</small></label>
                                                                    <input type="text" name="kondisi_bagus" class="form-control" value="<?= (empty($data['kondisi_barang_bagus']) ? '--' : $data['kondisi_barang_bagus']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <label class="form-label"><small>Kondisi Rusak</small></label>
                                                                    <input type="text" name="kondisi_rusak" class="form-control" value="<?= (empty($data['kondisi_barang_rusak']) ? '--' : $data['kondisi_barang_rusak']) ?>" style="background-color: whitesmoke;" readonly>
                                                                </div>
                                                                <div class="mb-1" <?= ($data['alasan2'] == '' ? 'hidden' : '' ) ?>>
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