<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Manajemen Denda 💸</h3>
            <p class="text-muted mb-0">Pantau nunggakan dan kirim pengingat ke member.</p>
        </div>
        <div class="bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-3 border border-danger border-opacity-25">
            <small class="fw-bold">Total Nunggak: </small>
            <span class="fw-bold">Rp <?= number_format(array_sum(array_column($denda, 'denda')), 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold text-muted">Member</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Buku</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Tgl Kembali</th>
                        <th class="py-3 text-uppercase small fw-bold text-muted">Denda</th>
                        <th class="py-3 text-center text-uppercase small fw-bold text-muted">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($denda)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted italic">
                                <i class="bi bi-check2-circle fs-1 d-block mb-2 text-success"></i>
                                Semua aman, min! Tidak ada denda yang menggantung.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($denda as $d): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark"><?= $d['nama'] ?></div>
                            <small class="text-muted"><?= $d['telepon'] ?></small>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;"><?= $d['judul'] ?></div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border fw-normal">
                                <?= date('d M Y', strtotime($d['tgl_kembali'])) ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-danger fw-bold">Rp <?= number_format($d['denda'], 0, ',', '.') ?></span>
                        </td>
                        <td class="text-center pe-4">
                            <a href="<?= base_url('denda/kirimPeringatan/' . $d['id_peminjaman']) ?>" 
                               target="_blank"
                               class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-bold">
                                <i class="bi bi-whatsapp me-1"></i> Tagih Sekarang
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 1rem; }
    .table thead th { border-bottom: none; }
    .btn-success { background-color: #25D366; border: none; }
    .btn-success:hover { background-color: #128C7E; transform: translateY(-1px); }
</style>

<?= $this->endSection() ?>