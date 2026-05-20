<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$success = '';
$error = '';

// Migrasi kolom otomatis (Tanpa IF NOT EXISTS & aman di-refresh)
$cek_kolom = $conn->query("SHOW COLUMNS FROM `paket_wifi` LIKE 'deskripsi'");

if ($cek_kolom && $cek_kolom->num_rows == 0) {
    $conn->query("ALTER TABLE `paket_wifi` 
        ADD COLUMN `deskripsi` TEXT NULL AFTER `harga`,
        ADD COLUMN `bandwidth` VARCHAR(20) NULL AFTER `deskripsi`,
        ADD COLUMN `is_featured` TINYINT(1) DEFAULT 0 AFTER `bandwidth`");
}

// --- PROSES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    if ($_POST['action'] === 'tambah') {
        $nama  = trim($_POST['nama_paket']);
        $harga = (int) str_replace(['.', ','], '', $_POST['harga']);
        $bw    = trim($_POST['bandwidth']);
        $desc  = trim($_POST['deskripsi']);
        $feat  = isset($_POST['is_featured']) ? 1 : 0;
        $stmt  = $conn->prepare("INSERT INTO paket_wifi (nama_paket, harga, bandwidth, deskripsi, is_featured) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sissi", $nama, $harga, $bw, $desc, $feat);
        $success = $stmt->execute() ? "Paket berhasil ditambahkan!" : "Gagal: " . $conn->error;
        $stmt->close();
    }

    if ($_POST['action'] === 'edit') {
        $id    = (int) $_POST['id_paket'];
        $nama  = trim($_POST['nama_paket']);
        $harga = (int) str_replace(['.', ','], '', $_POST['harga']);
        $bw    = trim($_POST['bandwidth']);
        $desc  = trim($_POST['deskripsi']);
        $feat  = isset($_POST['is_featured']) ? 1 : 0;
        $stmt  = $conn->prepare("UPDATE paket_wifi SET nama_paket=?, harga=?, bandwidth=?, deskripsi=?, is_featured=? WHERE id_paket=?");
        $stmt->bind_param("sissii", $nama, $harga, $bw, $desc, $feat, $id);
        $success = $stmt->execute() ? "Paket berhasil diperbarui!" : "Gagal: " . $conn->error;
        $stmt->close();
    }

    if ($_POST['action'] === 'hapus') {
        $id   = (int) $_POST['id_paket'];
        $stmt = $conn->prepare("DELETE FROM paket_wifi WHERE id_paket=?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute() ? "Paket berhasil dihapus!" : "Gagal: " . $conn->error;
        $stmt->close();
    }
}

$result = $conn->query("SELECT * FROM paket_wifi ORDER BY harga ASC");
?>

