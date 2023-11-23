<link rel="stylesheet" type="text/css" href="assets/css/profile/style.css">
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="?page=index">Home</a></li>
          <li class="breadcrumb-item"><a href="?page=pengguna">Users</a></li>
          <li class="breadcrumb-item active"><a href="?page=profile&profile=index">Profile</a></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card" onload="getPics()" id="myAvatar">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
              <img src="assets/img/avatars/<?= $_SESSION['user']['foto'] ?>" alt="<?= $_SESSION['user']['foto'] ?>" class="rounded-circle">             
              <h2><?= $_SESSION['user']['nama_user'] ?></h2>
              <h3><?= $_SESSION['user']['username'] ?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link <?php if ($_GET['profile'] == 'index') {echo "active";} ?>" data-bs-toggle="tab" data-bs-target="#profile-overview">Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link <?php if ($_GET['profile'] == 'edit') {echo "active";} ?>" data-bs-toggle="tab" data-bs-target="#profile-edit">Ubah Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link <?php if ($_GET['profile'] == 'pw') {echo "active";} ?>" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade <?php if ($_GET['profile'] == 'index') {echo " show active";} ?> profile-overview" id="profile-overview">
                  <h5 class="card-title">Detail Profile</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama</div>
                    <div class="col-lg-9 col-md-8"><strong><?= $_SESSION['user']['nama_user'] ?></strong></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Username</div>
                    <div class="col-lg-9 col-md-8"><?= $_SESSION['user']['username'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Hak Akses</div>
                    <div class="col-lg-9 col-md-8"><?= ($_SESSION['user']['hak_akses'] == 'superadmin' ? 'Super-Admin' : 'Admin' ) ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Kode Akun</div>
                    <div class="col-lg-9 col-md-8"><?= $_SESSION['user']['kode_akun'] ?></div>
                  </div>

                </div>

                <div class="tab-pane fade <?php if ($_GET['profile'] == 'edit') {echo " show active";} ?> profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="post" action="assets/CRUD/crud-profile.php" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto Profile</label>
                      <div class="col-md-8 col-lg-9" on>
                        <input type="file" name="foto" id="upload-button" oninput="showPreview()" accept="image/*">
                        <figure id="myPreview" style="display: none;">
                          <img id="chosen-image">
                          <figcaption id="file-name"></figcaption>
                        </figure>
                        <div class="pt-2">
                          <label id="bigger" for="upload-button" style="color: white;" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></label>
                          <a id="bigger" href="?page=take-kamera" class="btn btn-info btn-sm"><i class="bi bi-camera-fill"></i></a>
                        </div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama_user" type="text" class="form-control" value="<?= $_SESSION['user']['nama_user'] ?>" oninvalid="setCustomValidity('Tolong isi Tab ini dengan input Nama Baru anda')" oninput="setCustomValidity('')" maxlength="25" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Username</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="username" type="text" class="form-control" value="<?= $_SESSION['user']['username'] ?>" oninvalid="setCustomValidity('Tolong isi Tab ini dengan input Username Baru anda')" oninput="setCustomValidity('')" maxlength="25" onkeypress="return event.which != 32" required>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="simpan-edit-profile">Simpan</button>
                      <button type="reset" class="btn btn-danger" onclick="hilangPreview()"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>
                  </form>   <!-- End Profile Edit Form -->
                </div>

                <div class="tab-pane fade <?php if ($_GET['profile'] == 'pw') {echo " show active";} ?> pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="assets/CRUD/crud-profile.php" method="post">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password Lama</label>
                      <div class="col-md-8 col-lg-8">
                        <div class="matakuada">
                          <input name="password-lama" id="password-lama" type="password" class="form-control" oninvalid="setCustomValidity('Tolong isi Tab ini dengan Password Lama anda')" oninput="setCustomValidity('')" maxlength="25" onkeypress="return event.which != 32" required>
                          <span class="matakuhilang" onmousedown="showPasswordLama(this)" onmouseup="hidePasswordLama(this)"><i class="bi bi-eye"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                      <div class="col-md-8 col-lg-8">
                        <div class="matakuada">
                          <input name="password-baru" id="password-baru" type="password" class="form-control" oninvalid="setCustomValidity('Tolong isi Tab ini dengan Password Baru anda')" oninput="setCustomValidity('')" maxlength="25" onkeypress="return event.which != 32" required>
                        <span class="matakuhilang" onmousedown="showPasswordBaru(this)" onmouseup="hidePasswordBaru(this)"><i class="bi bi-eye"></i></span>
                        </div>
                        <!-- <i class="bi bi-eye-slash"></i> -->
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="konfirmasi-password" class="col-md-4 col-lg-3 col-form-label">konfirmasi Password</label>
                      <div class="col-md-8 col-lg-8">
                        <div class="matakuada">
                          <input name="konfirmasi-password" id="konfirmasi-password" type="password" class="form-control" oninvalid="setCustomValidity('Tolong Konfirmasi Password Baru anda')" oninput="setCustomValidity('')" maxlength="25" onkeypress="return event.which != 32" required>
                        <span class="matakuhilang" onmousedown="showPasswordKonf(this)" onmouseup="hidePasswordKonf(this)"><i class="bi bi-eye"></i></span>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" name="change-password">Ubah Password</button>
                      <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>  
      </div>
      <div id="fullimage" onclick="this.style.display='none';"></div>
    </section>
    <script type="text/javascript" src="assets/js/profile/script.js"></script>
  </main><!-- End #main -->   
</html>