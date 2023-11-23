<?php
include_once 'header.php';
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Ruangan</li>
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

                            <div class="card-body">
                                <h5 class="card-title m-0">Daftar Ruangan </h5>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahruangan">+ Tambah Ruangan</button>
                                <button onclick="location.href='?page=daftar-barang'" class="btn btn-success btn-sm">Daftar Barang</button>

                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">NO</th>
                                            <th scope="col">Nama Ruang</th>
                                            <th scope="col">Lokasi Ruang</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $batas = 8;
                                        $i = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM ruang");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i++ ?></td>
                                                <td><?php echo $data['nama_ruang'] ?></td>
                                                <td><?php echo $data['lokasi_ruang'] ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editruangan<?php echo $data['id_ruang'] ?>">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusruangan<?php echo $data['id_ruang'] ?>">Hapus</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Ubah-->
                                            <div class="modal fade" id="editruangan<?php echo $data['id_ruang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Ruangan</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-ruangan.php">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <input type="hidden" name="id_ruang" value="<?= $data['id_ruang'] ?>">
                                                                        <label class="form-label">Nama Ruangan</label>
                                                                        <input type="text" name="nama_ruangan" class="form-control" value="<?= $data['nama_ruang'] ?>">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lokasi Ruangan</label>
                                                                        <input type="text" name="lokasi_ruangan" class="form-control" value="<?= $data['lokasi_ruang'] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="edit-ruangan">Simpan</button>
                                                                        <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal Ubah-->

                                            <!-- Modal Hapus-->
                                            <div class="modal fade" id="hapusruangan<?php echo $data['id_ruang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Ruangan</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-ruangan.php">
                                                            <input type="hidden" name="id_ruang" value="<?= $data['id_ruang'] ?>">
                                                            <div class="modal-body">
                                                                <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Ruangan beserta Barang-Barang di dalamnya? <br>
                                                                    <span class="text-danger"><strong><?= $data['nama_ruang'] ?></strong> - <?= $data['lokasi_ruang'] ?></span>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="hapus-ruangan">Hapus</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keluar</button>
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

    <!-- Modal tambah -->
    <div class="modal fade" id="tambahruangan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Ruangan</h1>
                        </div>
                    </div>
                </div>
                <form method="post" action="assets/CRUD/crud-ruangan.php">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Nama Ruangan</label>
                                <input type="text" name="nama_ruangan" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Lokasi Ruangan</label>
                                <input type="text" name="lokasi_ruangan" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" name="simpan-ruangan">Simpan</button>
                                <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Akhir Modal Tambah-->

    </div>
    </div>


</main><!-- End #main -->