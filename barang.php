<?php
include_once 'header.php';
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Barang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">Barang</li>
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
                                <h5 class="card-title m-0">Daftar Barang</h5>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahbarang" title="Tambah Data Barang Baru">+ Tambah Barang</button>

                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal masuk</th>
                                            <th scope="col">Kode Barang</th>
                                            <th scope="col">Nama Barang</th>
                                            <th scope="col">Nama Kategori</th>
                                            <th scope="col">Stok dan Kondisi Barang</th>
                                            <th scope="col">satuan</th>
                                            <th scope="col">Ruangan</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM barang INNER JOIN kategori ON barang.id_kategori=kategori.id_kategori INNER JOIN ruang ON barang.id_ruang=ruang.id_ruang WHERE keluar='0' OR alasan2='pinjam' ");

                                        while ($data = mysqli_fetch_array($query)) {
                                            $id = $data['id_barang'];
                                            $stok = $data['kondisi_barang_bagus'] + $data['kondisi_barang_rusak'];
                                        ?>
                                            <tr>

                                                <td><strong><?php echo $i++ ?></strong></td>
                                                <td><?php echo $data['tanggal_masuk'] ?></td>
                                                <td><?php echo $data['kode_barang'] ?></td>
                                                <td><?php echo $data['nama_barang'] ?></td>
                                                <td><?php echo $data['nama_kategori'] ?></td>
                                                <td>
                                                    <span class="btn btn-success btn-sm"> Bagus : <?php echo (empty($data['kondisi_barang_bagus']) ? '--' : $data['kondisi_barang_bagus']) ?></span>
                                                    <span class="btn btn-danger btn-sm"> Rusak : <?php echo (empty($data['kondisi_barang_rusak']) ? '--' : $data['kondisi_barang_rusak']) ?></span>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#pinjambarang<?php echo $id ?>" title="Tekan untuk melihat data Pinjaman" <?= ($data['alasan2'] == 'pinjam' ? '' : 'hidden') ?>><i class="bi bi-person-lines-fill"></i> Terpinjam</button>
                                                </td>
                                                <td><?php echo ucwords($data['satuan']) ?></td>
                                                <td><?php echo $data['nama_ruang'] ?></td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editbarang<?php echo $data['id_barang'] ?>" title="Edit Informasi Barang">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusbarang<?php echo $data['id_barang'] ?>" title="Hapus Informasi Barang">Hapus</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Detail Pinjam -->
                                            <div class="modal fade" id="pinjambarang<?php echo $id ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                            <?php
                                                            $cek_pinjam_query = mysqli_query($koneksi, "SELECT * FROM pinjam WHERE barang_terpinjam='$id' ");
                                                            while ($cek = mysqli_fetch_array($cek_pinjam_query)) {
                                                            ?>
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="text-center">
                                                                            <h3>Data Pinjaman</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Tanggal Pinjam</label>
                                                                        <input type="date" class="form-control" value="<?php echo $cek['tanggal_pinjam'] ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama Peminjam</label>
                                                                        <input type="text" class="form-control" value="<?php echo $cek['nama_peminjam'] ?>" style="background-color: whitesmoke;" readonly>
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
                                                                        <label class="form-label"><small>Kondisi Barang Bagus Terpinjam</small></label>
                                                                        <input type="text" class="form-control" value="<?= (empty($cek['pinjaman_bagus']) ? '--' : $cek['pinjaman_bagus']) ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Rusak Terpinjam</small></label>
                                                                        <input type="text" class="form-control" value="<?= (empty($cek['pinjaman_rusak']) ? '--' : $cek['pinjaman_rusak']) ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label"><small>Satuan</small></label>
                                                                        <input type="text" class="form-control" value="<?= ucwords($data['satuan']) ?>" style="background-color: whitesmoke;" readonly>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Akhir Modal Detail Pinjam-->

                                            <!-- Modal Ubah-->
                                            <div class="modal fade" id="editbarang<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Barang</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-barang.php">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Tanggal masuk</label>
                                                                        <input type="date" name="tanggal_masuk" value="<?= $data['tanggal_masuk'] ?>" class="form-control">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama barang</label>
                                                                        <input type="text" name="nama_barang" value="<?= $data['nama_barang'] ?>" class="form-control">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama kategori</label>
                                                                        <select type="text" name="id_kategori" value="<?= $data['id_kategori'] ?>" class="form-select">
                                                                            <?php
                                                                            $query1 = mysqli_query($koneksi, "SELECT * FROM  kategori");
                                                                            while ($kategori = mysqli_fetch_array($query1)) {
                                                                            ?>
                                                                                <option value="<?php echo $kategori['id_kategori'] ?>" <?php echo ($data['id_kategori'] == $kategori['id_kategori'] ? 'selected' : '') ?>><?php echo $kategori['nama_kategori'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label">Stok Barang </label>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                                                        <input type="number" name="kondisi_bagus" class="form-control" value="<?= $data['kondisi_barang_bagus'] ?>" placeholder="Input Stok dengan Kondisi Barang Bagus">
                                                                    </div>
                                                                    <div class="mb-1">
                                                                        <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                                                        <input type="number" name="kondisi_rusak" class="form-control" value="<?= $data['kondisi_barang_rusak'] ?>" placeholder="Input Stok dengan Kondisi Barang Rusak">
                                                                    </div>
                                                                    <div class="mb-4">
                                                                        <label class="form-label"><small>Satuan</small></label>
                                                                        <select type="text" name="satuan" value="<?= $data['satuan'] ?>" class="form-select">
                                                                            <option value="kg" <?php echo ($data['satuan'] == 'kg' ? 'selected' : '') ?>>Kg</option>
                                                                            <option value="pack" <?php echo ($data['satuan'] == 'pack' ? 'selected' : '') ?>>Pack</option>
                                                                            <option value="unit" <?php echo ($data['satuan'] == 'unit' ? 'selected' : '') ?>>Unit</option>
                                                                            <option value="buah" <?php echo ($data['satuan'] == 'buah' ? 'selected' : '') ?>>Buah</option>
                                                                            <option value="pasang" <?php echo ($data['satuan'] == 'pasang' ? 'selected' : '') ?>>Pasang</option>
                                                                            <option value="lembar" <?php echo ($data['satuan'] == 'lembar' ? 'selected' : '') ?>>Lembar</option>
                                                                            <option value="ton" <?php echo ($data['satuan'] == 'ton' ? 'selected' : '') ?>>Ton</option>
                                                                        </select>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="mb-4">
                                                                        <label class="form-label">Nama Ruangan</label>
                                                                        <select type="text" name="id_ruang" value="<? $data['id_ruang'] ?>" class="form-select">
                                                                            <?php
                                                                            $query3 = mysqli_query($koneksi, "SELECT * FROM ruang");
                                                                            while ($ruang = mysqli_fetch_array($query3)) {
                                                                            ?>
                                                                                <option value="<?php echo $ruang['id_ruang'] ?>" <?php echo ($data['id_ruang'] == $ruang['id_ruang'] ? 'selected' : '') ?>><?php echo $ruang['nama_ruang'] ?></option>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="bedit">Simpan</button>
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
                                            <div class="modal fade" id="hapusbarang<?php echo $data['id_barang'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                        <form method="post" action="assets/CRUD/crud-barang.php">
                                                            <input type="hidden" name="id_barang" value="<?= $data['id_barang'] ?>">
                                                            <div class="modal-body">
                                                                <h5 cl class="text-center">Apakah Yakin ingin Menghapus Data Barang ini? <br>
                                                                    <span class="text-danger"><strong><?= $data['nama_barang'] ?></strong> - <?= $data['nama_kategori'] ?> - <?= $stok ?> <?= $data['satuan'] ?> </span>
                                                                </h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="bhapus">Iya Yakin!</button>
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

    <!-- Modal tambah -->
    <div class="modal fade" id="tambahbarang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Barang</h1>
                        </div>
                    </div>
                </div>
                <form method="post" action="assets/CRUD/crud-barang.php">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <label class="form-label">Tanggal masuk</label>
                                <input type="date" name="tanggal_masuk" class="form-control" value="<?php echo date("Y-m-d") ?>">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nama barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Input Nama barang!">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nama kategori</label>
                                <select type="text" name="id_kategori" class="form-select">
                                    <option value="" hidden></option>
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT * FROM  kategori");
                                    while ($data = mysqli_fetch_array($query)) {
                                    ?>
                                        <option value="<?php echo $data['id_kategori'] ?>"><?php echo $data['nama_kategori'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label class="form-label">Stok Barang </label>
                            </div>
                            <hr>
                            <div class="mb-1">
                                <label class="form-label"><small>Kondisi Barang Bagus</small></label>
                                <input type="number" name="kondisi_bagus" class="form-control" placeholder="Input Stok dengan Kondisi Barang Bagus">
                            </div>
                            <div class="mb-1">
                                <label class="form-label"><small>Kondisi Barang Rusak</small></label>
                                <input type="number" name="kondisi_rusak" class="form-control" placeholder="Input Stok dengan Kondisi Barang Rusak">
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><small>Satuan</small></label>
                                <select type="text" name="satuan" class="form-select">
                                    <option value="" hidden></option>
                                    <option value="kg">Kg</option>
                                    <option value="pack">Pack</option>
                                    <option value="unit">Unit</option>
                                    <option value="buah">Buah</option>
                                    <option value="pasang">Pasang</option>
                                    <option value="lembar">Lembar</option>
                                    <option value="ton">Ton</option>
                                </select>
                            </div>
                            <hr>
                            <div class="mb-4">
                                <label class="form-label">Nama Ruangan</label>
                                <select type="text" name="id_ruang" value="<? $data['id_ruang'] ?>" class="form-select">
                                    <option value="" hidden></option>
                                    <?php
                                    $query2 = mysqli_query($koneksi, "SELECT * FROM ruang");
                                    while ($ruang = mysqli_fetch_array($query2)) {
                                    ?>
                                        <option value="<?php echo $ruang['id_ruang'] ?>"><?php echo $ruang['nama_ruang'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
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