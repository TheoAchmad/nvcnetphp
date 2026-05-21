<?php
include_once __DIR__ . '/../assets/config/koneksi.php';

$paketQuery = $conn->query("SELECT id_paket, nama_paket, harga FROM paket_wifi");
$paketList = [];
while ($row = $paketQuery->fetch_assoc()) {
  $paketList[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="NVC Network by Provitel - Penyedia layanan internet cepat, stabil, dan terjangkau di Banyuwangi.">
  <title>NVC Network by Provitel</title>

  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <script>
    function updateHarga() {
  const select = document.getElementById("id_paket");
  const hargaInput = document.getElementById("harga");
  const selectedOption = select.options[select.selectedIndex];
  const harga = selectedOption.getAttribute("data-harga");
  hargaInput.value = harga || "";
}
  </script>
</head>
<body>

  <!-- Top Info Bar -->
  <div class="about">
    <div class="wadah">
      <div class="kontak-info">
        <p><i class="fa-solid fa-location-dot" aria-hidden="true"></i> R8WQ+98V, Gombengsari, Kalipuro, Banyuwangi</p>
        <p><i class="fa-solid fa-envelope" aria-hidden="true"></i> nvc@gmail.com</p>
        <p><i class="fa-solid fa-phone" aria-hidden="true"></i> +62 822 3218 1284</p>
      </div>
      <div class="follow">
        <p>Follow us : </p>
        <p>
          <a href="https://github.com/TheoAchmadd/nvcnet"><i class="fa-brands fa-github"></i></a>
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-square-instagram"></i></a>
        </p>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="#" class="logo-nav"><img src="../assets/gambar/nvc.png" alt="Logo NVC Network"></a>

    <div class="navigasi">
      <a href="../index.php">HOME</a>
      <a href="../pages/about.php">ABOUT US</a>
      <a href="../pages/coverage.php">COVERAGE</a>
      <a href="" class="active">CONTACT</a>
    </div>

    <a href="#" id="hamburger"><i class="fa-solid fa-bars"></i></a>
  </nav>

  <!-- Contact Section -->
  <section class="contact">
    <div class="contact-container">

      <!-- Left Info -->
      <div class="contact-info">
        <h3>Office Location</h3>
        <div class="info-box">
          <i class="fa-solid fa-location-dot"></i>
          <p>R8WQ+98V, Gombeng, Gombengsari,<br>Kalipuro, Banyuwangi Regency,<br>East Java 68455</p>
        </div>

        <h3>Office Hours</h3>
        <div class="info-box">
          <i class="fa-solid fa-clock"></i>
          <p>10.00am – 08.00pm<br>08.00pm – 10.00am</p>
        </div>

        <h3>Phone</h3>
        <div class="info-box">
          <i class="fa-solid fa-phone"></i>
          <p>+62 822 3219 1294</p>
        </div>

        <h3>Email</h3>
        <div class="info-box">
          <i class="fa-solid fa-envelope"></i>
          <p>theosmk20@gmail.com<br>nvc@gmail.com</p>
        </div>
      </div>

      <!-- Right Form -->
      <div class="contact-form">
        <h2>Request a Contact Us</h2>
        <p>
          Next we will assist you in fulfilling the internet connection you need.
          We also provide internet connections for local links, VPN, public IP,
          web design, banking and corporation.
        </p>
        <div class="line"></div>

        <form action="admin/admin-page/proses-pelanggan.php" method="POST">
          <input type="text" name="nama" placeholder="Nama Lengkap" required>
          
          <div class="form-row">
            <input type="email" placeholder="Email Address" name="email" required>
            <input type="text" placeholder="No Hp / WhatsApp" name="telepon" required>
          </div>
          
          <input type="hidden" name="source" value="contact">
          <input type="text" placeholder="Alamat Lengkap Pemasangan" name="alamat" required>
          
          <div class="legend-text">Pilih Paket Layanan:</div>
          <div class="form-row">
            <!-- Pilihan Paket -->
            <select name="id_paket" id="id_paket" onchange="updateHarga()" required>
              <option value="">-- Pilih Paket WiFi --</option>
              <?php foreach ($paketList as $paket): ?>
                <option value="<?= $paket['id_paket'] ?>" data-harga="<?= $paket['harga'] ?>">
                  <?= htmlspecialchars($paket['nama_paket']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <!-- Menampilkan Harga Otomatis dari JS (Readonly agar tidak diedit manual) -->
            <input type="text" id="harga" name="harga_tampil" placeholder="Harga Otomatis" readonly style="background: rgba(0,0,0,0.2); cursor: not-allowed;">
          </div>
          
          <button type="submit" class="btn-submit">
            SEND MESSAGE <i class="fa-solid fa-paper-plane"></i>
          </button>
        </form>
      </div>

    </div>
  </section>

  <?php include "../assets/component/footer.php" ?>

  <script src="../assets/js/script.js"></script>
</body>
</html>
