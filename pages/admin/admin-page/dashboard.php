<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

// Stats
$totalPelanggan  = $conn->query("SELECT COUNT(*) AS c FROM pelanggan")->fetch_assoc()['c'] ?? 0;
$totalBooking    = $conn->query("SELECT COUNT(*) AS c FROM pelanggan WHERE status='booking'")->fetch_assoc()['c'] ?? 0;
$totalConfirmed  = $conn->query("SELECT COUNT(*) AS c FROM pelanggan WHERE status='confirmed'")->fetch_assoc()['c'] ?? 0;
$totalPembelian  = $conn->query("SELECT COUNT(*) AS c FROM pembelian")->fetch_assoc()['c'] ?? 0;

// Recent pelanggan
$result = $conn->query("
  SELECT p.id_pelanggan, p.nama, p.email, p.no_hp, pw.nama_paket, p.status
  FROM pelanggan p
  LEFT JOIN paket_wifi pw ON p.id_paket = pw.id_paket
  ORDER BY p.id_pelanggan DESC
  LIMIT 8
");
?>
<link rel="stylesheet" href="./assets/css/nvc-admin.css">

<div class="nvc-admin-wrap">

  <!-- Stat Cards -->
  <div class="nvc-stats-grid">
    <div class="nvc-stat-card">
      <div class="nvc-stat-icon blue"><i class="ti ti-users"></i></div>
      <div>
        <div class="nvc-stat-label">Total Pelanggan</div>
        <div class="nvc-stat-value"><?= $totalPelanggan ?></div>
      </div>
    </div>
    <div class="nvc-stat-card">
      <div class="nvc-stat-icon orange"><i class="ti ti-clock"></i></div>
      <div>
        <div class="nvc-stat-label">Menunggu Konfirmasi</div>
        <div class="nvc-stat-value"><?= $totalBooking ?></div>
      </div>
    </div>
    <div class="nvc-stat-card">
      <div class="nvc-stat-icon green"><i class="ti ti-circle-check"></i></div>
      <div>
        <div class="nvc-stat-label">Pelanggan Aktif</div>
        <div class="nvc-stat-value"><?= $totalConfirmed ?></div>
      </div>
    </div>
    <div class="nvc-stat-card">
      <div class="nvc-stat-icon red"><i class="ti ti-receipt-2"></i></div>
      <div>
        <div class="nvc-stat-label">Total Transaksi</div>
        <div class="nvc-stat-value"><?= $totalPembelian ?></div>
      </div>
    </div>
  </div>

  <!-- Recent Pelanggan -->
  <div class="nvc-card">
    <div class="nvc-card-header">
      <h4 class="nvc-card-title"><i class="ti ti-users"></i> Pelanggan Terbaru</h4>
      <a href="index.php?page=pelanggan" class="btn-nvc btn-nvc-primary btn-nvc-sm">
        <i class="ti ti-arrow-right"></i> Lihat Semua
      </a>
    </div>
    <div class="nvc-table-wrap">
      <table class="nvc-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Paket</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()):
              $st = $row['status'];
              $badge = match($st) {
                'booking'   => 'nvc-badge-orange',
                'confirmed' => 'nvc-badge-green',
                'nonaktif'  => 'nvc-badge-gray',
                default     => 'nvc-badge-gray'
              };
            ?>
            <tr>
              <td><strong style="color:#3b82f6">#<?= $row['id_pelanggan'] ?></strong></td>
              <td style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></td>
              <td style="color:#64748b;font-size:13px"><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['no_hp']) ?></td>
              <td><?= $row['nama_paket'] ? htmlspecialchars($row['nama_paket']) : '<span style="color:#cbd5e1">-</span>' ?></td>
              <td><span class="nvc-badge <?= $badge ?>"><?= ucfirst($st) ?></span></td>
              <td>
                <div class="nvc-actions">
                  <a href="admin-page/form-pelanggan.php?id=<?= $row['id_pelanggan'] ?>" class="btn-nvc btn-nvc-sm btn-nvc-edit">Edit</a>
                  <?php if ($st === 'booking'): ?>
                    <form method="POST" action="admin-page/konfirmasi-pelanggan.php" style="margin:0">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-confirm">✅ Konfirmasi</button>
                    </form>
                  <?php elseif ($st === 'confirmed'): ?>
                    <form method="POST" action="admin-page/batal-konfirmasi.php" style="margin:0" onsubmit="return confirm('Batalkan konfirmasi?')">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-del">❌ Batal</button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="7">Belum ada data pelanggan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</div>
