<?php
include_once 'header.php';
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Kategori</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Kategori</li>
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
                                <h5 class="card-title m-0">Daftar Kategori Barang</h5>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahKategori" title="Tambah Kategori Baru pada Barang">+ Tambah Kategori</button>

                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kategori</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $batas = 8;
                                        $i = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM kategori");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo "$i";
                                                                $i++ ?></th>
                                                <td><?php echo $data['nama_kategori'] ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editkategori<?php echo $data['id_kategori'] ?>" title="Edit Data Kategori">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapuskategori<?php echo $data['id_kategori'] ?>" title="Hapus Data Kategori">Hapus</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Ubah-->
                                            <div class="modal fade" id="editkategori<?php echo $data['id_kategori'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kategori</h1>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <form method="post" action="assets/CRUD/crud-kategori.php">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <input type="hidden" name="id_kategori" value="<?= $data['id_kategori'] ?>">
                                                                        <label class="form-label">Nama Kategori</label>
                                                                        <input type="text" name="nama_kategori" class="form-control" value="<?= $data['nama_kategori'] ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="simpan_edit">Simpan</button>
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
                                            <div class="modal fade" id="hapuskategori<?php echo $data['id_kategori'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Kategori</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-kategori.php">
                                                            <input type="hidden" name="id_kategori" value="<?= $data['id_kategori'] ?>">
                                                            <div class="modal-body">
                                                                <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data ini beserta barang-barang didalamnya? <br>
                                                                    <span class="text-danger"><strong><?= $data['nama_kategori'] ?></strong></span>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-primary" name="simpan_hapus">Yakin</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sebentar</button>
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
    <div class="modal fade" id="tambahKategori" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kategori</h1>
                        </div>
                    </div>
                </div>
                <form method="post" action="assets/CRUD/crud-kategori.php">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="text" name="nama_kategori" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                                <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                            </div>
                </form>
            </div>
        </div>
    </div>
    <!--Akhir Modal Tambah-->

    </div>
    </div>


</main><!-- End #main -->