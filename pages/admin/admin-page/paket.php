<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$success = '';
$error   = '';

// Migrasi kolom otomatis (Tanpa IF NOT EXISTS & aman di-refresh)
$cek_kolom = $conn->query("SHOW COLUMNS FROM `paket_wifi` LIKE 'deskripsi'");

if ($cek_kolom && $cek_kolom->num_rows == 0) {
    $conn->query("ALTER TABLE `paket_wifi` 
        ADD COLUMN `deskripsi` TEXT NULL AFTER `harga`,
        ADD COLUMN `bandwidth` VARCHAR(20) NULL AFTER `deskripsi`,
        ADD COLUMN `is_featured` TINYINT(1) DEFAULT 0 AFTER `bandwidth`");
}

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
<link rel="stylesheet" href="./assets/css/nvc-admin.css">

<div class="nvc-admin-wrap">

  <?php if ($success): ?>
    <div class="nvc-alert nvc-alert-success"><i class="ti ti-circle-check"></i> <?= htmlspecialchars($success) ?></div>
  <?php elseif ($error): ?>
    <div class="nvc-alert nvc-alert-error"><i class="ti ti-circle-x"></i> <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <div class="nvc-card">
    <div class="nvc-card-header">
      <h4 class="nvc-card-title"><i class="ti ti-wifi"></i> Daftar Paket Internet</h4>
      <button class="btn-nvc btn-nvc-primary" onclick="openModal('modal-tambah')">
        <i class="ti ti-plus"></i> Tambah Paket
      </button>
    </div>

    <div class="nvc-table-wrap">
      <table class="nvc-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Paket</th>
            <th>Harga / Bulan</th>
            <th>Bandwidth</th>
            <th>Deskripsi / Fitur</th>
            <th>Featured</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td style="color:#94a3b8;font-size:13px"><?= $row['id_paket'] ?></td>
              <td style="font-weight:700"><?= htmlspecialchars($row['nama_paket']) ?></td>
              <td class="nvc-price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
              <td>
                <?= !empty($row['bandwidth'])
                    ? '<span class="nvc-badge nvc-badge-blue">'.htmlspecialchars($row['bandwidth']).'</span>'
                    : '<span style="color:#cbd5e1">-</span>' ?>
              </td>
              <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#64748b;font-size:13px"
                  title="<?= htmlspecialchars($row['deskripsi'] ?? '') ?>">
                <?= htmlspecialchars($row['deskripsi'] ?? '-') ?>
              </td>
              <td>
                <?= !empty($row['is_featured'])
                    ? '<span class="nvc-badge nvc-badge-gold">⭐ Featured</span>'
                    : '<span style="color:#e2e8f0;font-size:12px">—</span>' ?>
              </td>
              <td>
                <div class="nvc-actions">
                  <button class="btn-nvc btn-nvc-sm btn-nvc-edit"
                    onclick="openEdit(<?= $row['id_paket'] ?>,'<?= addslashes($row['nama_paket']) ?>',<?= $row['harga'] ?>,'<?= addslashes($row['bandwidth'] ?? '') ?>','<?= addslashes(str_replace(["\r","\n"], ' ', $row['deskripsi'] ?? '')) ?>',<?= (int)($row['is_featured'] ?? 0) ?>)">
                    <i class="ti ti-pencil"></i> Edit
                  </button>
                  <form method="POST" style="margin:0" onsubmit="return confirm('Hapus paket ini?')">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="id_paket" value="<?= $row['id_paket'] ?>">
                    <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-del">
                      <i class="ti ti-trash"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="7">Belum ada data paket.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="nvc-info-banner">
    <i class="ti ti-info-circle"></i>
    <span>Harga & nama paket di sini otomatis tampil di <strong>halaman Home (Pricing Section)</strong>.
    Tandai <em>Featured</em> agar paket disorot di homepage. Kolom <em>Bandwidth</em> &amp; <em>Deskripsi</em> (pisahkan fitur dengan koma) juga ditampilkan di homepage.</span>
  </div>

</div>

<!-- Modal Tambah -->
<div class="nvc-modal" id="modal-tambah">
  <div class="nvc-modal-box">
    <div class="nvc-modal-title"><i class="ti ti-plus" style="color:#3b82f6"></i> Tambah Paket Baru</div>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="nvc-form-row">
        <div class="nvc-form-group" style="flex:2">
          <label>Nama Paket *</label>
          <input type="text" name="nama_paket" placeholder="Internet Broadband Fast" required>
        </div>
        <div class="nvc-form-group">
          <label>Harga (Rp) *</label>
          <input type="number" name="harga" placeholder="150000" required min="0">
        </div>
      </div>
      <div class="nvc-form-row">
        <div class="nvc-form-group">
          <label>Bandwidth</label>
          <input type="text" name="bandwidth" placeholder="30 Mbps">
        </div>
        <div class="nvc-form-group" style="display:flex;align-items:flex-end;padding-bottom:2px">
          <label class="nvc-check-label">
            <input type="checkbox" name="is_featured"> Tampilkan sebagai Featured di Homepage
          </label>
        </div>
      </div>
      <div class="nvc-form-group">
        <label>Deskripsi / Fitur</label>
        <textarea name="deskripsi" placeholder="Unlimited Per Bulan, Speed Browsing, 24 Jam Nonstop, Bandwidth 30 Mbps"></textarea>
        <div class="nvc-form-hint">Pisahkan setiap fitur dengan koma ( , )</div>
      </div>
      <div class="nvc-modal-footer">
        <button type="button" class="btn-nvc btn-nvc-cancel" onclick="closeModal('modal-tambah')">Batal</button>
        <button type="submit" class="btn-nvc btn-nvc-primary"><i class="ti ti-device-floppy"></i> Simpan Paket</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="nvc-modal" id="modal-edit">
  <div class="nvc-modal-box">
    <div class="nvc-modal-title"><i class="ti ti-pencil" style="color:#3b82f6"></i> Edit Paket</div>
    <form method="POST">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="id_paket" id="edit-id">
      <div class="nvc-form-row">
        <div class="nvc-form-group" style="flex:2">
          <label>Nama Paket *</label>
          <input type="text" name="nama_paket" id="edit-nama" required>
        </div>
        <div class="nvc-form-group">
          <label>Harga (Rp) *</label>
          <input type="number" name="harga" id="edit-harga" required min="0">
        </div>
      </div>
      <div class="nvc-form-row">
        <div class="nvc-form-group">
          <label>Bandwidth</label>
          <input type="text" name="bandwidth" id="edit-bw">
        </div>
        <div class="nvc-form-group" style="display:flex;align-items:flex-end;padding-bottom:2px">
          <label class="nvc-check-label">
            <input type="checkbox" name="is_featured" id="edit-feat"> Featured di Homepage
          </label>
        </div>
      </div>
      <div class="nvc-form-group">
        <label>Deskripsi / Fitur</label>
        <textarea name="deskripsi" id="edit-desc"></textarea>
        <div class="nvc-form-hint">Pisahkan setiap fitur dengan koma ( , )</div>
      </div>
      <div class="nvc-modal-footer">
        <button type="button" class="btn-nvc btn-nvc-cancel" onclick="closeModal('modal-edit')">Batal</button>
        <button type="submit" class="btn-nvc btn-nvc-primary"><i class="ti ti-device-floppy"></i> Update Paket</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(id) { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
function openEdit(id, nama, harga, bw, desc, feat) {
  document.getElementById('edit-id').value    = id;
  document.getElementById('edit-nama').value  = nama;
  document.getElementById('edit-harga').value = harga;
  document.getElementById('edit-bw').value    = bw;
  document.getElementById('edit-desc').value  = desc;
  document.getElementById('edit-feat').checked = feat === 1;
  openModal('modal-edit');
}
document.querySelectorAll('.nvc-modal').forEach(function(m) {
  m.addEventListener('click', function(e) { if (e.target === m) m.classList.remove('open'); });
});
</script>
