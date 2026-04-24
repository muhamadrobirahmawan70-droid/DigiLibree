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
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error'); ?>
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
                    $tgl_kembali = strtotime($p['tanggal_kembali']);
                    $isOverdue = ($tgl_kembali < time() && ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui'));
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 card-hover-effect <?= $isOverdue ? 'border-start border-danger border-5' : '' ?>">
                        <div class="card-body p-4 d-flex flex-column">
                            
                            <div class="mb-3">
                                <?php if ($p['status'] == 'pending') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-warning text-dark shadow-sm small">Menunggu Izin</span>
                                <?php elseif ($p['status'] == 'ditolak') : ?>
                                    <span class="badge rounded-pill px-3 py-2 bg-danger text-white shadow-sm small">Ditolak</span>
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
                                            <small class="text-muted d-block" style="font-size: 0.7rem;">Total Denda</small>
                                            <span class="fw-bold text-danger">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                                        </div>

                                        <?php if ($p['status_denda'] == 'lunas') : ?>
                                            <span class="badge bg-success rounded-pill px-2 py-1 small">Lunas</span>
                                        <?php elseif ($p['status_denda'] == 'proses') : ?>
                                            <span class="badge bg-info text-white rounded-pill px-2 py-1 small">Mengecek Bukti</span>
                                        <?php else : ?>
                                            <?php if (session()->get('role') != 'admin') : ?>
                                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $p['id_peminjaman'] ?>">
                                                    Bayar
                                                </button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex-grow-1">
                                <?php if ($isOverdue) : ?>
                                    <div class="alert alert-danger py-2 px-3 rounded-4 mb-3 small fw-bold text-center">⚠️ TELAT KEMBALI!</div>
                                <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                    <div class="bg-light rounded-4 p-2 mb-3 text-center border">
                                        <small class="text-muted d-block" style="font-size: 0.65rem;">Batas Kembali</small>
                                        <span class="fw-bold text-danger small"><?= date('d M Y', strtotime($p['tanggal_kembali'])); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-auto">
                                <?php if (session()->get('role') == 'admin') : ?>
                                    <?php if ($p['status_denda'] == 'proses') : ?>
                                        <button type="button" class="btn btn-info text-white w-100 rounded-pill btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCekBukti<?= $p['id_peminjaman'] ?>">
                                            <i class="bi bi-search me-1"></i> Periksa Bukti Bayar
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($p['status'] == 'pending') : ?>
                                        <a href="<?= base_url('peminjaman/persetujuan') ?>" class="btn btn-warning w-100 rounded-pill btn-sm fw-bold">Periksa Izin</a>
                                    <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <a href="https://wa.me/<?= $p['no_hp'] ?? '' ?>" target="_blank" class="btn btn-outline-success rounded-pill w-100 btn-sm">Hubungi WA</a>
                                    <?php else : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled btn-sm">Selesai</button>
                                    <?php endif; ?>

                                <?php else : ?>
                                    <?php if ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                        <form action="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" method="post" class="w-100">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold btn-sm" onclick="return confirm('Kembalikan buku?')">Kembalikan Buku</button>
                                        </form>
                                    <?php elseif ($p['status'] == 'kembali') : ?>
                                        <?php if (isset($p['id_ulasan']) && $p['id_ulasan'] != null) : ?>
                                            <button class="btn btn-light w-100 rounded-pill disabled btn-sm shadow-none">
                                                <i class="bi bi-check-circle-fill text-success me-1"></i> Sudah Diulas
                                            </button>
                                        <?php else : ?>
                                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUlasan<?= $p['id_peminjaman'] ?>">
                                                <i class="bi bi-star-fill me-1"></i> Beri Ulasan
                                            </button>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <button class="btn btn-light w-100 rounded-pill disabled btn-sm">Selesai</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalBayar<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <form action="<?= base_url('peminjaman/konfirmasi_bayar/' . $p['id_peminjaman']) ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fw-bold">Pembayaran Denda 💸</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="small text-muted mb-3">Pilih metode pembayaran di bawah ini</p>
                                    <div class="mb-3 p-2 border rounded-4 bg-light">
                                        <img src="<?= base_url('uploads/bukti_bayar/qris.png') ?>" class="img-fluid rounded-3 mb-2 shadow-sm" style="max-width: 180px;">
                                        <small class="d-block text-muted">Scan QRIS untuk semua E-Wallet</small>
                                    </div>
                                    <div class="mb-4">
                                        <a href="https://link.dana.id/qr/ISI_NOMOR_DANA_KAMU" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm border-0" style="background-color: #118ee1;">
                                            <i class="bi bi-wallet2 me-2"></i> Bayar Langsung via DANA
                                        </a>
                                        <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Atau kirim ke: <strong>0812-xxxx-xxxx</strong> (A/N Perpustakaan)</small>
                                    </div>
                                    <hr class="my-4 opacity-25">
                                    <div class="text-start">
                                        <label class="form-label small fw-bold text-muted">Upload Foto Bukti Transfer</label>
                                        <input type="file" name="bukti_bayar" class="form-control rounded-3" required accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold">Kirim Bukti Pembayaran 🚀</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if (session()->get('role') == 'admin' && $p['status_denda'] == 'proses') : ?>
                <div class="modal fade" id="modalCekBukti<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">Validasi Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="small text-muted">Bukti transfer dari <strong><?= $p['username'] ?></strong></p>
                                <img src="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" class="img-fluid rounded-4 shadow-sm border mb-3">
                                <div class="alert alert-warning small border-0 rounded-3">
                                    Tagihan: <strong>Rp <?= number_format($p['denda'], 0, ',', '.') ?></strong>
                                </div>
                            </div>
                            <div class="modal-footer border-0 gap-2">
                                <a href="<?= base_url('peminjaman/lunas/' . $p['id_peminjaman']) ?>" class="btn btn-success flex-grow-1 rounded-pill fw-bold">Konfirmasi Lunas ✅</a>
                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($p['status'] == 'kembali') : ?>
                <div class="modal fade" id="modalUlasan<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <form action="<?= base_url('peminjaman/simpanUlasan') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_buku" value="<?= $p['id_buku'] ?>">
                                <input type="hidden" name="id_peminjaman" value="<?= $p['id_peminjaman'] ?>">
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