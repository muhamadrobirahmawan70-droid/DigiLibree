<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Riwayat Membaca 📚</h2>
            <p class="text-muted">Jejak perjalanan literasimu di DigiLibree.</p>
        </div>
    </div>

    <div class="row g-3">
        <?php if (empty($riwayat)) : ?>
            <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-journal-bookmark-fill display-1 text-muted opacity-25"></i>
                <h4 class="mt-3 text-muted">Belum ada buku yang dipinjam...</h4>
                <a href="<?= base_url('buku') ?>" class="btn btn-primary rounded-pill px-4 mt-2">Cari Buku Pertama!</a>
            </div>
        <?php else : ?>
            <?php foreach ($riwayat as $r) : ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <div class="card-body p-0 d-flex">
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 100px;">
                                <img src="<?= base_url('uploads/buku/' . ($r['sampul'] ?? 'default.jpg')) ?>" 
                                     style="width: 100%; height: 100%; object-fit: cover;" 
                                     alt="Cover">
                            </div>
                            
                            <div class="p-3 flex-grow-1">
                                <span class="badge rounded-pill mb-2 <?= $r['status'] == 'dipinjam' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= ucfirst($r['status']) ?>
                                </span>
                                <h6 class="fw-bold text-dark mb-1 text-truncate" style="max-width: 180px;"><?= $r['judul'] ?></h6>
                                
                                <div class="small text-muted mb-2">
                                    <i class="bi bi-calendar-check me-1"></i> Pinjam: <?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?>
                                </div>

                                <?php if ($r['status'] == 'kembali') : ?>
                                    <div class="small text-success fw-bold">
                                        <i class="bi bi-check2-all me-1"></i> Dikembalikan: <?= date('d M Y', strtotime($r['tanggal_pengembalian_asli'])) ?>
                                    </div>
                                <?php else : ?>
                                    <div class="small text-danger fw-bold">
                                        <i class="bi bi-exclamation-circle me-1"></i> Batas: <?= date('d M Y', strtotime($r['tanggal_kembali'])) ?>
                                    </div>
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
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
</style>

<?= $this->endSection() ?>