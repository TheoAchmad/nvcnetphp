<!DOCTYPE html>
<html>
<head>
  <title>Form Pelanggan</title>
  <script>
    function updateHarga() {
      const paket = document.getElementById("jenis_paket").value;
      const hargaInput = document.getElementById("harga");

      if (paket === "1") {
        hargaInput.value = 100000;
      } else if (paket === "2") {
        hargaInput.value = 150000;
      } else if (paket === "3") {
        hargaInput.value = 200000;
      } else {
        hargaInput.value = "";
      }
    }
  </script>

</head>
<body>
  <h2>Form Pembelian Paket WiFi</h2>
  <form action="/ProjekNVCNET/assets/pages/admin/admin-page/proses-pelanggan.php" method="POST">
    
    <!-- Data Pelanggan -->
    <fieldset>
      <legend>Data Pelanggan</legend>
      <label>Nama:</label><br>
      <input type="text" name="nama" required><br><br>

      <label>Alamat:</label><br>
      <input type="text" name="alamat"><br><br>

      <label>Email:</label><br>
      <input type="text" name="email"><br><br>

      <label>Telepon:</label><br>
      <input type="text" name="telepon"><br><br>
    </fieldset>

    <!-- Pilih Paket WiFi -->
    <fieldset>
      <legend>Pilih Paket WiFi</legend>
      <label>Paket:</label><br>
      <select name="jenis_paket" id="jenis_paket" onchange="updateHarga()" required>
        <option value="">-- Pilih Paket --</option>
        <option value="1">Internet Broadband only - Rp100.000</option>
        <option value="2">Internet Broadband Fast - Rp150.000</option>
        <option value="3">Internet Broadband High - Rp200.000</option>
      </select><br><br>


    <!-- Data Pembayaran -->
    <!-- <fieldset>
      <legend>Data Pembayaran</legend>
      <label>Metode Pembayaran:</label><br>
      <select name="metode" required>
        <option value="transfer">Transfer Bank</option>
        <option value="tunai">Tunai</option>
        <option value="e-wallet">E-Wallet</option>
      </select><br><br>

      <label>Tanggal Pembayaran:</label><br>
      <input type="date" name="tanggal_bayar" required><br><br>
    </fieldset> -->

    <input type="submit" value="Simpan">
  </form>

</body>
</html>