<!DOCTYPE html>
<html lang="id">
<head>
  <?php include "assets/component/head.php" ?>
  <style>
    /* Hero Section Styles */
.hero {
  position: relative;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 120px 20px 80px 20px;
  /*background: radial-gradient(circle at top right, #1e2229, #12141c);  Efek premium dark */
  background-image: url('assets/gambar/heros.png');
  background-size: cover;
  background-position: center;
  color: #ffffff;
  overflow: hidden;
}

.hero-container {
  width: 100%;
  max-width: 900px; /* Menjaga teks tidak terlalu melebar di monitor besar */
  text-align: center;
}

/* Brand Badge Layout */
.hero-brand {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  margin-bottom: 25px;
  background: rgba(255, 255, 255, 1);
  padding: 8px 18px;
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-badge {
  font-weight: 700;
  font-size: 0.9rem;
  letter-spacing: 1.5px;
  color: #38bdf8; /* Warna aksen biru terang modern */
}

.brand-separator {
  font-style: italic;
  font-size: 0.85rem;
  color: #94a3b8;
}

.provitel-logo {
  height: 24px;
  width: auto;
  object-fit: contain;
}

/* Headline Styling */
.hero-title {
  font-size: clamp(2.2rem, 5vw, 3.8rem); /* Ukuran font otomatis menyesuaikan layar */
  font-weight: 800;
  line-height: 1.2;
  letter-spacing: -0.5px;
  margin-bottom: 20px;
  color: #f8fafc;
}

.hero-title span {
  background: linear-gradient(to right, #38bdf8, #0ea5e9);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Description Text */
.hero-description {
  font-size: clamp(1rem, 2vw, 1.15rem);
  line-height: 1.6;
  color: #cbd5e1;
  max-width: 720px;
  margin: 0 auto 35px auto;
}

/* Button Layout & Design */
.hero-action-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 16px;
}

.btn-hero {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 14px 28px;
  font-size: 0.95rem;
  font-weight: 600;
  border-radius: 8px;
  text-decoration: none;
  transition: all 0.3s ease;
}

.btn-primary-hero {
  background: #0ea5e9;
  color: #ffffff;
  box-shadow: 0 4px 14px rgba(14, 165, 233, 0.4);
}

.btn-primary-hero:hover {
  background: #0284c7;
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(14, 165, 233, 0.6);
}

.btn-secondary-hero {
  background: rgba(44, 241, 9, 0.8);
  color: #ffffff;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-secondary-hero:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
  border-color: rgba(255, 255, 255, 0.4);
}

/* Responsivitas Layar Kecil (Mobile) */
@media (max-width: 576px) {
  .hero {
    padding-top: 100px;
  }
  
  .hero-brand {
    flex-direction: row;
    padding: 6px 14px;
  }
  
  .hero-action-group {
    flex-direction: column;
    width: 100%;
    padding: 0 20px;
  }
  
  .btn-hero {
    width: 100%;
    justify-content: center;
  }
}
  </style>
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

  <!-- Hero -->
  <!-- Hero Section -->
<section class="hero" id="home">
  <div class="hero-container container">
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

  <!-- Isi -->
  <main class="container">
    <section class="navila fade-in-up" id="about">
      <h2>NAVILA COMPUTER NETWORK</h2>
      <p class="nvc">
        NVC NETWORK adalah salah satu perusahaan layanan telekomunikasi penyedia jaringan internet dengan kecepatan akses super cepat dan stabil. Selain layanan akses internet, Provitel juga memberikan layanan turunan internet lainnya untuk kebutuhan rumah dan bisnis Anda.
      </p>
    </section>
  </main>

  <section class="services" id="services">
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
</section>

<section class="homeprice">
  <h2 class="section-title">NVC HOME PRICE</h2>
  <div class="homeprice-container">
    <div class="homeprice-box">
      <h3>Internet Broadband only</h3>
      <h4>Rp 100.000</h4>
      <p>Per Bulan</p>
      <hr>
      <ul>
        <li>Unlimited Per Bulan</li>
        <li>Speed Browsing</li>
        <li>24 Jam Nonstop</li>
        <li>Simetris Upstream & Downstream</li>
        <li>Bandwidth 20 Mbps</li>
      </ul>
      <a href="pages/contact.php" class="btn-price">BERLANGGANAN</a>
    </div>

    <div class="homeprice-box featured">
      <h3>Internet Broadband Fast</h3>
      <h4>Rp 150.000</h4>
      <p>Per Bulan</p>
      <hr>
      <ul>
        <li>Unlimited Per Bulan</li>
        <li>Speed Browsing</li>
        <li>24 Jam Nonstop</li>
        <li>Simetris Upstream & Downstream</li>
        <li>Bandwidth 30 Mbps</li>
      </ul>
      <a href="pages/contact.php" class="btn-price">BERLANGGANAN</a>
    </div>

    <div class="homeprice-box">
      <h3>Internet Broadband High</h3>
      <h4>Rp 200.000</h4>
      <p>Per Bulan</p>
      <hr>
      <ul>
        <li>Unlimited Per Bulan</li>
        <li>Speed Browsing</li>
        <li>24 Jam Nonstop</li>
        <li>Simetris Upstream & Downstream</li>
        <li>Bandwidth 40 Mbps</li>
      </ul>
      <a href="pages/contact.php" class="btn-price">BERLANGGANAN</a>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta">
  <div class="cta-content">
    <h2>
      Paket Internet Dedicated, Corporation, Lokal Link, Metro-e, IP Public, Kemitraan RT/RWnet
    </h2>
    <p>
      Konsultasikan dengan tim kami, dengan senang hati kami akan membantu Anda.
    </p>
    <a href="https://wa.me/6282232191294" class="btn-cta">KLIK DISINI</a>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-left">
    <p>© 2019 PT.NAVILA COMPUTER. All Rights Reserved.</p>
  </div>
  <div class="footer-right">
    <a href="#">Term of User</a>
    <a href="#">Licence</a>
    <a href="#">Support</a>
  </div>
</footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
