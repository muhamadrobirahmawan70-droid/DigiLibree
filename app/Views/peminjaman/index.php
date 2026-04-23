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
                    $isOverdue = (strtotime($p['tanggal_kembali']) < time() && ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui'));
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect <?= $isOverdue ? 'border-start border-danger border-5' : '' ?>">
                        <div class="card-body p-4 d-flex flex-column">
                            
                            <div class="mb-3">
                                <?php if ($p['status'] == 'pending') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-warning text-dark shadow-sm small">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu Izin
                                    </span>
                                <?php elseif ($p['status'] == 'ditolak') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-danger text-white shadow-sm small">
                                        <i class="bi bi-x-circle me-1"></i> Izin Ditolak
                                    </span>
                                <?php else : ?>
                                    <span class="badge rounded-pill px-3 py-2 <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bg-soft-warning text-warning' : 'bg-soft-success text-success' ?> shadow-sm small">
                                        <i class="bi <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bi-hourglass-split' : 'bi-check-circle-fill' ?> me-1"></i>
                                        <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'Sedang Dipinjam' : 'Sudah Kembali' ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <h5 class="fw-bold text-dark mb-1"><?= $p['judul']; ?></h5>
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <p class="text-primary small mb-0"><i class="bi bi-person-fill me-1"></i> Peminjam: <strong><?= $p['username']; ?></strong></p>
                                <?php else : ?>
                                    <p class="text-muted small mb-0">ID Penulis: <?= $p['id_penulis'] ?? '-' ?></p>
                                <?php endif; ?>
                            </div>

                            <?php if ($p['denda'] > 0) : ?>
                                <div class="p-3 rounded-4 border-start border-danger border-4 bg-light mb-3 shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Denda</small>
                                            <span class="fw-bold text-danger">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                                        </div>
                                        <?php if ($p['status_denda'] == 'belum_bayar') : ?>
                                            <form action="<?= base_url('peminjaman/konfirmasi_bayar/' . $p['id_peminjaman']) ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold">Bayar</button>
                                            </form>
                                        <?php else : ?>
                                            <span class="badge bg-success rounded-pill px-2 py-1 small">Lunas</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex-grow-1">
                                <?php if ($p['status'] == 'pending') : ?>
                                    <div class="alert alert-info border-0 py-2 px-3 rounded-4 mb-3 small">Limit peminjaman tercapai.</div>
                                <?php elseif ($isOverdue) : ?>
                                    <div class="alert alert-danger py-2 px-3 rounded-4 mb-3 small fw-bold">TELAT KEMBALI!</div>
                                <?php elseif ($p['status'] != 'kembali' && $p['status'] != 'ditolak') : ?>
                                    <div class="bg-light rounded-4 p-2 mb-3 text-center border">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Batas Kembali</small>
                                        <span class="fw-bold text-danger small"><?= date('d M Y', strtotime($p['tanggal_kembali'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <?php if ($p['status'] == 'pending') : ?>
                                        <a href="<?= base_url('peminjaman/persetujuan') ?>" class="btn btn-warning w-100 rounded-pill btn-sm fw-bold">Periksa Izin</a>
                                    <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <a href="https://wa.me/<?= $p['no_hp'] ?? '' ?>?text=Halo%20<?= $p['username'] ?>!" target="_blank" class="btn btn-outline-success rounded-pill w-100 btn-sm">Hubungi WA</a>
                                    <?php else : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled btn-sm">Transaksi Selesai</button>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <form action="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" method="post" class="w-100">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold btn-sm" onclick="return confirm('Kembalikan buku?')">Kembalikan</button>
                                        </form>
                                    <?php elseif ($p['status'] == 'kembali') : ?>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill w-100 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUlasan<?= $p['id_peminjaman'] ?>">
                                                <i class="bi bi-star-fill me-1"></i> Beri Ulasan
                                            </button>
                                        </div>
                                    <?php else : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled btn-sm">Selesai</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($p['status'] == 'kembali') : ?>
                <div class="modal fade" id="modalUlasan<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <form action="<?= base_url('peminjaman/simpanUlasan') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_buku" value="<?= $p['id_buku'] ?>">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Ulas: <?= $p['judul'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 text-center">
                                        <label class="form-label d-block fw-bold text-muted small">Rating</label>
                                        <select name="rating" class="form-select rounded-3 border-0 bg-light py-2" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                            <option value="3">⭐⭐⭐ (Cukup)</option>
                                            <option value="2">⭐⭐ (Kurang)</option>
                                            <option value="1">⭐ (Buruk)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted small">Komentar</label>
                                        <textarea name="komentar" class="form-control rounded-4 border-0 bg-light p-3" rows="3" placeholder="Ceritakan kesanmu..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Kirim Review 🚀</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .card-hover-effect { transition: all 0.3s ease; }
    .card-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .bg-soft-warning { background-color: #fff9db; color: #856404; }
    .bg-soft-success { background-color: #e6fcf5; color: #155724; }
    .rounded-4 { border-radius: 1rem !important; }
</style>

<?= $this->endSection() ?>