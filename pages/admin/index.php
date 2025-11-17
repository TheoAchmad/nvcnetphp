<?php
// File: /pages/admin/index.php

// 1. KONEKSI DATABASE
// (Sesuaikan path jika Anda memindah file index.php)
require_once '../../assets/config/koneksi.php';

// 2. LOGIKA ROUTING
// Ambil nilai 'page' dari URL, jika tidak ada, set default ke 'dashboard'
$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin NVCNetwork</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Admin Dashboard untuk NVCNetwork">
  <meta name="author" content="NVCNetwork">

  <link rel="icon" href="./assets/images/Enhance_the_uploaded-removebg-preview.png" type="image/x-icon"> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="./assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="./assets/fonts/feather.css">
  <link rel="stylesheet" href="./assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="./assets/fonts/material.css">
  <link rel="stylesheet" href="./assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="./assets/css/style-preset.css">

</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="index.php?page=dashboard" class="b-brand text-primary">
          <!-- <img src="" class="img-fluid logo-lg" alt="logo"> -->
          <span class="b-brand-text">NVCNetwork</span>
        </a>
      </div>
      <div class="navbar-content">

        <ul class="pc-navbar">
          <li class="pc-item <?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
            <a href="index.php?page=dashboard" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>

          <li class="pc-item pc-caption">
            <label>Manajemen Data</label>
            <i class="ti ti-database"></i>
          </li>

          <li class="pc-item <?php echo ($page == 'pelanggan') ? 'active' : ''; ?>">
            <a href="index.php?page=pelanggan" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Pelanggan</span>
            </a>
          </li>

          <li class="pc-item <?php echo ($page == 'paket') ? 'active' : ''; ?>">
            <a href="index.php?page=paket" class="pc-link">
              <span class="pc-micon"><i class="ti ti-wifi"></i></span>
              <span class="pc-mtext">Paket WiFi</span>
            </a>
          </li>

          <li class="pc-item <?php echo ($page == 'pembelian') ? 'active' : ''; ?>">
            <a href="index.php?page=pembelian" class="pc-link">
              <span class="pc-micon"><i class="ti ti-shopping-cart"></i></span>
              <span class="pc-mtext">Pembelian</span>
            </a>
          </li>
          
          <li class="pc-item <?php echo ($page == 'pembayaran') ? 'active' : ''; ?>">
            <a href="index.php?page=pembayaran" class="pc-link">
              <span class="pc-micon"><i class="ti ti-receipt-2"></i></span>
              <span class="pc-mtext">Pembayaran</span>
            </a>
          </li>

        </ul>

      </div>
    </div>
  </nav>
  <header class="pc-header">
    <div class="header-wrapper"> <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
          <li class="dropdown pc-h-item d-inline-flex d-md-none">
            <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
              <i class="ti ti-search"></i>
            </a>
            <div class="dropdown-menu pc-h-dropdown drp-search">
              <form class="px-3">
                <div class="form-group mb-0 d-flex align-items-center">
                  <i data-feather="search"></i>
                  <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                </div>
              </form>
            </div>
          </li>
          <li class="pc-h-item d-none d-md-inline-flex">
            <form class="header-search">
              <i data-feather="search" class="icon-search"></i>
              <input type="search" class="form-control" placeholder="Search here. . .">
            </form>
          </li>
        </ul>
      </div>
      <div class="ms-auto">
        <ul class="list-unstyled">
          
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
              <img src="./assets/images/user/1000050242.jpg" alt="user-image" class="user-avtar">
              <span>Admin NVC</span> </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <div class="dropdown-header">
                <div class="d-flex mb-1">
                  <div class="flex-shrink-0">
                    <img src="./assets/images/user/1000050242.jpg" alt="user-image" class="user-avtar wid-35">
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">Admin NVC</h6> <span>Administrator</span>
                  </div>
                  <a href="/projeknvcnet/index.php" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
                </div>
              </div>
              
              </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <div class="pc-container">
    <div class="pc-content">
      
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10"><?php echo ucfirst($page); ?></h5>
              </div>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">
                  <?php echo ucfirst($page); ?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php
      $fileToInclude = '';

      switch ($page) {
          case 'dashboard':
              $fileToInclude = './admin-page/dashboard.php';
              break;
          // case 'pelanggan':
          //     $fileToInclude = './admin-page/form-pelanggan.php';
          //     break;
          case 'paket':
              $fileToInclude = './admin-page/form-paket.php';
              break;
          case 'pembelian':
              $fileToInclude = './admin-page/form-pembelian.php';
              break;
          case 'pembayaran':
              // Anda perlu membuat file ini
              $fileToInclude = './admin-page/form-pembayaran.php';
              break;
          case 'kategori':
              $fileToInclude = './admin-page/form-kategori.php';
              break;
          default:
              // Keamanan: jika ?page=... diisi aneh, kembali ke dashboard
              $fileToInclude = './admin-page/dashboard.php';
              break;
      }

      // Include file jika filenya ada
      if (file_exists($fileToInclude)) {
          include $fileToInclude;
      } else {
          // Tampilkan pesan error jika file tidak ditemukan
          echo "<div class='card'>
                  <div class='card-body'>
                    <h3 class='text-danger'>Halaman Tidak Ditemukan</h3>
                    <p>File <b>$fileToInclude</b> tidak ada di server.</p>";

          // Pesan khusus untuk file yg belum dibuat
          if ($page == 'pembayaran') {
                echo "<hr>";
                echo "<p><b>Tugas:</b> Anda perlu membuat file <b>form-pembayaran.php</b> di dalam folder <b>admin-page</b>. Anda bisa copy-paste dari form-pelanggan.php dan sesuaikan.</p>";
          }
                    
          echo "  </div>
                </div>";
      }
      ?>
      </div>
  </div>
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">
            Copyright © <?php echo date("Y"); ?> <a href="#" target="_blank">MVCNetwork</a>.
          </p>
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="index.php?page=dashboard">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script src="./assets/js/plugins/apexcharts.min.js"></script>
  <script src="./assets/js/pages/dashboard-default.js"></script>
  <script src="./assets/js/plugins/popper.min.js"></script>
  <script src="./assets/js/plugins/simplebar.min.js"></script>
  <script src="./assets/js/plugins/bootstrap.min.js"></script>
  <script src="./assets/js/fonts/custom-font.js"></script>
  <script src="./assets/js/pcoded.js"></script>
  <script src="./assets/js/plugins/feather.min.js"></script>

  <script>
    // Inisialisasi javascript template
    layout_change('light');
    change_box_container('false');
    layout_rtl_change('false');
    preset_change("preset-1");
    font_change("Public-Sans");
  </script>

</body>
</html>