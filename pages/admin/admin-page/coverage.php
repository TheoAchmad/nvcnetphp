<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$success = '';
$error   = '';

// Buat tabel jika belum ada
$conn->query("
  CREATE TABLE IF NOT EXISTS `coverage_area` (
    `id_coverage` INT AUTO_INCREMENT PRIMARY KEY,
    `nama_kota` VARCHAR(100) NOT NULL,
    `daftar_area` TEXT NOT NULL,
    `urutan` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
");

// Cek apakah ada data default, jika kosong insert Banyuwangi
$chk = $conn->query("SELECT COUNT(*) as c FROM coverage_area");
$row_chk = $chk->fetch_assoc();
if ($row_chk['c'] == 0) {
    $conn->query("INSERT INTO coverage_area (nama_kota, daftar_area, urutan) VALUES ('Banyuwangi', 'Kalipuro,Giri,Gombengsari,Suko,Kacangan,Lerek,Kelir,Telemung,Bulusari,Kenjo,Paspan,Tamansuruh,Kampung Anyar,Gumuk,Pendarungan,Dan Area Sekitarnya...', 1)");
}

// --- PROSES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'tambah') {
        $kota  = trim($_POST['nama_kota']);
        $area  = trim($_POST['daftar_area']);
        $urut  = (int) $_POST['urutan'];
        $stmt  = $conn->prepare("INSERT INTO coverage_area (nama_kota, daftar_area, urutan) VALUES (?, ?, ?)");
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

<style>
.nvc-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:24px; margin-bottom:24px; }
.nvc-card h4 { margin:0 0 20px; font-size:16px; font-weight:700; color:#2c3e50; border-left:4px solid #27ae60; padding-left:12px; }
.nvc-table { width:100%; border-collapse:collapse; }
.nvc-table th { background:#f8f9fa; padding:12px 14px; text-align:left; font-size:12px; font-weight:600; color:#7f8c8d; text-transform:uppercase; letter-spacing:.5px; border-bottom:2px solid #eee; }
.nvc-table td { padding:13px 14px; border-bottom:1px solid #f0f0f0; font-size:14px; color:#2c3e50; vertical-align:top; }
.nvc-table tr:hover td { background:#f9fff9; }
.area-tags { display:flex; flex-wrap:wrap; gap:5px; }
.area-tag { background:#eafaf1; color:#27ae60; padding:3px 9px; border-radius:12px; font-size:12px; font-weight:500; }
.btn-sm-edit { background:#eaf4fb; color:#3498db; border:none; padding:5px 13px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600; }
.btn-sm-del  { background:#fdecea; color:#e74c3c; border:none; padding:5px 13px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600; }
.btn-pnvc { background:#27ae60; color:#fff; border:none; padding:10px 22px; border-radius:8px; cursor:pointer; font-size:14px; font-weight:600; }
.btn-pnvc:hover { background:#219a52; }
.alert-ok  { background:#d4edda; color:#155724; padding:12px 16px; border-radius:8px; margin-bottom:16px; }
.alert-err { background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:8px; margin-bottom:16px; }
.form-group { margin-bottom:14px; }
.form-group label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
.form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; }
.form-group input:focus, .form-group textarea:focus { outline:none; border-color:#27ae60; }
.form-row { display:flex; gap:14px; }
.modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.4); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.show { display:flex; }
.modal-box { background:#fff; border-radius:14px; padding:28px; width:540px; max-width:95%; box-shadow:0 10px 40px rgba(0,0,0,.15); max-height:90vh; overflow-y:auto; }
.modal-box h5 { margin:0 0 20px; font-size:18px; font-weight:700; color:#2c3e50; }
.modal-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; }
.btn-cancel { background:#f0f0f0; color:#555; border:none; padding:9px 20px; border-radius:8px; cursor:pointer; font-weight:600; }
small.hint { color:#999; font-size:12px; display:block; margin-top:4px; }
</style>

<div class="row">
  <div class="col-12">

    <?php if ($success): ?>
      <div class="alert-ok">✅ <?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="alert-err">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="nvc-card">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
        <h4 style="margin:0;">Manajemen Coverage Area</h4>
        <button class="btn-pnvc" onclick="openModal('modal-tambah')">+ Tambah Kota</button>
      </div>
      <div style="overflow-x:auto;">
        <table class="nvc-table">
          <thead>
            <tr><th>#</th><th>Nama Kota</th><th>Area yang Dicakup</th><th>Urutan</th><th>Aksi</th></tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()):
                $areas = array_map('trim', explode(',', $row['daftar_area']));
              ?>
              <tr>
                <td><?= $row['id_coverage'] ?></td>
                <td><strong><?= htmlspecialchars($row['nama_kota']) ?></strong></td>
                <td>
                  <div class="area-tags">
                    <?php foreach ($areas as $a): ?>
                      <span class="area-tag"><?= htmlspecialchars($a) ?></span>
                    <?php endforeach; ?>
                  </div>
                </td>
                <td><?= $row['urutan'] ?></td>
                <td>
                  <button class="btn-sm-edit" style="margin-bottom:4px;" onclick="openEdit(<?= $row['id_coverage'] ?>,'<?= addslashes($row['nama_kota']) ?>','<?= addslashes($row['daftar_area']) ?>',<?= $row['urutan'] ?>)">✏️ Edit</button><br>
                  <form method="POST" onsubmit="return confirm('Hapus coverage kota ini?')" style="display:inline;">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="id_coverage" value="<?= $row['id_coverage'] ?>">
                    <button type="submit" class="btn-sm-del">🗑️ Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="5" style="text-align:center;padding:30px;color:#aaa;">Belum ada data coverage.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="nvc-card" style="background:#eafaf1;box-shadow:none;border:1px solid #a9dfbf;">
      <p style="margin:0;font-size:13px;color:#1e8449;">
        💡 <strong>Info:</strong> Data kota di sini akan otomatis tampil di <strong>halaman Coverage</strong> website.
        Pisahkan tiap area/desa dengan <strong>koma (,)</strong>. Nomor <em>Urutan</em> menentukan urutan tampil (angka kecil = tampil duluan).
      </p>
    </div>

  </div>
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="modal-tambah">
  <div class="modal-box">
    <h5>➕ Tambah Coverage Kota Baru</h5>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="form-row">
        <div class="form-group" style="flex:2">
          <label>Nama Kota / Kabupaten *</label>
          <input type="text" name="nama_kota" placeholder="Banyuwangi" required>
        </div>
        <div class="form-group" style="flex:1">
          <label>Urutan Tampil</label>
          <input type="number" name="urutan" value="1" min="0">
        </div>
      </div>
      <div class="form-group">
        <label>Daftar Area / Desa / Kecamatan *</label>
        <textarea name="daftar_area" rows="6" placeholder="Kalipuro, Giri, Gombengsari, Suko, Kacangan, Dan Area Sekitarnya..." required></textarea>
        <small class="hint">Pisahkan tiap area dengan tanda koma ( , )</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal('modal-tambah')">Batal</button>
        <button type="submit" class="btn-pnvc">Simpan Coverage</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="modal-edit">
  <div class="modal-box">
    <h5>✏️ Edit Coverage Kota</h5>
    <form method="POST">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id_coverage" id="edit-id">
      <div class="form-row">
        <div class="form-group" style="flex:2">
          <label>Nama Kota / Kabupaten *</label>
          <input type="text" name="nama_kota" id="edit-kota" required>
        </div>
        <div class="form-group" style="flex:1">
          <label>Urutan Tampil</label>
          <input type="number" name="urutan" id="edit-urut" min="0">
        </div>
      </div>
      <div class="form-group">
        <label>Daftar Area (pisah koma) *</label>
        <textarea name="daftar_area" id="edit-area" rows="6" required></textarea>
        <small class="hint">Pisahkan tiap area dengan tanda koma ( , )</small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal('modal-edit')">Batal</button>
        <button type="submit" class="btn-pnvc">Update Coverage</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id){ document.getElementById(id).classList.add('show'); }
function closeModal(id){ document.getElementById(id).classList.remove('show'); }
function openEdit(id,kota,area,urut){
  document.getElementById('edit-id').value   = id;
  document.getElementById('edit-kota').value = kota;
  document.getElementById('edit-area').value = area;
  document.getElementById('edit-urut').value = urut;
  openModal('modal-edit');
}
document.querySelectorAll('.modal-overlay').forEach(function(m){
  m.addEventListener('click',function(e){ if(e.target===m) m.classList.remove('show'); });
});
</script>
