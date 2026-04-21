<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                        <i class="bi bi-shield-check text-primary fs-3"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Persetujuan Peminjaman 🔑</h3>
                        <p class="text-muted mb-0">Kelola permintaan pinjam user yang melebihi limit jatah buku.</p>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold text-muted" width="250">Nama Member</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Buku yang Diminta</th>
                                <th class="py-3 text-uppercase small fw-bold text-muted">Tgl Pengajuan</th>
                                <th class="py-3 text-center text-uppercase small fw-bold text-muted">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($requests)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bi bi-inboxes text-muted fs-1 d-block mb-3"></i>
                                            <h5 class="text-muted fw-normal">Tidak ada antrean persetujuan saat ini.</h5>
                                            <p class="text-muted small">Semua permintaan sudah diproses, min!</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $r): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3 bg-soft-primary rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold" style="width:40px; height:40px; background:#e0e7ff;">
                                                    <?= substr($r['nama'], 0, 1) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark"><?= $r['nama'] ?></div>
                                                    <small class="text-muted">Member DigiLibree</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-primary"><?= $r['judul'] ?></div>
                                            <small class="text-muted italic">Minta jatah lebih (Limit Terlampaui)</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border fw-normal py-2 px-3">
                                                <i class="bi bi-calendar-event me-1"></i> <?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?>
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('peminjaman/approve/' . $r['id_peminjaman']) ?>" 
                                                   class="btn btn-success rounded-pill px-3 btn-sm fw-bold shadow-sm"
                                                   onclick="return confirm('Berikan izin pinjam buku ini?')">
                                                    <i class="bi bi-check2-circle me-1"></i> Izinkan
                                                </a>
                                                <a href="<?= base_url('peminjaman/reject/' . $r['id_peminjaman']) ?>" 
                                                   class="btn btn-outline-danger rounded-pill px-3 btn-sm fw-bold shadow-sm"
                                                   onclick="return confirm('Tolak permintaan ini?')">
                                                    <i class="bi bi-x-circle me-1"></i> Tolak
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .table thead th { border-bottom: none; font-size: 0.75rem; }
    .btn-success { background-color: #10b981; border: none; }
    .btn-success:hover { background-color: #059669; transform: translateY(-1px); }
    .btn-outline-danger:hover { transform: translateY(-1px); }
</style>

<?= $this->endSection() ?>