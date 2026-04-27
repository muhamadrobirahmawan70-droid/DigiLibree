<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1">
                <?= (session()->get('role') == 'admin') ? 'Monitoring <span class="text-purple-berry">Transaksi</span> 🕵️‍♂️' : 'Buku yang <span class="text-purple-berry">Aku Pinjam</span> 📖' ?>
            </h3>
            <p class="text-muted small">
                <?= (session()->get('role') == 'admin') ? 'Pantau aktivitas peminjaman dan validasi denda secara real-time.' : 'Jangan lupa kembalikan buku tepat waktu ya!' ?>
            </p>
        </div>
        <div class="col-md-5">
            <form action="" method="get" class="d-flex gap-2 justify-content-md-end">
                <div class="input-group shadow-sm bg-white border rounded-pill overflow-hidden" style="max-width: 250px;">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none small" placeholder="Cari transaksi..." value="<?= $keyword ?? '' ?>">
                </div>
                <button type="submit" class="btn btn-purple-berry shadow-sm px-4 rounded-pill">Cari</button>
            </form>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php if (empty($peminjaman)) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                <h5 class="mt-3 text-muted fw-bold">Wah, kosong melompong...</h5>
            </div>
        <?php else : ?>
            <?php foreach ($peminjaman as $p) : ?>
                <?php 
                    $tgl_kembali = strtotime($p['tanggal_kembali']);
                    $isOverdue = ($tgl_kembali < time() && ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui'));
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 card-berry <?= $isOverdue ? 'border-start border-danger border-5' : '' ?>">
                        <div class="card-body p-4 d-flex flex-column">
                            
                            <div class="mb-3">
                                <?php if ($p['status'] == 'pending') : ?>
                                    <span class="badge-berry bg-warning-soft text-warning">Menunggu Izin</span>
                                <?php elseif ($p['status'] == 'ditolak') : ?>
                                    <span class="badge-berry bg-danger-soft text-danger">Ditolak</span>
                                <?php else : ?>
                                    <span class="badge-berry <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bg-warning-soft text-warning' : 'bg-success-soft text-success' ?>">
                                        <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'Sedang Dipinjam' : 'Sudah Kembali' ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h5 class="fw-bold text-dark mb-1"><?= $p['judul']; ?></h5>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <p class="text-purple-berry small mb-3"><i class="bi bi-person-fill me-1"></i> Peminjam: <strong><?= $p['username']; ?></strong></p>
                            <?php else : ?>
                                <p class="text-muted small mb-3">ID Penulis: <?= $p['id_penulis'] ?? '-' ?></p>
                            <?php endif; ?>

                            <?php if ($p['denda'] > 0) : ?>
                                <div class="p-3 rounded-4 bg-light border mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block extra-small">TOTAL DENDA</small>
                                            <span class="fw-bold text-danger">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                                        </div>
                                        <?php if ($p['status_denda'] == 'lunas') : ?>
                                            <span class="badge bg-success rounded-pill px-2 py-1 small">Lunas</span>
                                        <?php elseif ($p['status_denda'] == 'proses') : ?>
                                            <span class="badge bg-info text-white rounded-pill px-2 py-1 small">Dicek</span>
                                        <?php elseif (session()->get('role') != 'admin') : ?>
                                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $p['id_peminjaman'] ?>">Bayar</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto">
                                <?php if ($isOverdue) : ?>
                                    <div class="alert alert-danger py-2 rounded-3 mb-3 small fw-bold text-center border-0">⚠️ TELAT KEMBALI!</div>
                                <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                    <div class="bg-light rounded-3 p-2 mb-3 text-center border border-dashed">
                                        <small class="text-muted d-block extra-small">BATAS KEMBALI</small>
                                        <span class="fw-bold text-danger small"><?= date('d M Y', strtotime($p['tanggal_kembali'])); ?></span>
                                    </div>
                                <?php endif; ?>

                                <div class="d-grid gap-2">
                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <?php if ($p['status_denda'] == 'proses') : ?>
                                            <button type="button" class="btn btn-info text-white rounded-pill btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalCekBukti<?= $p['id_peminjaman'] ?>">Periksa Bukti</button>
                                        <?php endif; ?>
                                        <?php if ($p['status'] == 'pending') : ?>
                                            <a href="<?= base_url('peminjaman/persetujuan') ?>" class="btn btn-warning rounded-pill btn-sm fw-bold">Periksa Izin</a>
                                        <?php elseif ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                            <a href="https://wa.me/<?= $p['no_hp'] ?? '' ?>" target="_blank" class="btn btn-outline-success rounded-pill btn-sm fw-bold">Hubungi WA</a>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?php if ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') : ?>
                                            <form action="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" method="post">
                                                <?= csrf_field(); ?>
                                                <button type="submit" class="btn btn-purple-berry w-100 rounded-pill fw-bold btn-sm" onclick="return confirm('Kembalikan buku?')">Kembalikan Buku</button>
                                            </form>
                                        <?php elseif ($p['status'] == 'kembali') : ?>
                                            <?php if (!isset($p['id_ulasan']) || $p['id_ulasan'] == null) : ?>
                                                <button type="button" class="btn btn-outline-purple-berry btn-sm rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalUlasan<?= $p['id_peminjaman'] ?>">Beri Ulasan</button>
                                            <?php else : ?>
                                                <button class="btn btn-light rounded-pill disabled btn-sm">Sudah Diulas</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
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
                        <img src="<?= base_url('uploads/bukti_bayar/qris.png') ?>" class="img-fluid rounded-3 mb-2 shadow-sm" style="max-width: 150px;">
                        <small class="d-block text-muted">Scan QRIS untuk semua E-Wallet</small>
                    </div>

                    <div class="mb-4">
                        <a href="https://link.dana.id/qr/MASUKKAN_NOMOR_DANA_DISINI" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm border-0 py-2" style="background-color: #118ee1;">
                            <i class="bi bi-wallet2 me-2"></i> Bayar Langsung via DANA
                        </a>
                        <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">
                            Atau transfer manual ke: <br>
                            <strong class="text-dark">0812-xxxx-xxxx</strong> (A/N Perpustakaan)
                        </small>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="text-start">
                        <label class="form-label small fw-bold text-muted">Upload Foto Bukti Transfer</label>
                        <input type="file" name="bukti_bayar" class="form-control rounded-3" required accept="image/*">
                        <div class="form-text" style="font-size: 0.7rem;">Wajib upload bukti agar admin bisa konfirmasi.</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-purple-berry w-100 rounded-pill py-2 fw-bold">Kirim Bukti Pembayaran 🚀</button>
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
                                <img src="<?= base_url('uploads/bukti_bayar/' . $p['bukti_bayar']) ?>" class="img-fluid rounded-4 shadow-sm border mb-3">
                                <div class="alert alert-warning small border-0">Tagihan: <strong>Rp <?= number_format($p['denda'], 0, ',', '.') ?></strong></div>
                            </div>
                            <div class="modal-footer border-0 gap-2">
                                <a href="<?= base_url('peminjaman/lunas/' . $p['id_peminjaman']) ?>" class="btn btn-success flex-grow-1 rounded-pill fw-bold">Konfirmasi Lunas ✅</a>
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
                                <div class="modal-header border-0">
                                    <h5 class="modal-title fw-bold">Ulas Buku</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Rating</label>
                                        <select name="rating" class="form-select rounded-3 border-0 bg-light" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                                            <option value="4">⭐⭐⭐⭐ (Bagus)</option>
                                            <option value="3">⭐⭐⭐ (Cukup)</option>
                                            <option value="2">⭐⭐ (Kurang)</option>
                                            <option value="1">⭐ (Buruk)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Komentar</label>
                                        <textarea name="komentar" class="form-control rounded-4 border-0 bg-light" rows="3" placeholder="Apa kesanmu?"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-purple-berry w-100 rounded-pill py-2 fw-bold">Kirim Review 🚀</button>
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
    .text-purple-berry { color: #673ab7; }
    .btn-purple-berry { background: #673ab7; color: white; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; }
    .btn-outline-purple-berry { border: 1.5px solid #673ab7; color: #673ab7; }
    .btn-outline-purple-berry:hover { background: #673ab7; color: white; }
    .card-berry { transition: all 0.3s ease; border: 1px solid #eee; }
    .card-berry:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .badge-berry { padding: 5px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; }
    .bg-warning-soft { background: #fff9db; color: #856404; }
    .bg-success-soft { background: #e6fcf5; color: #155724; }
    .bg-danger-soft { background: #fff5f5; color: #e03131; }
    .extra-small { font-size: 0.65rem; letter-spacing: 0.5px; }
    .rounded-4 { border-radius: 1rem !important; }
</style>

<?= $this->endSection() ?>