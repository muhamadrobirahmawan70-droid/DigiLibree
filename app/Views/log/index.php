<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="row align-items-center mb-4">
        <div class="col-md-8">
            <h3 class="fw-bold text-dark mb-1">Log <span class="text-purple-berry">Aktivitas</span> Sistem 🛡️</h3>
            <p class="text-muted small">Memantau rekam jejak digital dan integritas sistem secara real-time.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="<?= base_url('log/clear') ?>" 
               class="btn btn-outline-danger shadow-sm rounded-pill px-4 fw-bold btn-sm" 
               onclick="return confirm('Hapus semua log? Tindakan ini tidak bisa dibatalkan!')">
                <i class="bi bi-trash3 me-2"></i>Bersihkan Semua
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="avatar-circle bg-purple-berry text-white me-3">
                        <i class="bi bi-database"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase extra-small d-block">Total Rekaman</small>
                        <h4 class="fw-bold mb-0 text-dark"><?= count($log_aktivitas) ?> <small class="text-muted fs-6 fw-normal">Log</small></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted fw-bold text-uppercase extra-small">Waktu</th>
                        <th class="py-3 text-muted fw-bold text-uppercase extra-small">User</th>
                        <th class="py-3 text-muted fw-bold text-uppercase extra-small">Aksi</th>
                        <th class="py-3 text-muted fw-bold text-uppercase extra-small">Detail Keterangan</th>
                        <th class="py-3 text-muted fw-bold text-uppercase extra-small">IP Address</th>
                        <th class="py-3 text-center text-muted fw-bold text-uppercase extra-small">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($log_aktivitas as $l) : ?>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex flex-column">
                                <span class="fw-bold text-dark small"><?= date('d M Y', strtotime($l['created_at'])); ?></span>
                                <small class="text-muted extra-small"><i class="bi bi-clock me-1"></i><?= date('H:i:s', strtotime($l['created_at'])); ?> WIB</small>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-purple-berry rounded-3 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <span class="fw-bold text-dark small"><?= $l['username'] ?? 'System'; ?></span>
                            </div>
                        </td>
                        <td class="py-3">
                            <?php 
                                $badgeStyle = 'bg-secondary-soft text-secondary';
                                $icon = 'bi-info-circle';
                                $aksi = strtolower($l['aksi']);
                                if(strpos($aksi, 'tambah') !== false) { $badgeStyle = 'bg-success-soft text-success'; $icon = 'bi-plus-circle'; }
                                elseif(strpos($aksi, 'hapus') !== false) { $badgeStyle = 'bg-danger-soft text-danger'; $icon = 'bi-trash'; }
                                elseif(strpos($aksi, 'edit') !== false || strpos($aksi, 'update') !== false) { $badgeStyle = 'bg-warning-soft text-warning'; $icon = 'bi-pencil-square'; }
                                elseif(strpos($aksi, 'login') !== false) { $badgeStyle = 'bg-info-soft text-info'; $icon = 'bi-shield-check'; }
                            ?>
                            <span class="badge-berry <?= $badgeStyle ?> fw-bold">
                                <i class="bi <?= $icon ?> me-1"></i><?= strtoupper($l['aksi']); ?>
                            </span>
                        </td>
                        <td class="py-3">
                            <p class="mb-0 text-muted small lh-sm" style="max-width: 300px;">
                                <?= $l['keterangan']; ?>
                            </p>
                        </td>
                        <td class="py-3">
                            <code class="text-purple-berry bg-light px-2 py-1 rounded small"><?= $l['ip_address']; ?></code>
                        </td>
                        <td class="py-3 text-center">
                            <a href="<?= base_url('log/delete/' . $l['id_log']) ?>" 
                               class="btn btn-link text-danger p-0" 
                               onclick="return confirm('Hapus baris log ini?')">
                                <i class="bi bi-x-circle-fill fs-5"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($log_aktivitas)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-database-exclamation display-4 text-muted opacity-25"></i>
                                <p class="text-muted fw-bold mt-2">Belum ada aktivitas yang tercatat.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Global Styles */
    .text-purple-berry { color: #673ab7; }
    .bg-purple-berry { background: #673ab7; }
    .extra-small { font-size: 0.65rem; letter-spacing: 0.5px; }
    
    /* Soft Badges */
    .badge-berry {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 0.7rem;
        display: inline-block;
    }
    .bg-success-soft { background: #e6fcf5; color: #0ca678; }
    .bg-danger-soft { background: #fff5f5; color: #e03131; }
    .bg-warning-soft { background: #fff9db; color: #f08c00; }
    .bg-info-soft { background: #e7f5ff; color: #1c7ed6; }
    .bg-secondary-soft { background: #f8f9fa; color: #495057; }

    /* Avatar Circle */
    .avatar-circle {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Table UI */
    .table thead th { border-bottom: none; background-color: #f8f9fa; }
    .table-hover tbody tr:hover { background-color: #fcfaff; transition: 0.2s; }
    
    .card { border-radius: 1rem !important; }
    code { font-size: 0.8rem; border: 1px solid #eee; }
</style>

<?= $this->endSection() ?>