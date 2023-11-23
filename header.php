<?php
require_once "koneksi.php";
if (empty($_SESSION['user']['hak_akses'])) {
  header('location: logout.php');
}

date_default_timezone_set('Asia/Jakarta');

$timezone = date_default_timezone_get();
$currentdate = date('Y/m/d');
$currentdateD = date('d');
$currenthour = date('H:i');
$currentmonth = date("F");
$currentyear = date("Y");

$today = date("l");

$filter_upweek = date("Y/m/d", strtotime('this week'));
$filter_endweek = date("Y/m/d", strtotime('this week 6 days'));
$filter_upmonth = date("Y/m/1");
$filter_endmonth = date("Y/m/31");
$filter_upyear = date("Y/1/1");
$filter_endyear = date("Y/12/31");

if ($today == "Monday") {
    $today_indo = "Senin";

}elseif ($today == "Tuesday") {
    $today_indo = "Selasa";

}elseif ($today == "Wednesday") {
    $today_indo = "Rabu";
    
}elseif ($today == "Thursday") {
    $today_indo = "Kamis";
    
}elseif ($today == "Friday") {
    $today_indo = "Jumat";
    
}elseif ($today == "Saturday") {
    $today_indo = "Sabtu";
    
}elseif ($today == "Sunday") {
    $today_indo = "Minggu";
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';
    $cek = preg_replace("/-/"," ", $page);
    $title = ucwords($cek);
    echo $title;
    ?>
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jul 27 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php?page=dashboard" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Inventaris Barang</span>
      </a>

      <a class="sidebar-toggle js-sidebar-toggle" href="?page=dashboard">
        <big><big><big><i class="bi bi-grid"></i></big></big></big>
      </a>

      <span style="margin-left: 10px;"><?= $today_indo . " - " . $currentdate ?></span>
    </div><!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">    
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/avatars/<?= $_SESSION['user']['foto'] ?>" alt="<?= $_SESSION['user']['foto'] ?>" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['user']['nama_user'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <img src="assets/img/avatars/<?= $_SESSION['user']['foto'] ?>" alt="<?= $_SESSION['user']['foto'] ?>" class="rounded-circle" style="height: 60px; width: 60px; margin-bottom: 10px;">
              <h6><?= $_SESSION['user']['nama_user'] ?></h6>
              <span><?= $_SESSION['user']['username'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="?page=profile&profile=index">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="?page=profile&profile=edit" data-bs-target="#profile-edit">
                <i class="bi bi-gear"></i>
                <span>Profile Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar js-sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php echo (!empty($_GET['page']) ? 'collapsed' : '')?>" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'kategori' || $page == 'barang' || $page == 'daftar-barang' || $page == 'ruangan' ? '' : 'collapsed')?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse <?php echo ($page == 'kategori' || $page == 'barang' || $page == 'daftar-barang' || $page == 'ruangan' ? 'show' : '') ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a  class="<?php echo ($page == 'barang' ? 'nav-link' : '' ) ?>" href="?page=barang">
              <i class="bi bi-circle"></i><span>Barang</span>
            </a>
          </li>
          <li>
            <a  class="<?php echo ($page == 'ruangan' || $page == 'daftar-barang' ? 'nav-link' : '' ) ?>" href="?page=ruangan">
              <i class="bi bi-circle"></i><span>Ruangan</span>
            </a>
          </li>
          <li>
            <a class="<?php echo ($page == 'kategori' ? 'nav-link' : '' ) ?>" href="?page=kategori">
              <i class="bi bi-circle"></i><span>Kategori</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'pinjaman' ? '' : 'collapsed')?>" href="?page=pinjaman">
          <i class="bi bi-archive"></i><span>Peminjaman</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php echo ($page == 'laporan-barang-masuk' || $page == 'laporan-barang-keluar' ? '' : 'collapsed')?>" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse <?php echo ($page == 'laporan-barang-masuk' || $page == 'laporan-barang-keluar' ? 'show' : '')?> " data-bs-parent="#sidebar-nav">
          <li>
            <a  class="<?php echo ($page == 'laporan-barang-masuk' ? 'nav-link' : '')?>" href="?page=laporan-barang-masuk">
              <i class="bi bi-circle"></i><span>Laporan Barang Masuk</span>
            </a>
          </li>
          <li>
            <a class="<?php echo ($page == 'laporan-barang-keluar' ? 'nav-link' : '')?>" href="?page=laporan-barang-keluar">
              <i class="bi bi-circle"></i><span>Laporan Barang Keluar</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item" <?php echo ($_SESSION['user']['hak_akses'] == 'superadmin' ? '' : 'hidden' ) ?>>
        <a class="nav-link <?php echo ($page == 'pengguna' ? '' : 'collapsed')?>" href="?page=pengguna">
          <i class="bi bi-people"></i><span>Pengguna</span>
        </a>
      </li><!-- End Charts Nav -->

  </aside><!-- End Sidebar-->