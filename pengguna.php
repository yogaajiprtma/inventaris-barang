<?php
include_once 'header.php';

if ($_SESSION['user']['hak_akses'] != 'superadmin') {
    echo "<script>alert('Page ini hanya bisa diakses oleh pengguna yang memiliki Hak Akses Super-Admin!');location.href ='logout.php';</script>";
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?page=dashboard">Home</a></li>
                <li class="breadcrumb-item active">Pengguna</li>
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
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title m-0"> Pengguna</h5>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahpengguna">+ Tambah Pengguna</button>

                                <table class="table table-border datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Kode Akun</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Nama Pengguna</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Hak Akses</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $batas = 8;
                                        $i = 1;
                                        $query = mysqli_query($koneksi, "SELECT * FROM user");
                                        while ($data = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <th scope="row"><?php echo "$i";
                                                                $i++ ?></th>
                                                <td><?php echo $data['kode_akun'] ?></td>
                                                <td>
                                                    <img src="assets/img/avatars/<?php echo $data['foto'] ?>" alt="<?php echo $data['foto'] ?>" class="rounded-circle" style="height:60px;width:60px;">
                                                </td>
                                                <td><?php echo $data['nama_user'] ?></td>
                                                <td><?php echo $data['username'] ?></td>
                                                <td><?php echo ($data['hak_akses'] == 'superadmin' ? 'Super-Admin' : 'Admin') ?></td>
                                                <td>
                                                    <a href="#edit-pengguna" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit-pengguna<?= $data['id_user'] ?>">Edit</a>
                                                    <a href="#hapus-pengguna" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus-pengguna<?= $data['id_user'] ?>">Hapus</button>
                                                </td>
                                            </tr>

                                            <!-- Modal Ubah-->
                                            <div class="modal fade" id="edit-pengguna<?= $data['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pengguna</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-pengguna.php" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                                                                        <label class="form-label">Username</label>
                                                                        <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" onkeypress="return event.which != 32" required>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nama Pengguna</label>
                                                                            <input type="text" name="nama_user" class="form-control" value="<?= $data['nama_user'] ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Password</label>
                                                                            <input type="password" id="password<?= $data['id_user'] ?>" autocomplete="new-password" name="password" class="form-control" maxlength="25" onkeypress="return event.which != 32">
                                                                            <span id="password-toggle<?= $data['id_user'] ?>"><i class="bi bi-eye"></i></span>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Konfirmasi Password Baru</label>
                                                                            <input type="password" id="konfirmasi_pwedit<?= $data['id_user'] ?>" autocomplete="new-password" name="konfirmasi_password_baru" class="form-control" maxlength="25" onkeypress="return event.which != 32">
                                                                            <span id="konfirmasiedit-toggle<?= $data['id_user'] ?>"><i class="bi bi-eye"></i></span>
                                                                        </div>
                                                                        <div class="mb-4">
                                                                            <label class="form-label">Hak Akses</label>
                                                                            <select type="text" name="hak_akses" class="form-select">
                                                                                <option value="<?= $data['hak_akses'] ?>" hidden><?= $data['hak_akses'] ?></option>
                                                                                <option value="superadmin">Super-Admin</option>
                                                                                <option value="admin">Admin</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Foto</label>
                                                                            <div class="col-12">
                                                                                <input class="form-control" type="file" name="foto" accept="image/*">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="col-12">
                                                                        <div class="text-center">
                                                                            <button type="submit" class="btn btn-success" name="edit-pengguna">Simpan</button>
                                                                            <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Akhir Modal Ubah-->

                                            <!-- Modal Hapus-->
                                            <div class="modal fade" id="hapus-pengguna<?= $data['id_user'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="col-12">
                                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                                <div class="text-center">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Pengguna</h1>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form method="post" action="assets/CRUD/crud-pengguna.php">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                                                                <div class="text-center">
                                                                    <h5>Apakah Anda Yakin Ingin Menghapus data Pengguna ini ?</h5>
                                                                    <span class="text-danger">Nama Pengguna : <b><?php echo $data['nama_user'] ?></b>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="col-12">
                                                                    <div class="text-center">
                                                                        <button type="submit" class="btn btn-success" name="hapus-pengguna">Hapus</button>
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
    <div class="modal fade" id="tambahpengguna" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pengguna</h1>
                        </div>
                    </div>
                </div>
                <form method="post" autocomplete="off" action="assets/CRUD/crud-pengguna.php" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-4">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" autocomplete="off" class="form-control" onkeypress="return event.which != 32" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nama Pengguna</label>
                                <input type="text" name="nama_user" autocomplete="off" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" id="password-tambah" autocomplete="new-password" name="password" class="form-control" maxlength="25" onkeypress="return event.which != 32" required>
                                <span id="tambah-toggle"><i class="bi bi-eye"></i></span>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" id="konfirmasi_pwtambah" autocomplete="new-password" name="konfirmasi_password_baru" class="form-control" maxlength="25" onkeypress="return event.which != 32" required>
                                <span id="konfirmasi-toggle"><i class="bi bi-eye"></i></span>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Hak Akses</label>
                                <select type="text" name="hak_akses" class="form-select">
                                    <option value="" hidden></option>
                                    <option value="superadmin">Super-Admin</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Foto</label>
                                <div class="col-12">
                                    <input type="file" name="foto" id="upload-button2" oninput="showPreview2()" accept="image/*" style="display: none;">
                                    <figure id="myPreview2" style="display: none;">
                                        <img id="chosen-image2" style="width: 120px; height: 120px;">
                                        <figcaption id="file-name2"></figcaption>
                                    </figure>
                                    <div class="pt-2">
                                        <label id="bigger" for="upload-button2" style="color: white;" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success" name="simpan-pengguna">Simpan</button>
                                    <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Akhir Modal Tambah-->

</main><!-- End #main -->

<script>
    const passwordTambah = document.getElementById('password-tambah');
    const tambahToggle = document.getElementById('tambah-toggle');

    tambahToggle.addEventListener('click', () => {
        if (passwordTambah.type === 'password') {
            passwordTambah.type = 'text';
            tambahToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordTambah.type = 'password';
            tambahToggle.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });
    // 2
    let uploadButton2 = document.getElementById("upload-button2");
    let chosenImage2 = document.getElementById("chosen-image2");
    let fileName2 = document.getElementById("file-name2");

    uploadButton2.onchange = () => {
        let reader = new FileReader();
        reader.readAsDataURL(uploadButton2.files[0]);
        console.log(uploadButton2.files[0]);
        reader.onload = () => {
            chosenImage2.setAttribute("src", reader.result);
        }
        fileName2.textContent = uploadButton2.files[0].name;
    }

    function hilangPreview2() {
        var j = document.getElementById("myPreview2");
        j.style.display = "none";
    }

    function showPreview2() {
        var j = document.getElementById("myPreview2");
        j.style.display = "block";
    }
    // END

    const passwordKonfirmasitambah = document.getElementById('konfirmasi_pwtambah');
    const konfirmasitambahToggle = document.getElementById('konfirmasi-toggle');

    konfirmasitambahToggle.addEventListener('click', () => {
        if (passwordKonfirmasitambah.type === 'password') {
            passwordKonfirmasitambah.type = 'text';
            konfirmasitambahToggle.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordKonfirmasitambah.type = 'password';
            konfirmasitambahToggle.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });
</script>

<?php
$batas = 8;
$i = 1;
$query = mysqli_query($koneksi, "SELECT * FROM user");
while ($data = mysqli_fetch_array($query)) {
?>
    <script>
        const passwordKonfirmasiedit<?= $data['id_user'] ?> = document.getElementById('konfirmasi_pwedit<?= $data['id_user'] ?>');
        const konfirmasieditToggle<?= $data['id_user'] ?> = document.getElementById('konfirmasiedit-toggle<?= $data['id_user'] ?>');

        konfirmasieditToggle<?= $data['id_user'] ?>.addEventListener('click', () => {
            if (passwordKonfirmasiedit<?= $data['id_user'] ?>.type === 'password') {
                passwordKonfirmasiedit<?= $data['id_user'] ?>.type = 'text';
                konfirmasieditToggle<?= $data['id_user'] ?>.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordKonfirmasiedit<?= $data['id_user'] ?>.type = 'password';
                konfirmasieditToggle<?= $data['id_user'] ?>.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    </script>
<?php
}
?>

<?php
$batas = 8;
$i = 1;
$query = mysqli_query($koneksi, "SELECT * FROM user");
while ($data = mysqli_fetch_array($query)) {
?>
    <script>
        const passwordInput<?= $data['id_user'] ?> = document.getElementById('password<?= $data['id_user'] ?>');
        const passwordToggle<?= $data['id_user'] ?> = document.getElementById('password-toggle<?= $data['id_user'] ?>');

        passwordToggle<?= $data['id_user'] ?>.addEventListener('click', () => {
            if (passwordInput<?= $data['id_user'] ?>.type === 'password') {
                passwordInput<?= $data['id_user'] ?>.type = 'text';
                passwordToggle<?= $data['id_user'] ?>.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                passwordInput<?= $data['id_user'] ?>.type = 'password';
                passwordToggle<?= $data['id_user'] ?>.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    </script>
    <style>
        #password-toggle<?= $data['id_user'] ?> {
            position: absolute;
            right: 26px;
            top: 214px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: large;
        }

        #tambah-toggle {
            position: absolute;
            right: 26px;
            top: 255px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: large;
        }

        #konfirmasi-toggle {
            position: absolute;
            right: 26px;
            top: 348px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: large;
        }

        #konfirmasiedit-toggle<?= $data['id_user'] ?> {
            position: absolute;
            right: 26px;
            top: 295px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: large;
        }
    </style>

<?php
}
?>