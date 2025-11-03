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

<h2><?= $edit ? 'Edit' : 'Tambah' ?> Pelanggan</h2>
<form action="proses-pelanggan.php" method="POST">
  <input type="hidden" name="source" value="dashboard">
  <?php if ($edit): ?>
    <input type="hidden" name="id" value="<?= $id ?>">
  <?php endif; ?>

  <input type="text" name="nama" placeholder="Nama" value="<?= htmlspecialchars($data['nama']) ?>" required><br>
  <input type="text" name="alamat" placeholder="Alamat" value="<?= htmlspecialchars($data['alamat']) ?>"><br>
  <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($data['email']) ?>"><br>
  <input type="text" name="telepon" placeholder="No HP" value="<?= htmlspecialchars($data['no_hp']) ?>"><br>

  <label for="id_paket">Pilih Paket WiFi:</label><br>
  <select name="id_paket" id="id_paket" required>
    <option value="">-- Pilih Paket --</option>
    <?php foreach ($paketList as $paket): ?>
      <option value="<?= $paket['id_paket'] ?>" <?= $data['id_paket'] == $paket['id_paket'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($paket['nama_paket']) ?> - Rp<?= number_format($paket['harga'], 0, ',', '.') ?>
      </option>
    <?php endforeach; ?>
  </select><br><br>

  <button type="submit"><?= $edit ? 'Update' : 'Simpan' ?></button>
</form>