<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$id = $_GET['id'] ?? '';
$edit = false;
$data = ['nama'=>'', 'alamat'=>'', 'email'=>'', 'no_hp'=>'', 'id_paket'=>''];

// Ambil data pelanggan jika edit
if ($id) {
  $edit = true;
  $stmt = $conn->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
}

// Ambil daftar paket dari tabel paket_wifi
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
  <title><?= $edit ? 'Edit' : 'Tambah' ?> Pelanggan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #eef2f7;
      margin: 0;
      padding: 0;
    }

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
      font-size: 22px;
      font-weight: 600;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #34495e;
    }

    input[type="text"],
    input[type="email"],
    select {
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      transition: border-color 0.3s ease;
    }

    input:focus,
    select:focus {
      border-color: #3498db;
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2><?= $edit ? 'Edit' : 'Tambah' ?> Pelanggan</h2>
    <form action="proses-pelanggan.php" method="POST">
      <input type="hidden" name="source" value="dashboard">
      <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
      <?php endif; ?>

      <label for="nama">Nama</label>
      <input type="text" name="nama" id="nama" placeholder="Nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

      <label for="alamat">Alamat</label>
      <input type="text" name="alamat" id="alamat" placeholder="Alamat" value="<?= htmlspecialchars($data['alamat']) ?>">

      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($data['email']) ?>">

      <label for="telepon">No HP</label>
      <input type="text" name="telepon" id="telepon" placeholder="No HP" value="<?= htmlspecialchars($data['no_hp']) ?>">

      <label for="id_paket">Pilih Paket WiFi</label>
      <select name="id_paket" id="id_paket" required>
        <option value="">-- Pilih Paket --</option>
        <?php foreach ($paketList as $paket): ?>
          <option value="<?= $paket['id_paket'] ?>" <?= $data['id_paket'] == $paket['id_paket'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($paket['nama_paket']) ?> - Rp<?= number_format($paket['harga'], 0, ',', '.') ?>
          </option>
        <?php endforeach; ?>
      </select>

      <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
    </form>
  </div>

</body>
</html>