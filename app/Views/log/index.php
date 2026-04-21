<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">
    <div class="row">
        <div class="col-md-11 mx-auto">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -1px;">
                        <i class="bi bi-shield-lock-fill text-primary me-2"></i>Log Aktivitas Sistem
                    </h2>
                    <p class="text-muted mb-0">Memantau rekam jejak digital dan integritas sistem secara real-time.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('log/clear') ?>" class="btn btn-white shadow-sm rounded-4 px-4 fw-bold text-danger border-0 transition-hover" onclick="return confirm('Hapus semua log? Tindakan ini tidak bisa dibatalkan!')">
                        <i class="bi bi-trash3 me-2"></i>Bersihkan Semua
                    </a>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <small class="text-muted fw-bold text-uppercase ls-1" style="font-size: 0.65rem;">Total Rekaman</small>
                        <h4 class="fw-bold mb-0 text-primary"><?= count($log_aktivitas) ?> <small class="text-muted fs-6 fw-normal">Log</small></h4>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">Timestamp</th>
                                    <th class="py-3 border-0 text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">User</th>
                                    <th class="py-3 border-0 text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">Aksi</th>
                                    <th class="py-3 border-0 text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">Detail Keterangan</th>
                                    <th class="py-3 border-0 text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">IP Address</th>
                                    <th class="py-3 border-0 text-center text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log_aktivitas as $l) : ?>
                                <tr class="transition-hover">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark"><?= date('d M Y', strtotime($l['created_at'])); ?></span>
                                            <small class="text-muted opacity-75"><i class="bi bi-clock me-1"></i><?= date('H:i:s', strtotime($l['created_at'])); ?> WIB</small>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                <i class="bi bi-person-badge-fill fs-5"></i>
                                            </div>
                                            <span class="fw-bold text-dark"><?= $l['username'] ?? 'System'; ?></span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <?php 
                                            $badgeClass = 'bg-secondary';
                                            $icon = 'bi-info-circle';
                                            $aksi = strtolower($l['aksi']);
                                            if(strpos($aksi, 'tambah') !== false) { $badgeClass = 'bg-success'; $icon = 'bi-plus-circle'; }
                                            elseif(strpos($aksi, 'hapus') !== false) { $badgeClass = 'bg-danger'; $icon = 'bi-trash'; }
                                            elseif(strpos($aksi, 'edit') !== false || strpos($aksi, 'update') !== false) { $badgeClass = 'bg-warning text-dark'; $icon = 'bi-pencil'; }
                                            elseif(strpos($aksi, 'login') !== false) { $badgeClass = 'bg-info text-dark'; $icon = 'bi-door-open'; }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-2 fw-bold shadow-sm" style="font-size: 0.65rem;">
                                            <i class="bi <?= $icon ?> me-1"></i><?= strtoupper($l['aksi']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <p class="mb-0 text-muted small lh-sm" style="max-width: 250px; font-weight: 500;">
                                            <?= $l['keterangan']; ?>
                                        </p>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-primary border rounded-3 px-2 py-1 font-monospace" style="font-size: 0.8rem;">
                                            <i class="bi bi-pc-display me-1"></i><?= $l['ip_address']; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <a href="<?= base_url('log/delete/' . $l['id_log']) ?>" class="btn btn-light btn-sm rounded-circle text-danger shadow-none hover-danger" onclick="return confirm('Hapus baris log ini?')">
                                            <i class="bi bi-trash3"></i>
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
                <div class="text-center py-5 mt-4 card border-0 shadow-sm rounded-5 bg-white">
                    <div class="py-4">
                        <i class="bi bi-database-dash text-light-gray display-1"></i>
                        <h4 class="fw-bold text-muted mt-3">Log Kosong</h4>
                        <p class="text-muted opacity-50">Belum ada jejak aktivitas yang tercatat dalam sistem.</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .ls-1 { letter-spacing: 1px; }
    .text-light-gray { color: #e2e8f0; }

    /* Table Styling */
    .table thead th { background-color: #f8fafc; border-bottom: 1px solid #edf2f7 !important; }
    .table tbody tr { border-bottom: 1px solid #f1f5f9; }
    .table tbody tr:last-child { border-bottom: none; }

    /* Transition & Hover */
    .transition-hover { transition: all 0.2s ease; }
    .transition-hover:hover { background-color: #f8faff !important; transform: scale(1.002); }

    .btn-white { background: #fff; color: #64748b; }
    .btn-white:hover { background: #f8fafc; color: #ef4444; transform: translateY(-2px); }

    .hover-danger:hover { background-color: #fee2e2 !important; color: #dc2626 !important; }

    .font-monospace { font-family: 'SFMono-Regular', Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important; }

    /* Custom Scrollbar for Table */
    .table-responsive::-webkit-scrollbar { height: 8px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f5f9; }
    .table-responsive::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<?= $this->endSection() ?>