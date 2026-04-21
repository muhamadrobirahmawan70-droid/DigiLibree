<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="fw-bold text-dark">
                <?= (session()->get('role') == 'admin') ? 'Monitoring Transaksi 🕵️‍♂️' : 'Buku yang Aku Pinjam 📖' ?>
            </h2>
            <p class="text-muted">
                <?= (session()->get('role') == 'admin') ? 'Pantau pergerakan buku tanpa perlu ribet konfirmasi.' : 'Sudah selesai baca? Yuk kembalikan bukunya tepat waktu!' ?>
            </p>
        </div>
        <div class="col-md-6 text-md-end">
            <form action="" method="get" class="d-inline-flex gap-2 w-100 justify-content-md-end">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white border" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none" placeholder="Cari data..." value="<?= $keyword ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-secondary rounded-pill px-4">Cari</button>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="row g-3">
        <?php if (empty($peminjaman)) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                <h4 class="mt-3 text-muted">Belum ada transaksi nih... Kosong melompong!</h4>
            </div>
        <?php else : ?>
            <?php foreach ($peminjaman as $p) : ?>
                <?php 
                    // Logika Telat (Hanya jika status sudah aktif pinjam)
                    $isOverdue = (strtotime($p['tanggal_kembali']) < time() && ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui'));
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect <?= $isOverdue ? 'border-start border-danger border-5' : '' ?>">
                        <div class="card-body p-4">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <?php if ($p['status'] == 'pending') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-warning text-dark shadow-sm" style="font-size: 0.75rem;">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu Izin
                                    </span>
                                <?php elseif ($p['status'] == 'ditolak') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-danger text-white shadow-sm" style="font-size: 0.75rem;">
                                        <i class="bi bi-x-circle me-1"></i> Izin Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="badge rounded-pill px-3 py-2 <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success' ?>" 
                                          style="background-color: <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? '#fff9db' : '#e6fcf5' ?>; font-size: 0.75rem;">
                                        <i class="bi <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bi-hourglass-split' : 'bi-check-circle-fill' ?> me-1"></i>
                                        <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'Sedang Dipinjam' : 'Sudah Kembali' ?>
                                    </span>
                                <?php endif; ?>

                                <?php if ($p['denda'] > 0) : ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2" style="font-size: 0.75rem;">Denda: Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                                <?php endif; ?>
                            </div>

                            <h5 class="fw-bold text-dark mb-1"><?= $p['judul']; ?></h5>
                            
                            <?php if (session()->get('role') == 'admin') : ?>
                                <p class="text-primary mb-3 small"><i class="bi bi-person-fill me-1"></i> Peminjam: <strong><?= $p['username']; ?></strong></p>
                            <?php else : ?>
                                <p class="text-muted small mb-3">ID Penulis: <?= $p['id_penulis'] ?? '-' ?></p>
                            <?php endif; ?>

                            <?php if ($p['status'] == 'pending') : ?>
                                <div class="alert alert-info border-0 py-2 px-3 rounded-4 mb-3" style="font-size: 0.8rem; background-color: #e0f2fe; color: #0369a1;">
                                    <i class="bi bi-info-circle-fill me-2"></i> Buku ini melebihi limit pinjam, menunggu ACC admin.
                                </div>
                            <?php elseif ($p['status'] == 'ditolak') : ?>
                                <div class="alert alert-danger border-0 py-2 px-3 rounded-4 mb-3" style="font-size: 0.8rem; background-color: #fee2e2; color: #b91c1c;">
                                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Maaf, pengajuan pinjam ditolak admin.
                                </div>
                            <?php elseif ($isOverdue) : ?>
                                <div class="alert alert-danger py-2 px-3 rounded-4 mb-3" style="font-size: 0.85rem;">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <strong>TELAT!</strong> Segera kembalikan bukunya ya!
                                </div>
                            <?php else : ?>
                                <div class="row g-0 bg-light rounded-4 p-3 mb-3 text-center">
                                    <div class="col-12">
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Batas Pengembalian</small>
                                        <span class="fw-bold text-danger" style="font-size: 0.9rem;"><i class="bi bi-calendar-event me-1"></i> <?= date('d M Y', strtotime($p['tanggal_kembali'])); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex gap-2">
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <?php if ($p['status'] == 'pending') : ?>
                                        <a href="<?= base_url('peminjaman/persetujuan') ?>" class="btn btn-warning w-100 rounded-pill btn-sm fw-bold">
                                            <i class="bi bi-shield-lock me-1"></i> Periksa Izin
                                        </a>
                                    <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <div class="bg-light text-center p-2 rounded-pill w-100 small text-muted border" style="font-size: 0.75rem;">
                                            Menunggu User Mengembalikan...
                                        </div>
                                        <a href="https://wa.me/<?= $p['no_hp'] ?? '' ?>?text=Halo%20<?= $p['username'] ?>,%20jangan%20lupa%20balikin%20buku%20*<?= $p['judul'] ?>*%20ya!" 
                                           target="_blank" class="btn btn-outline-success rounded-circle p-2 shadow-sm" title="Tagih via WA">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    <?php else : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled text-muted small">Transaksi Selesai</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <form action="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" method="post" class="w-100">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold btn-sm shadow-sm" onclick="return confirm('Sudah selesai bacanya, min?')">
                                                <i class="bi bi-arrow-return-left me-1"></i> Kembalikan Sekarang
                                            </button>
                                        </form>
                                    <?php elseif ($p['status'] == 'pending') : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled text-muted border small" style="font-size: 0.75rem;">
                                            <i class="bi bi-hourglass-split"></i> Sedang Diproses
                                        </button>
                                    <?php elseif ($p['status'] == 'ditolak') : ?>
                                        <button class="btn btn-outline-danger w-100 rounded-pill disabled small" style="font-size: 0.75rem;">
                                            <i class="bi bi-x-circle"></i> Tidak Diizinkan
                                        </button>
                                    <?php else : ?>
                                        <button class="btn btn-outline-success w-100 rounded-pill fw-bold btn-sm shadow-none disabled">
                                            <i class="bi bi-check-all me-1"></i> Sudah Dikembalikan
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .card-hover-effect { transition: all 0.3s ease; }
    .card-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .bg-soft-warning { color: #856404; }
    .bg-soft-success { color: #155724; }
    .rounded-4 { border-radius: 1rem !important; }
</style>

<?= $this->endSection() ?>