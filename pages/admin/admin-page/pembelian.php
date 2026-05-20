<?php
include_once __DIR__ . '/../../../assets/config/koneksi.php';

$sql = "
  SELECT pb.id_pembelian, p.nama AS nama_pelanggan,
         pw.nama_paket, pb.tanggal_pembelian, pb.status_pembelian
  FROM pembelian pb
  LEFT JOIN pelanggan p  ON pb.id_pelanggan = p.id_pelanggan
  LEFT JOIN paket_wifi pw ON pb.id_paket = pw.id_paket
  ORDER BY pb.tanggal_pembelian DESC
";
$result = $conn->query($sql);
$total  = $result ? $result->num_rows : 0;
?>
<link rel="stylesheet" href="./assets/css/nvc-admin.css">

<div class="nvc-admin-wrap">
  <div class="nvc-card">
    <div class="nvc-card-header">
      <h4 class="nvc-card-title"><i class="ti ti-receipt-2"></i> Riwayat Pembelian <span class="nvc-badge nvc-badge-blue" style="margin-left:6px"><?= $total ?></span></h4>
    </div>

    <div class="nvc-table-wrap">
      <table class="nvc-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Paket</th>
            <th>Tgl Pembelian</th>
            <th>Pembayaran Berikutnya</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()):
              $tglBeli = new DateTime($row['tanggal_pembelian']);
              $tglNext = clone $tglBeli;
              $tglNext->modify('+1 month');
              $st = $row['status_pembelian'] ?? 'aktif';

              // Cek apakah mendekati jatuh tempo (< 7 hari)
              $now      = new DateTime();
              $diff     = $now->diff($tglNext);
              $nearDue  = ($diff->days <= 7 && !$diff->invert);
              $badge    = $st === 'terputus' ? 'nvc-badge-gray' : 'nvc-badge-green';
            ?>
            <tr>
              <td><strong style="color:#3b82f6">#<?= htmlspecialchars($row['id_pembelian']) ?></strong></td>
              <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
              <td>
                <?php if ($row['nama_paket']): ?>
                  <span class="nvc-badge nvc-badge-blue"><?= htmlspecialchars($row['nama_paket']) ?></span>
                <?php else: ?><span style="color:#cbd5e1">-</span><?php endif; ?>
              </td>
              <td style="color:#16a34a;font-weight:600"><?= $tglBeli->format('d M Y') ?></td>
              <td>
                <span style="color:<?= $nearDue ? '#ef4444' : '#64748b' ?>;font-weight:<?= $nearDue ? '700' : '500' ?>">
                  <?= $tglNext->format('d M Y') ?>
                  <?= $nearDue ? ' <span class="nvc-badge nvc-badge-red" style="font-size:10px">Segera</span>' : '' ?>
                </span>
              </td>
              <td><span class="nvc-badge <?= $badge ?>"><?= ucfirst($st) ?></span></td>
              <td>
                <?php if ($st === 'aktif'): ?>
                  <form method="POST" action="admin-page/konfirmasi-pembayaran.php" style="margin:0">
                    <input type="hidden" name="id_pembelian" value="<?= $row['id_pembelian'] ?>">
                    <input type="hidden" name="tanggal_baru" value="<?= $tglNext->format('Y-m-d H:i:s') ?>">
                    <button type="submit" class="btn-nvc btn-nvc-sm btn-nvc-confirm">✅ Bayar</button>
                  </form>
                <?php else: ?>
                  <button class="btn-nvc btn-nvc-sm" style="background:#f1f5f9;color:#cbd5e1;cursor:not-allowed" disabled>🚫</button>
                <?php endif; ?>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr class="no-data"><td colspan="7">Belum ada data pembelian.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