<style>
.nvc-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.06); padding:24px; margin-bottom:24px; }
.nvc-card h4 { margin:0 0 20px; font-size:16px; font-weight:700; color:#2c3e50; border-left:4px solid #3498db; padding-left:12px; }
.nvc-table { width:100%; border-collapse:collapse; }
.nvc-table th { background:#f8f9fa; padding:12px 14px; text-align:left; font-size:12px; font-weight:600; color:#7f8c8d; text-transform:uppercase; letter-spacing:.5px; border-bottom:2px solid #eee; }
.nvc-table td { padding:13px 14px; border-bottom:1px solid #f0f0f0; font-size:14px; color:#2c3e50; vertical-align:middle; }
.nvc-table tr:hover td { background:#fafcff; }
.badge-feat { background:#fff3cd; color:#856404; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
.price-text { color:#27ae60; font-weight:700; font-size:15px; }
.btn-sm-edit { background:#eaf4fb; color:#3498db; border:none; padding:5px 13px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600; }
.btn-sm-del  { background:#fdecea; color:#e74c3c; border:none; padding:5px 13px; border-radius:6px; cursor:pointer; font-size:12px; font-weight:600; }
.btn-pnvc { background:#3498db; color:#fff; border:none; padding:10px 22px; border-radius:8px; cursor:pointer; font-size:14px; font-weight:600; }
.btn-pnvc:hover { background:#2980b9; }
.alert-ok  { background:#d4edda; color:#155724; padding:12px 16px; border-radius:8px; margin-bottom:16px; }
.alert-err { background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:8px; margin-bottom:16px; }
.form-row { display:flex; gap:16px; flex-wrap:wrap; }
.form-group { flex:1; min-width:200px; }
.form-group label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
.form-group input, .form-group textarea { width:100%; padding:9px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; }
.form-group input:focus, .form-group textarea:focus { outline:none; border-color:#3498db; }
.check-label { display:flex; align-items:center; gap:8px; font-size:13px; font-weight:600; color:#555; cursor:pointer; }
.modal-overlay { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.4); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.show { display:flex; }
.modal-box { background:#fff; border-radius:14px; padding:28px; width:520px; max-width:95%; box-shadow:0 10px 40px rgba(0,0,0,.15); }
.modal-box h5 { margin:0 0 20px; font-size:18px; font-weight:700; color:#2c3e50; }
.modal-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; }
.btn-cancel { background:#f0f0f0; color:#555; border:none; padding:9px 20px; border-radius:8px; cursor:pointer; font-weight:600; }
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
        <h4 style="margin:0;">Daftar Paket Internet</h4>
        <button class="btn-pnvc" onclick="openModal('modal-tambah')">+ Tambah Paket</button>
      </div>
      <div style="overflow-x:auto;">
        <table class="nvc-table">
          <thead>
            <tr>
              <th>#</th><th>Nama Paket</th><th>Harga / Bulan</th><th>Bandwidth</th><th>Deskripsi</th><th>Featured</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id_paket'] ?></td>
                <td><strong><?= htmlspecialchars($row['nama_paket']) ?></strong></td>
                <td class="price-text">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['bandwidth'] ?? '-') ?></td>
                <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= htmlspecialchars($row['deskripsi'] ?? '-') ?></td>
                <td><?= !empty($row['is_featured']) ? '<span class="badge-feat">⭐ Featured</span>' : '<span style="color:#ccc;font-size:12px;">-</span>' ?></td>
                <td>
                  <button class="btn-sm-edit" onclick="openEdit(<?= $row['id_paket'] ?>,'<?= addslashes($row['nama_paket']) ?>',<?= $row['harga'] ?>,'<?= addslashes($row['bandwidth'] ?? '') ?>','<?= addslashes(str_replace(["\r","\n"], ' ', $row['deskripsi'] ?? '')) ?>',<?= (int)($row['is_featured'] ?? 0) ?>)">✏️ Edit</button>
                  <form method="POST" style="display:inline;" onsubmit="return confirm('Hapus paket ini?')">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="id_paket" value="<?= $row['id_paket'] ?>">
                    <button type="submit" class="btn-sm-del">🗑️ Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr><td colspan="7" style="text-align:center;padding:30px;color:#aaa;">Belum ada data paket.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="nvc-card" style="background:#eaf4fb;box-shadow:none;border:1px solid #bee3f8;">
      <p style="margin:0;font-size:13px;color:#2980b9;">
        💡 <strong>Info:</strong> Harga & nama paket di sini otomatis tampil di <strong>halaman Home (Pricing Section)</strong> dan halaman <strong>Paket Admin</strong>.
        Kolom <em>Bandwidth</em> & <em>Deskripsi</em> dipakai jika homepage sudah diupdate untuk membaca dari database.
        Centang <em>Featured</em> agar paket tampil lebih menonjol (disorot) di homepage.
      </p>
    </div>

  </div>
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="modal-tambah">
  <div class="modal-box">
    <h5>➕ Tambah Paket Baru</h5>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="form-row">
        <div class="form-group" style="flex:2">
          <label>Nama Paket *</label>
          <input type="text" name="nama_paket" placeholder="Internet Broadband Fast" required>
        </div>
        <div class="form-group">
          <label>Harga (Rp) *</label>
          <input type="number" name="harga" placeholder="150000" required min="0">
        </div>
      </div>
      <div class="form-row" style="margin-top:14px;">
        <div class="form-group">
          <label>Bandwidth</label>
          <input type="text" name="bandwidth" placeholder="30 Mbps">
        </div>
        <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:2px;">
          <label class="check-label"><input type="checkbox" name="is_featured" style="width:auto;"> Featured di Homepage</label>
        </div>
      </div>
      <div class="form-group" style="margin-top:14px;">
        <label>Deskripsi / Fitur (pisah dengan koma)</label>
        <textarea name="deskripsi" rows="3" placeholder="Unlimited Per Bulan, Speed Browsing, 24 Jam Nonstop, Bandwidth 30 Mbps"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal('modal-tambah')">Batal</button>
        <button type="submit" class="btn-pnvc">Simpan Paket</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="modal-edit">
  <div class="modal-box">
    <h5>✏️ Edit Paket</h5>
    <form method="POST">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id_paket" id="edit-id">
      <div class="form-row">
        <div class="form-group" style="flex:2">
          <label>Nama Paket *</label>
          <input type="text" name="nama_paket" id="edit-nama" required>
        </div>
        <div class="form-group">
          <label>Harga (Rp) *</label>
          <input type="number" name="harga" id="edit-harga" required min="0">
        </div>
      </div>
      <div class="form-row" style="margin-top:14px;">
        <div class="form-group">
          <label>Bandwidth</label>
          <input type="text" name="bandwidth" id="edit-bw">
        </div>
        <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:2px;">
          <label class="check-label"><input type="checkbox" name="is_featured" id="edit-feat" style="width:auto;"> Featured di Homepage</label>
        </div>
      </div>
      <div class="form-group" style="margin-top:14px;">
        <label>Deskripsi / Fitur</label>
        <textarea name="deskripsi" id="edit-desc" rows="3"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal('modal-edit')">Batal</button>
        <button type="submit" class="btn-pnvc">Update Paket</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id){ document.getElementById(id).classList.add('show'); }
function closeModal(id){ document.getElementById(id).classList.remove('show'); }
function openEdit(id,nama,harga,bw,desc,feat){
  document.getElementById('edit-id').value   = id;
  document.getElementById('edit-nama').value = nama;
  document.getElementById('edit-harga').value = harga;
  document.getElementById('edit-bw').value   = bw;
  document.getElementById('edit-desc').value = desc;
  document.getElementById('edit-feat').checked = feat===1;
  openModal('modal-edit');
}
document.querySelectorAll('.modal-overlay').forEach(function(m){
  m.addEventListener('click',function(e){ if(e.target===m) m.classList.remove('show'); });
});
</script>
