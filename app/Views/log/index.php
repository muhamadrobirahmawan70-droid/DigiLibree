<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary"></i> Log Aktivitas Sistem</h3>
                    <p class="text-muted small">Pantau semua jejak digital aktivitas user di sini.</p>
                </div>
                <a href="<?= base_url('log/clear') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="return confirm('Hapus semua log? Tindakan ini tidak bisa dibatalkan!')">
                    <i class="bi bi-trash3-fill me-1"></i> Bersihkan Log
                </a>
            </div>
            
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0"> <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Waktu</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>Keterangan</th>
                                    <th>IP Address</th>
                                    <th class="text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log_aktivitas as $l) : ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark"><?= date('d M Y', strtotime($l['created_at'])); ?></span>
                                            <small class="text-muted"><?= date('H:i:s', strtotime($l['created_at'])); ?> WIB</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <span class="fw-semibold"><?= $l['username'] ?? 'Sistem/Unknown'; ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            $aksi = strtolower($l['aksi']);
                                            if(strpos($aksi, 'tambah') !== false) $badgeClass = 'bg-success';
                                            elseif(strpos($aksi, 'hapus') !== false) $badgeClass = 'bg-danger';
                                            elseif(strpos($aksi, 'edit') !== false || strpos($aksi, 'update') !== false) $badgeClass = 'bg-warning text-dark';
                                            elseif(strpos($aksi, 'login') !== false) $badgeClass = 'bg-info text-dark';
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill px-3" style="font-size: 0.7rem;"><?= strtoupper($l['aksi']); ?></span>
                                    </td>
                                    <td class="text-wrap" style="max-width: 200px; font-size: 0.9rem;"><?= $l['keterangan']; ?></td>
                                    <td>
                                        <code class="text-primary bg-light px-2 py-1 rounded small">
                                            <?= $l['ip_address']; ?>
                                        </code>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('log/delete/' . $l['id_log']) ?>" class="btn btn-link text-danger p-0" onclick="return confirm('Hapus baris log ini?')">
                                            <i class="bi bi-x-circle-fill fs-5"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <?php if (empty($log_aktivitas)) : ?>
                <div class="text-center py-5">
                    <i class="bi bi-database-exclamation text-muted display-1"></i>
                    <p class="text-muted mt-3">Belum ada log aktivitas yang tercatat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>