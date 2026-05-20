<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$success = '';
$error   = '';

// Buat tabel jika belum ada
$conn->query("
  CREATE TABLE IF NOT EXISTS `coverage_area` (
    `id_coverage` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_kota`   VARCHAR(100) NOT NULL,
    `daftar_area` TEXT NOT NULL,
    `urutan`      INT DEFAULT 0,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// Data default
$chk = $conn->query("SELECT COUNT(*) as c FROM coverage_area")->fetch_assoc();
if ($chk['c'] == 0) {
    $conn->query("INSERT INTO coverage_area (nama_kota, daftar_area, urutan) VALUES
      ('Banyuwangi','Kalipuro,Giri,Gombengsari,Suko,Kacangan,Lerek,Kelir,Telemung,Bulusari,Kenjo,Paspan,Tamansuruh,Kampung Anyar,Gumuk,Pendarungan,Dan Area Sekitarnya...',1)");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'tambah') {
        $kota = trim($_POST['nama_kota']);
        $area = trim($_POST['daftar_area']);
        $urut = (int) $_POST['urutan'];
        $stmt = $conn->prepare("INSERT INTO coverage_area (nama_kota, daftar_area, urutan) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $kota, $area, $urut);
        $success = $stmt->execute() ? "Coverage baru berhasil ditambahkan!" : "Gagal: " . $conn->error;
        $stmt->close();
    }
    if ($_POST['action'] === 'edit') {
        $id   = (int) $_POST['id_coverage'];
        $kota = trim($_POST['nama_kota']);
        $area = trim($_POST['daftar_area']);
        $urut = (int) $_POST['urutan'];
        $stmt = $conn->prepare("UPDATE coverage_area SET nama_kota=?, daftar_area=?, urutan=? WHERE id_coverage=?");
        $stmt->bind_param("ssii", $kota, $area, $urut, $id);
        $success = $stmt->execute() ? "Coverage berhasil diperbarui!" : "Gagal: " . $conn->error;
        $stmt->close();
    }
    if ($_POST['action'] === 'hapus') {
        $id   = (int) $_POST['id_coverage'];
        $stmt = $conn->prepare("DELETE FROM coverage_area WHERE id_coverage=?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute() ? "Coverage berhasil dihapus!" : "Gagal: " . $conn->error;
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM coverage_area ORDER BY urutan ASC, id_coverage ASC");
?>
<link rel="stylesheet" href="./assets/css/nvc-admin.css">

<div class="nvc-admin-wrap">

  <?php if ($success): ?>
    <div class="nvc-alert nvc-alert-success"><i class="ti ti-circle-check"></i> <?= htmlspecialchars($success) ?></div>
  <?php elseif ($error): ?>
    <div class="nvc-alert nvc-alert-error"><i class="ti ti-circle-x"></i> <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="nvc-card">
    <div class="nvc-card-header">
      <h4 class="nvc-card-title"><i class="ti ti-map-pin"></i> Manajemen Coverage Area</h4>
      <button class="btn-nvc btn-nvc-green" onclick="openModal('modal-tambah')">
        <i class="ti ti-plus"></i> Tambah Kota
      </button>
    </div>

    <div class="nvc-table-wrap">
      <table class="nvc-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Kota / Kab.</th>
            <th>Area yang Dicakup</th>
            <th>Urutan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()):
              $areas = array_map('trim', explode(',', $row['daftar_area']));
            ?>
            <tr>
              <td style="color:#94a3b8;font-size:13px"><?= $row['id_coverage'] ?></td>
              <td style="font-weight:700"><?= htmlspecialchars($row['nama_kota']) ?></td>
              <td>
                <div class="area-tags">
                  <?php foreach ($areas as $a): ?>
                    <span class="area-tag"><?= htmlspecialchars($a) ?></span>
                  <?php endforeach; ?>
                </div>
              </td>
              <td><span class="nvc-badge nvc-badge-gray"><?= $row['urutan'] ?></span></td>
              <td>
                <div class="nvc-actions">
                  <button class="btn-nvc btn-nvc-sm btn-nvc-edit"
                    onclick="openEdit(<?= $row['id_coverage'] ?>,'<?= addslashes($row['nama_kota']) ?>','<?= addslashes($row['daftar_area']) ?>',<?= $row['urutan'] ?>)">
                    <i class="ti ti-pencil"></i> Edit
                  </button>
                  <form method="POST" style="margin:0" onsubmit="return confirm('Hapus coverage kota ini?')">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="id_coverage" value="<?= $row['id_coverage'] ?>">
                    <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-del">
                      <i class="ti ti-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="5">Belum ada data coverage area.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="nvc-info-banner green">
    <i class="ti ti-info-circle"></i>
    <span>Data kota & area di sini otomatis tampil di <strong>halaman Coverage</strong> website.
    Pisahkan setiap area/desa dengan <strong>koma ( , )</strong>. Nomor <em>Urutan</em> menentukan posisi tampil — angka kecil muncul duluan.</span>
  </div>

</div>

<!-- Modal Tambah -->
<div class="nvc-modal" id="modal-tambah">
  <div class="nvc-modal-box">
    <div class="nvc-modal-title"><i class="ti ti-map-pin" style="color:#22c55e"></i> Tambah Coverage Kota Baru</div>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="nvc-form-row">
        <div class="nvc-form-group" style="flex:2">
          <label>Nama Kota / Kabupaten *</label>
          <input type="text" name="nama_kota" placeholder="Banyuwangi" required>
        </div>
        <div class="nvc-form-group">
          <label>Urutan Tampil</label>
          <input type="number" name="urutan" value="1" min="0">
        </div>
      </div>
      <div class="nvc-form-group">
        <label>Daftar Area / Desa / Kecamatan *</label>
        <textarea name="daftar_area" rows="6"
          placeholder="Kalipuro, Giri, Gombengsari, Suko, Kacangan, Dan Area Sekitarnya..." required></textarea>
        <div class="nvc-form-hint">Pisahkan setiap area dengan tanda koma ( , )</div>
      </div>
      <div class="nvc-modal-footer">
        <button type="button" class="btn-nvc btn-nvc-cancel" onclick="closeModal('modal-tambah')">Batal</button>
        <button type="submit" class="btn-nvc btn-nvc-green"><i class="ti ti-device-floppy"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="nvc-modal" id="modal-edit">
  <div class="nvc-modal-box">
    <div class="nvc-modal-title"><i class="ti ti-pencil" style="color:#22c55e"></i> Edit Coverage Kota</div>
    <form method="POST">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id_coverage" id="edit-id">
      <div class="nvc-form-row">
        <div class="nvc-form-group" style="flex:2">
          <label>Nama Kota / Kabupaten *</label>
          <input type="text" name="nama_kota" id="edit-kota" required>
        </div>
        <div class="nvc-form-group">
          <label>Urutan Tampil</label>
          <input type="number" name="urutan" id="edit-urut" min="0">
        </div>
      </div>
      <div class="nvc-form-group">
        <label>Daftar Area (pisah koma) *</label>
        <textarea name="daftar_area" id="edit-area" rows="6" required></textarea>
        <div class="nvc-form-hint">Pisahkan setiap area dengan tanda koma ( , )</div>
      </div>
      <div class="nvc-modal-footer">
        <button type="button" class="btn-nvc btn-nvc-cancel" onclick="closeModal('modal-edit')">Batal</button>
        <button type="submit" class="btn-nvc btn-nvc-green"><i class="ti ti-device-floppy"></i> Update</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
function openEdit(id, kota, area, urut) {
  document.getElementById('edit-id').value   = id;
  document.getElementById('edit-kota').value = kota;
  document.getElementById('edit-area').value = area;
  document.getElementById('edit-urut').value = urut;
  openModal('modal-edit');
}
document.querySelectorAll('.nvc-modal').forEach(function(m) {
  m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('open'); });
});
</script>
