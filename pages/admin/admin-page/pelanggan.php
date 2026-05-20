<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT p.id_pelanggan, p.nama, p.alamat, p.email, p.no_hp,
         pw.nama_paket, p.status
  FROM pelanggan p
  LEFT JOIN paket_wifi pw ON p.id_paket = pw.id_paket
  ORDER BY p.id_pelanggan DESC
  LIMIT 100
";
$result = $conn->query($sql);
$total  = $result ? $result->num_rows : 0;
?>
<link rel="stylesheet" href="./assets/css/nvc-admin.css">

<div class="nvc-admin-wrap">
  <div class="nvc-card">
    <div class="nvc-card-header">
      <h4 class="nvc-card-title"><i class="ti ti-users"></i> Data Pelanggan <span class="nvc-badge nvc-badge-blue" style="margin-left:6px"><?= $total ?></span></h4>
      <a href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php" class="btn-nvc btn-nvc-primary">
        <i class="ti ti-plus"></i> Tambah Pelanggan
      </a>
    </div>

    <div class="nvc-table-wrap">
      <table class="nvc-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
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
              <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#64748b" title="<?= htmlspecialchars($row['alamat']) ?>">
                <?= htmlspecialchars($row['alamat']) ?>
              </td>
              <td style="color:#64748b;font-size:13px"><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['no_hp']) ?></td>
              <td>
                <?= $row['nama_paket']
                    ? '<span class="nvc-badge nvc-badge-blue">'.htmlspecialchars($row['nama_paket']).'</span>'
                    : '<span style="color:#cbd5e1">-</span>' ?>
              </td>
              <td><span class="nvc-badge <?= $badge ?>"><?= ucfirst($st) ?></span></td>
              <td>
                <div class="nvc-actions">
                  <a href="/projeknvcnet/pages/admin/admin-page/form-pelanggan.php?id=<?= $row['id_pelanggan'] ?>"
                     class="btn-nvc btn-nvc-sm btn-nvc-edit">
                    <i class="ti ti-pencil"></i> Edit
                  </a>
                  <?php if ($st === 'booking'): ?>
                    <form method="POST" action="admin-page/konfirmasi-pelanggan.php" style="margin:0">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-confirm">✅ Konfirmasi</button>
                    </form>
                  <?php elseif ($st === 'confirmed'): ?>
                    <form method="POST" action="admin-page/batal-konfirmasi.php" style="margin:0"
                          onsubmit="return confirm('Batalkan konfirmasi pelanggan ini?')">
                      <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan'] ?>">
                      <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-del">❌ Batal</button>
                    </form>
                  <?php else: ?>
                    <button class="btn-nvc btn-nvc-sm" style="background:#f1f5f9;color:#cbd5e1;cursor:not-allowed" disabled>🚫</button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="8">Tidak ada data pelanggan ditemukan.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
