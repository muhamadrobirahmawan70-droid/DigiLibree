<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate-shake">
            <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->get('role') != 'admin') : ?>
        <?php 
            $totalDendaUser = 0;
            foreach ($peminjaman as $p) {
                if ($p['denda'] > 0 && $p['status_denda'] != 'lunas') $totalDendaUser += $p['denda'];
            }
        ?>
        <?php if ($totalDendaUser > 0) : ?>
            <div class="alert bg-danger text-white border-0 shadow-lg rounded-4 mb-4 p-4 animate-shake position-relative overflow-hidden">
                <div class="d-flex align-items-center position-relative" style="z-index: 2;">
                    <div class="bg-white text-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm me-3" style="min-width: 50px; height: 50px;">
                        <i class="bi bi-megaphone-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Tagihan Terdeteksi! 📢</h5>
                        <p class="mb-0 small opacity-90">Ada denda sebesar <strong>Rp <?= number_format($totalDendaUser, 0, ',', '.'); ?></strong>. Yuk, segera dilunasi!</p>
                    </div>
                </div>
                <i class="bi bi-cash-stack position-absolute end-0 top-50 translate-middle-y opacity-25 me-3" style="font-size: 4rem;"></i>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1">
                <?= (session()->get('role') == 'admin') ? 'Monitoring <span class="text-purple-berry">Transaksi</span> 🕵️‍♂️' : 'Buku yang <span class="text-purple-berry">Aku Pinjam</span> 📖' ?>
            </h3>
            <p class="text-muted small">Kelola data peminjaman dan denda dengan mudah.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <form action="" method="get" class="d-inline-block">
                <div class="input-group shadow-sm bg-white border rounded-pill overflow-hidden" style="max-width: 250px;">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 shadow-none small" placeholder="Cari transaksi..." value="<?= $keyword ?? '' ?>">
                    <button type="submit" class="btn btn-purple-berry px-3 border-0">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($peminjaman)) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                <h5 class="mt-3 text-muted fw-bold">Belum ada transaksi...</h5>
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
                            
                            <div class="d-flex justify-content-between mb-3 align-items-center">
                                <span class="badge-berry <?= ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui') ? 'bg-warning-soft text-warning' : ($p['status'] == 'kembali' ? 'bg-success-soft text-success' : 'bg-danger-soft text-danger') ?>">
                                    <?= $p['status'] ?>
                                </span>
                                <?php if ($isOverdue) : ?>
                                    <span class="badge bg-danger rounded-pill pulse-red px-2 py-1 extra-small fw-bold shadow-sm">TELAT!</span>
                                <?php endif; ?>
                            </div>

                            <h5 class="fw-bold text-dark mb-1 text-truncate"><?= $p['judul']; ?></h5>
                            <p class="text-muted small mb-3"><i class="bi bi-person-circle me-1"></i> <?= $p['username'] ?></p>

                            <?php if ($p['denda'] > 0) : ?>
                                <div class="p-3 rounded-4 bg-light border mb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted d-block extra-small fw-bold">TOTAL DENDA</small>
                                            <span class="fw-bold text-danger">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                                            <?php if(!empty($p['catatan'])): ?>
                                                <small class="d-block text-muted italic small mt-1">*<?= $p['catatan'] ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <?php if ($p['status_denda'] == 'lunas') : ?>
                                            <span class="badge bg-success rounded-pill px-3 py-2 small">Lunas</span>
                                        <?php elseif ($p['status_denda'] == 'proses') : ?>
                                            <span class="badge bg-info text-white rounded-pill px-3 py-2 small">Dicek Admin</span>
                                        <?php elseif (session()->get('role') != 'admin') : ?>
                                            <button class="btn btn-sm btn-danger rounded-pill px-3 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalBayar<?= $p['id_peminjaman'] ?>">Bayar</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->get('role') == 'admin' && $p['status'] == 'kembali' && $p['status_denda'] != 'lunas') : ?>
                                <div class="bg-purple-soft p-3 rounded-4 mb-3 border border-purple">
                                    <form action="<?= base_url('peminjaman/set_denda_manual/' . $p['id_peminjaman']) ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="input-group input-group-sm mb-2 shadow-sm rounded-pill border overflow-hidden bg-white">
                                            <span class="input-group-text bg-danger text-white border-0 small">Rp</span>
                                            <input type="number" name="nominal_denda" class="form-control border-0" placeholder="Set denda" value="<?= $p['denda'] ?? 0 ?>">
                                            <button class="btn btn-danger btn-sm px-3" type="submit">Set</button>
                                        </div>
                                        <input type="text" name="catatan" class="form-control form-control-sm rounded-pill border mb-2 bg-white" placeholder="Catatan rusak/hilang..." value="<?= $p['catatan'] ?? '' ?>">
                                        <a href="<?= base_url('peminjaman/lunas/' . $p['id_peminjaman']) ?>" class="btn btn-success btn-sm w-100 rounded-pill fw-bold" onclick="return confirm('Konfirmasi buku aman dan transaksi selesai?')">Buku Aman (Lunas)</a>
                                    </form>
                                </div>
                            <?php endif; ?>

                            <div class="mt-auto">
                                <div class="bg-light rounded-3 p-2 mb-3 text-center border border-dashed">
                                    <small class="text-muted d-block extra-small">BATAS KEMBALI</small>
                                    <span class="fw-bold <?= $isOverdue ? 'text-danger' : 'text-dark' ?> small"><?= date('d M Y', strtotime($p['tanggal_kembali'])); ?></span>
                                </div>

                                <div class="d-grid gap-2">
                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <?php if ($p['status_denda'] == 'proses') : ?>
                                            <button type="button" class="btn btn-info text-white rounded-pill btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalValidasi<?= $p['id_peminjaman'] ?>">Validasi Bukti Bayar</button>
                                        <?php endif; ?>
                                        
                                        <?php if ($p['denda'] > 0 && $p['status_denda'] != 'lunas') : ?>
                                            <a href="https://wa.me/<?= $p['telepon'] ?? '' ?>?text=Halo%20<?= $p['username'] ?>,%20ada%20tagihan%20denda%20Rp<?= number_format($p['denda'], 0, ',', '.') ?>%20untuk%20buku%20'<?= $p['judul'] ?>'.%20Segera%20dilunasi%20ya!" target="_blank" class="btn btn-outline-success rounded-pill btn-sm fw-bold">
                                                <i class="bi bi-whatsapp me-1"></i> Sentil User
                                            </a>
                                        <?php endif; ?>

                                    <?php elseif (session()->get('role') != 'admin' && ($p['status'] == 'dipinjam' || $p['status'] == 'disetujui')) : ?>
                                        <form action="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <button type="submit" class="btn btn-purple-berry w-100 rounded-pill fw-bold btn-sm shadow-sm" onclick="return confirm('Pastikan buku sudah dikembalikan ke petugas perpus?')">Kembalikan Buku</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalBayar<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Pelunasan Denda 💸</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="<?= base_url('peminjaman/bayar_denda/' . $p['id_peminjaman']) ?>" method="post" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                <div class="modal-body">
                                    <div class="alert bg-light border text-center mb-3">
                                        <small class="text-muted d-block">Total yang harus dibayar:</small>
                                        <strong class="fs-4 text-danger">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></strong>
                                    </div>

                                    <div class="text-center mb-4 p-3 border rounded-4 bg-white shadow-sm">
                                        <h6 class="fw-bold mb-2 small">Scan QRIS untuk Bayar:</h6>    
                                        <img src="<?= base_url('uploads/images/qris.jpg.png') ?>" 
                                             class="img-fluid rounded-3 mb-3 shadow-sm zoom-foto" 
                                             style="max-width: 180px;" 
                                             alt="QRIS Pembayaran"
                                             onerror="this.src='https://placehold.co/200x200?text=QRIS+Tersedia+Di+Public';">
                                        
                                        <div class="d-grid mt-2">
                                            <a href="https://link.dana.id/qr/NOMOR_MIMIN" target="_blank" class="btn btn-primary btn-sm rounded-pill fw-bold">
                                                <i class="bi bi-wallet2 me-1"></i> Bayar via Link DANA
                                            </a>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-bold">Upload Bukti Transfer (JPG/PNG)</label>
                                        <input type="file" name="bukti_bayar" class="form-control rounded-pill shadow-sm" required accept="image/*">
                                        <small class="text-muted extra-small mt-1 d-block text-center">Pastikan nominal sesuai dengan denda.</small>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="submit" class="btn btn-purple-berry w-100 rounded-pill shadow fw-bold">Kirim Konfirmasi Ke Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalValidasi<?= $p['id_peminjaman'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 border-0 shadow-lg">
                            <div class="modal-header border-0">
                                <h5 class="fw-bold">Validasi Bukti Bayar</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <p class="small text-muted">Periksa kesesuaian nominal pada bukti transfer</p>
                                <img src="<?= base_url('bukti_bayar/' . ($p['bukti_bayar'] ?? '')) ?>" 
                                class="img-fluid rounded-4 mb-3 border" 
                                style="max-height: 400px; width: 100%; object-fit: contain;"
                                onerror="this.src='https://placehold.co/400x400?text=Belum+Ada+Bukti';">
                                
                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('peminjaman/lunas/' . $p['id_peminjaman']) ?>" class="btn btn-success rounded-pill fw-bold shadow">Konfirmasi Lunas & Selesai</a>
                                    <button type="button" class="btn btn-light rounded-pill btn-sm text-muted" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    /* ... Style Mimin sudah oke, saya tambahkan sedikit optimasi ... */
    .bg-purple-soft { background: #f3e5f5; color: #673ab7; }
    .border-purple { border: 1px dashed #673ab7 !important; }
    .text-purple-berry { color: #673ab7; }
    .btn-purple-berry { background: #673ab7; color: white; border: none; transition: 0.3s; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; transform: scale(1.05); }
    .card-berry { transition: all 0.3s ease; border: 1px solid #f0f0f0; }
    .card-berry:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .badge-berry { padding: 6px 12px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
    .bg-warning-soft { background: #fff9db; color: #856404; }
    .bg-success-soft { background: #e6fcf5; color: #155724; }
    .bg-danger-soft { background: #fff5f5; color: #e03131; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .extra-small { font-size: 0.65rem; }
    
    .zoom-foto { transition: transform 0.3s ease; cursor: zoom-in; }
    .zoom-foto:active { transform: scale(1.5); z-index: 9999; position: relative; }

    .pulse-red { animation: pulse 1.5s infinite; }
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    @keyframes shake { 
        0%, 100% { transform: translateX(0); } 
        20%, 60% { transform: translateX(-5px); } 
        40%, 80% { transform: translateX(5px); } 
    }
    .animate-shake { animation: shake 0.5s ease-in-out 1; }
</style>

<?= $this->endSection() ?>