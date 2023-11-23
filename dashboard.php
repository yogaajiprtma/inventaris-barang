<?php
include_once 'header.php';
?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Home</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-15">
        <div class="row">

          <!-- Barang Masuk Card -->
          <div class="col-xxl-3 col-xl-12">
            <div class="card info-card revenue-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <form method="post">
                  <li><button class="dropdown-item <?php if (isset($_POST['masuk-all'])) {echo 'active';} ?>" href="#" name="masuk-all">Semua</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['masuk-minggu'])) {echo 'active';} ?>" href="#" name="masuk-minggu">Minggu ini</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['masuk-bulan'])) {echo 'active';} ?>" href="#" name="masuk-bulan">Bulan Ini</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['masuk-tahun'])) {echo 'active';} ?>" href="#" name="masuk-tahun">Tahun Ini</button></li>
                  </form>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Barang Masuk <span>
                  <?php  
                  if (isset($_POST['masuk-all'])) {
                    echo '| Semua';
                  }elseif (isset($_POST['masuk-minggu'])) {
                    echo '| Minggu ini';
                  }elseif (isset($_POST['masuk-bulan'])) {
                    echo '| Bulan ini';
                  }elseif (isset($_POST['masuk-tahun'])) {
                    echo '| Tahun ini';
                  }
                  ?></span></h5>

                <div class="d-flex align-items-center">
                  <a href="?page=laporan-barang-masuk">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-download-2-fill"></i>
                    </div>
                  </a>
                  <div class="ps-3">
                    <h6>
                      <?php
                        if (isset($_POST['masuk-all'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
                        }elseif (isset($_POST['masuk-minggu'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE tanggal_masuk BETWEEN '$filter_upweek' AND '$filter_endweek'");
                        }elseif (isset($_POST['masuk-bulan'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE tanggal_masuk BETWEEN '$filter_upmonth' AND '$filter_endmonth'");
                        }elseif (isset($_POST['masuk-tahun'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE tanggal_masuk BETWEEN '$filter_upyear' AND '$filter_endyear'");
                        }else{
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
                        }
                        $data = mysqli_fetch_array($query);
                        echo $data['total'];
                      ?>
                    </h6>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Barang Masuk Card -->

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Jumlah Barang</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <a href="?page=barang"><i class="bi bi-box-seam"></i></a>
                  </div>
                  <div class="ps-3">
                    <h6>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang");
                      $data = mysqli_fetch_array($query);
                      echo $data['total'];
                      ?>
                    </h6>

                    <?php   
                    $query_masuk = mysqli_query($koneksi, "SELECT SUM(kondisi_barang_bagus) as bagus,SUM(kondisi_barang_rusak) as rusak FROM barang WHERE keluar='0' ");
                    $masuk = mysqli_fetch_array($query_masuk);

                    $masuk_total = intval($masuk['bagus']) + intval($masuk['rusak']);

                    $bagus = (intval($masuk['bagus']) * 100) / $masuk_total;
                    $rusak = (intval($masuk['rusak']) * 100) / $masuk_total;
                    ?>

                    <span class="text-primary small pt-1 fw-bold"><?= (empty($masuk['bagus']) ? '0' : round($bagus,0)) ?>%</span><span class="text-muted small pt-2 ps-1">Stok Bagus</span>
                    <span class="text-success small pt-1 fw-bold" style="margin-left: 10px;"><?= (empty($masuk['rusak']) ? '0' : round($rusak,0)) ?>%</span><span class="text-muted small pt-2 ps-1">Stok Rusak</span>

                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Sales Card -->

          <!-- Barang Rusak Card -->
          <div class="col-xxl-3 col-md-6">

            <div class="card info-card customers-card">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <form method="post">
                  <li><button class="dropdown-item <?php if (isset($_POST['keluar-all'])) {echo 'active';} ?>" href="#" name="keluar-all">Semua</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['keluar-minggu'])) {echo 'active';} ?>" href="#" name="keluar-minggu">Minggu ini</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['keluar-bulan'])) {echo 'active';} ?>" href="#" name="keluar-bulan">Bulan Ini</button></li>
                  <li><button class="dropdown-item <?php if (isset($_POST['keluar-tahun'])) {echo 'active';} ?>" href="#" name="keluar-tahun">Tahun Ini</button></li>
                  </form>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Barang Keluar <span><?php  
                  if (isset($_POST['keluar-all'])) {
                    echo '| Semua';
                  }elseif (isset($_POST['keluar-minggu'])) {
                    echo '| Minggu ini';
                  }elseif (isset($_POST['keluar-bulan'])) {
                    echo '| Bulan ini';
                  }elseif (isset($_POST['keluar-tahun'])) {
                    echo '| Tahun ini';
                  }
                  ?></span></h5>

                <div class="d-flex align-items-center">
                  <a href="?page=laporan-barang-keluar">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ri-delete-bin-5-fill"></i>
                    </div>
                  </a>
                  <div class="ps-3">
                  <h6>
                      <?php
                        if (isset($_POST['keluar-all'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE keluar='1' OR alasan2='pinjam' ");
                        }elseif (isset($_POST['keluar-minggu'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE keluar='1' OR alasan2='pinjam' AND tanggal_masuk BETWEEN '$filter_upweek' AND '$filter_endweek'");
                        }elseif (isset($_POST['keluar-bulan'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE keluar='1' OR alasan2='pinjam' AND tanggal_masuk BETWEEN '$filter_upmonth' AND '$filter_endmonth'");
                        }elseif (isset($_POST['keluar-tahun'])) {
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE keluar='1' OR alasan2='pinjam' AND tanggal_masuk BETWEEN '$filter_upyear' AND '$filter_endyear'");
                        }else{
                          $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang WHERE keluar='1' OR alasan2='pinjam' ");
                        }
                        $data = mysqli_fetch_array($query);
                        echo $data['total'];
                      ?>
                    </h6>

                    <?php  
                    if (isset($_POST['keluar-all'])) {
                      $query_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as hapus FROM barang WHERE keluar='1' OR alasan='hapus' ");
                      $query_keluar2 = mysqli_query($koneksi, "SELECT COUNT(*) as pinjam FROM pinjam ");

                    }elseif (isset($_POST['keluar-minggu'])) {
                      $query_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as hapus FROM barang WHERE keluar='1' OR alasan='hapus' AND tanggal_keluar BETWEEN '$filter_upweek' AND '$filter_endweek' ");
                      $query_keluar2 = mysqli_query($koneksi, "SELECT COUNT(*) as pinjam FROM pinjam WHERE tanggal_pinjam BETWEEN '$filter_upweek' AND '$filter_endweek' ");

                    }elseif (isset($_POST['keluar-bulan'])) {
                      $query_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as hapus FROM barang WHERE keluar='1' OR alasan='hapus' AND tanggal_keluar BETWEEN '$filter_upmonth' AND '$filter_endmonth' ");
                      $query_keluar2 = mysqli_query($koneksi, "SELECT COUNT(*) as pinjam FROM pinjam WHERE tanggal_pinjam BETWEEN '$filter_upmonth' AND '$filter_endmonth' ");

                    }elseif (isset($_POST['keluar-tahun'])) {
                      $query_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as hapus FROM barang WHERE keluar='1' OR alasan='hapus' AND tanggal_keluar BETWEEN '$filter_upyear' AND '$filter_endyear' ");
                      $query_keluar2 = mysqli_query($koneksi, "SELECT COUNT(*) as pinjam FROM pinjam WHERE tanggal_pinjam BETWEEN '$filter_upyear' AND '$filter_endyear' ");

                    }else{
                      $query_keluar = mysqli_query($koneksi, "SELECT COUNT(*) as hapus FROM barang WHERE keluar='1' OR alasan='hapus' ");
                      $query_keluar2 = mysqli_query($koneksi, "SELECT COUNT(*) as pinjam FROM pinjam ");

                    }
                    $keluar = mysqli_fetch_array($query_keluar);
                    $keluar2 = mysqli_fetch_array($query_keluar2);

                    $keluar_total = intval($keluar['hapus']) + intval($keluar2['pinjam']);

                    $hapus = $keluar['hapus'];
                    $pinjam = $keluar2['pinjam'];
                    ?>

                    <span class="text-warning small pt-1 fw-bold"><?= $pinjam ?></span><span class="text-muted small pt-2 ps-1">Peminjam</span>
                    <span class="text-danger small pt-1 fw-bold" style="margin-left: 10px;"><?= $hapus ?></span><span class="text-muted small pt-2 ps-1">Terhapus</span>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Barang Rusak Card -->
          <!-- Pengguna Card -->
          <div class="col-xxl-2 col-xl-12">

            <div class="card info-card customers-card">

              <div class="card-body">
                <h5 class="card-title">Pengguna</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" id="warna-bg">
                    <a <?= ($_SESSION['user']['hak_akses'] == 'superadmin' ? 'href="?page=pengguna"' : '' ) ?>><i class="ri-user-line"></i></a>
                  </div>
                  <div class="ps-3">
                    <h6>
                      <?php
                      $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM user");
                      $data = mysqli_fetch_array($query);
                      echo $data['total'];
                      ?>
                    </h6>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Pengguna Card -->

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">List Halaman</h5>

                <table class="table table-border">
                  <thead>
                    <tr>
                      <th scope="col">Master Data</th>
                      <th scope="col">Lainnya</th>
                      <th scope="col">Laporan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row"><a href="?page=barang"><i class="bi bi-box-seam"></i> Barang</a></th>
                      <th scope="row"><a href="?page=pinjaman"><i class="bi bi-archive"></i> Pinjaman</a></th>
                      <th scope="row"><a href="?page=laporan-barang-masuk"><i class="ri-download-2-fill"></i> Barang Masuk</a></th>
                    </tr>
                    <tr>
                      <th scope="row"><a href="?page=ruangan"><i class="bi bi-house-down"></i> Ruangan</a></th>
                      <th scope="row"><a href="?page=pengguna" <?= $_SESSION['user']['hak_akses'] != 'superadmin' ? 'hidden' : '' ?>><i class="bi bi-people"></i> Pengguna</a></th>
                      <th scope="row"><a href="?page=laporan-barang-keluar"><i class="ri-delete-bin-5-fill"></i> Barang Keluar</a></th>
                    </tr>
                    <tr>
                      <th scope="row"><a href="?page=kategori"><i class="bi bi-card-list"></i> Kategori</a></th>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>

</main><!-- End #main -->

<?php
include_once 'footer.php';
?>

<link rel="stylesheet" type="text/css" href="assets/css/dashboard/style.css">