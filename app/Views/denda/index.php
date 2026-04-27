<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1">Manajemen <span class="text-purple-berry">Denda</span> 💸</h3>
            <p class="text-muted small">Pantau nunggakan buku dan kirim pengingat tagihan ke member.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="d-inline-block bg-danger-soft px-4 py-3 rounded-4 border border-danger border-opacity-10 shadow-sm">
                <small class="fw-bold text-muted d-block extra-small text-uppercase mb-1">Total Tunggakan Global</small>
                <h4 class="fw-bold text-danger mb-0">Rp <?= number_format(array_sum(array_column($denda, 'denda')), 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase extra-small fw-bold text-muted">Member</th>
                        <th class="py-3 text-uppercase extra-small fw-bold text-muted">Informasi Buku</th>
                        <th class="py-3 text-uppercase extra-small fw-bold text-muted">Jatuh Tempo</th>
                        <th class="py-3 text-uppercase extra-small fw-bold text-muted">Total Denda</th>
                        <th class="py-3 text-center text-uppercase extra-small fw-bold text-muted">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($denda)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-shield-check display-1 text-success opacity-25"></i>
                                    <h5 class="mt-3 text-muted fw-bold">Semua Aman, Min!</h5>
                                    <p class="text-muted small">Tidak ada denda yang menggantung hari ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($denda as $d): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-purple-berry text-grey me-3">
                                    <?= substr($d['nama'], 0, 1) ?>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?= $d['nama'] ?></div>
                                    <small class="text-muted small"><i class="bi bi-telephone me-1"></i> <?= $d['telepon'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-medium text-truncate" style="max-width: 250px;"><?= $d['judul'] ?></div>
                            <small class="extra-small text-muted text-uppercase">ID: #TRX-<?= $d['id_peminjaman'] ?></small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-x text-danger me-2"></i>
                                <span class="small fw-bold text-dark"><?= date('d M Y', strtotime($d['tanggal_kembali'])) ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-berry bg-danger-soft text-danger fw-bold fs-6">
                                Rp <?= number_format($d['denda'], 0, ',', '.') ?>
                            </span>
                        </td>
                        <td class="pe-4">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?= base_url('denda/kirimPeringatan/' . $d['id_peminjaman']) ?>" 
                                   target="_blank"
                                   class="btn btn-whatsapp btn-sm rounded-3 px-3 shadow-sm"
                                   title="Tagih via WhatsApp">
                                    <i class="bi bi-whatsapp"></i> Tagih
                                </a>

                                <form action="<?= base_url('denda/lunas/' . $d['id_peminjaman']) ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-purple-berry btn-sm rounded-3 px-3 shadow-sm" 
                                            onclick="return confirm('Konfirmasi denda ini sudah dibayar lunas?')">
                                        <i class="bi bi-check2-all me-1"></i> Set Lunas
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Global Overrides */
    .text-purple-berry { color: #673ab7; }
    .btn-purple-berry { background: #673ab7; color: white; border: none; transition: 0.3s; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; box-shadow: 0 4px 12px rgba(103, 58, 183, 0.2); }
    
    .bg-danger-soft { background-color: #fff5f5; color: #e03131; }
    
    /* Table Styling */
    .table thead th { 
        border-bottom: none; 
        background-color: #f8f9fa;
        letter-spacing: 0.5px;
    }
    .extra-small { font-size: 0.65rem; }
    
    /* Avatar Circle */
    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        text-transform: uppercase;
    }

    /* WhatsApp Button Custom */
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        font-weight: 600;
    }
    .btn-whatsapp:hover {
        background-color: #1eb956;
        color: white;
        transform: translateY(-1px);
    }

    /* Badge Style */
    .badge-berry {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
    }

    .card { border-radius: 1.25rem; }
</style>

<?= $this->endSection() ?>