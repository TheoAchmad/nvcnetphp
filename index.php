<!DOCTYPE html>
<html lang="id">
<head>
  <?php include "assets/component/head.php" ?>
</head>
<body>

   <?php include "assets/component/top-footer.php" ?>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="#" class="logo-nav"><img src="assets/gambar/Enhance_the_uploaded-removebg-preview.png" alt="Logo NVC Network"></a>

    <div class="navigasi">
      <a href="" class="active">HOME</a>
      <a href="pages/about.php">ABOUT US</a>
      <a href="pages/coverage.php">COVERAGE</a>
      <a href="pages/contact.php">CONTACT</a>
    </div>

    <a href="#" id="hamburger"><i class="fa-solid fa-bars"></i></a>
  </nav>

  <!-- Hero Section -->
  <section class="hero" id="home">
    <div class="hero-container">
      <div class="hero-content fade-in-up">
        
        <!-- Brand Identity Layout -->
        <div class="hero-brand">
          <span class="brand-badge">NVC NETWORK</span>
          <span class="brand-separator">by</span>
          <img class="provitel-logo" src="assets/gambar/provitel2remove.png" alt="Provitel Logo">
        </div>

        <!-- Catchy Dynamic Headline -->
        <h1 class="hero-title">
          Internet Super Cepat, <br>
          <span>100% True Unlimited</span> Tanpa Drama!
        </h1>
        
        <!-- Persuasive Sub-headline -->
        <p class="hero-description">
          Navila Computer hadir membawa solusi koneksi internet rumah dan bisnis yang stabil, berkecepatan tinggi, dan ramah di kantong. Streaming, gaming, atau WFH? Semua lancar tanpa khawatir kuota habis.
        </p>
        
        <!-- Action Buttons -->
        <div class="hero-action-group">
          <a href="pages/coverage.php" class="btn-hero btn-primary-hero">
            <i class="fa-solid fa-rocket"></i> BERLANGGANAN SEKARANG
          </a>
          <a href="https://wa.me/6282232191294" class="btn-hero btn-secondary-hero" target="_blank" rel="noopener">
            <i class="fa-brands fa-whatsapp"></i> HUBUNGI KAMI
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- Isi Utama -->
  <main class="container">
    <section class="navila fade-in-up" id="about">
      <h2>NAVILA COMPUTER NETWORK</h2>
      <p class="nvc">
        NVC NETWORK adalah salah satu perusahaan layanan telekomunikasi penyedia jaringan internet dengan kecepatan akses super cepat dan stabil. Selain layanan akses internet, Provitel juga memberikan layanan turunan internet lainnya untuk kebutuhan rumah dan bisnis Anda.
      </p>
    </section>
  </main>

  <!-- Services Section -->
  <section class="services" id="services">
    <div class="container">
      <h2 class="judul-service">NVC SERVICES</h2>
      <div class="services-container">
        <div class="service-box">
          <h3>INTERNET UNLIMITED <span>01</span></h3>
          <p>Nikmati internet unlimited tanpa batas kuota dan kecepatan. Bebas streaming film, youtube dan bebas akses website tanpa khawatir kehabisan kuota dengan kecepatan penuh.</p>
        </div>

        <div class="service-box">
          <h3>CCTV & IPTV <span>02</span></h3>
          <p>Kami menyediakan layanan pemasangan CCTV dengan produk berkualitas tinggi untuk meningkatkan keamanan baik dalam ruangan maupun di luar ruangan.</p>
        </div>

        <div class="service-box">
          <h3>WEB DEVELOPMENT <span>03</span></h3>
          <p>Developer Website Profesional dengan team kreatif handal yang dipercaya berbagai jenis usaha, untuk membantu memasarkan produk maupun jasa melalui teknologi digital internet.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Section (dinamis dari database) -->
  <section class="homeprice">
    <div class="container">
      <h2 class="section-title">NVC HOME PRICE</h2>
      <div class="homeprice-container">
        <?php
        // Ambil paket dari database
        require_once "assets/config/koneksi.php";
        $sql_paket = "SELECT * FROM paket_wifi ORDER BY harga ASC";
        $res_paket = $conn->query($sql_paket);
        if ($res_paket && $res_paket->num_rows > 0):
          while ($pk = $res_paket->fetch_assoc()):
            $is_feat = !empty($pk['is_featured']);
            $fitur_list = [];
            if (!empty($pk['deskripsi'])) {
              $fitur_list = array_map('trim', explode(',', $pk['deskripsi']));
            }
            if (empty($fitur_list)) {
              // fitur default jika belum diisi
              $fitur_list = ['Unlimited Per Bulan','Speed Browsing','24 Jam Nonstop','Simetris Upstream & Downstream'];
              if (!empty($pk['bandwidth'])) $fitur_list[] = 'Bandwidth ' . $pk['bandwidth'];
            }
        ?>
        <div class="homeprice-box <?= $is_feat ? 'featured' : '' ?>">
          <h3><?= htmlspecialchars($pk['nama_paket']) ?></h3>
          <h4>Rp <?= number_format($pk['harga'], 0, ',', '.') ?></h4>
          <p>Per Bulan</p>
          <hr>
          <ul>
            <?php foreach ($fitur_list as $f): ?>
              <li><?= htmlspecialchars($f) ?></li>
            <?php endforeach; ?>
          </ul>
          <a href="pages/contact.php" class="btn-price">BERLANGGANAN</a>
        </div>
        <?php endwhile; else: ?>
        <p style="text-align:center; color:#aaa;">Paket belum tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <div class="cta-content container">
      <h2>Paket Internet Dedicated, Corporation, Lokal Link, Metro-e, IP Public, Kemitraan RT/RWnet</h2>
      <p>Konsultasikan dengan tim kami, dengan senang hati kami akan membantu Anda.</p>
      <a href="https://wa.me/6282232191294" class="btn-cta">KLIK DISINI</a>
    </div>
  </section>

  <!-- Footer -->
  <?php include "assets/component/footer.php" ?>

  <script src="assets/js/script.js"></script>
</body>
</html>