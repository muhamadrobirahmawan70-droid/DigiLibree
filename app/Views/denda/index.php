<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1">Manajemen <span class="text-purple-berry">Denda</span> 💸</h3>
            <p class="text-muted small">Pantau denda buku dan validasi pembayaran member.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="d-inline-block bg-danger-soft px-4 py-3 rounded-4 border border-danger border-opacity-10 shadow-sm">
                <small class="fw-bold text-muted d-block extra-small text-uppercase mb-1">Data Kas Denda</small>
                <h4 class="fw-bold text-danger mb-0">Rp <?= number_format(array_sum(array_column($denda, 'denda')), 0, ',', '.') ?></h4>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-graph-up-arrow me-2 text-purple-berry"></i>Tren Akumulasi Denda</h5>
                    <span class="badge bg-purple-soft text-purple-berry rounded-pill px-3">Live Data</span>
                </div>
                <div style="height: 250px;">
                    <canvas id="chartDenda"></canvas>
                </div>
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
                        <th class="py-3 text-uppercase extra-small fw-bold text-muted">Total Denda</th>
                        <th class="py-3 text-uppercase extra-small fw-bold text-muted">Status Pembayaran</th>
                        <th class="py-3 text-center text-uppercase extra-small fw-bold text-muted">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($denda)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-shield-check display-1 text-success opacity-25"></i>
                                <h5 class="mt-3 text-muted fw-bold">Semua Aman, Min!</h5>
                                <p class="text-muted small">Tidak ada denda aktif hari ini.</p>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($denda as $d): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-purple-berry text-white me-3">
                                    <?= substr($d['nama'], 0, 1) ?>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?= $d['nama'] ?></div>
                                    <small class="text-muted extra-small">ID Member: #USR-<?= $d['id_user'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark fw-medium text-truncate" style="max-width: 200px;"><?= $d['judul'] ?></div>
                            <small class="extra-small text-danger fw-bold">Batas: <?= date('d M Y', strtotime($d['tanggal_kembali'])) ?></small>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">
                                Rp <?= number_format($d['denda'], 0, ',', '.') ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($d['status_denda'] == 'proses') : ?>
                                <span class="badge bg-info-soft text-info rounded-pill px-3 py-2 small">
                                    <i class="bi bi-clock-history me-1"></i> Menunggu Validasi
                                </span>
                            <?php elseif ($d['status_denda'] == 'lunas') : ?>
                                <span class="badge bg-success-soft text-success rounded-pill px-3 py-2 small">
                                    <i class="bi bi-check-circle me-1"></i> Lunas
                                </span>
                            <?php else : ?>
                                <span class="badge bg-danger-soft text-danger rounded-pill px-3 py-2 small">
                                    <i class="bi bi-exclamation-circle me-1"></i> Belum Bayar
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="https://wa.me/<?= $d['telepon'] ?>?text=Halo%20<?= $d['nama'] ?>,%20ini%20pengingat%20untuk%20denda%20buku%20'<?= $d['judul'] ?>'%20sebesar%20Rp<?= number_format($d['denda'], 0, ',', '.') ?>.%20Segera%20dilunasi%20ya!" 
                                   target="_blank" class="btn btn-whatsapp btn-sm rounded-circle p-2" title="Sentil via WA">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                
                                <a href="<?= base_url('peminjaman') ?>?keyword=<?= $d['nama'] ?>" class="btn btn-outline-purple btn-sm rounded-pill px-3" style="font-size: 0.75rem;">
                                    Cek Transaksi
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ... Script Chart tetap sama seperti sebelumnya ...
    const ctx = document.getElementById('chartDenda').getContext('2d');
    const labels = <?= json_encode(array_column(array_slice($denda, 0, 7), 'nama')) ?>;
    const dataDenda = <?= json_encode(array_column(array_slice($denda, 0, 7), 'denda')) ?>;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Besar Denda (Rp)',
                data: dataDenda,
                backgroundColor: 'rgba(103, 58, 183, 0.2)',
                borderColor: '#673ab7',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>

<style>
    .text-purple-berry { color: #673ab7; }
    .bg-purple-soft { background: #f3e5f5; }
    .bg-danger-soft { background-color: #fff5f5; color: #e03131; }
    .bg-success-soft { background-color: #e6fcf5; color: #0ca678; }
    .bg-info-soft { background-color: #e7f5ff; color: #1c7ed6; }
    
    .btn-outline-purple { color: #673ab7; border-color: #673ab7; }
    .btn-outline-purple:hover { background: #673ab7; color: white; }

    .extra-small { font-size: 0.65rem; }
    .avatar-circle {
        width: 35px; height: 35px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 13px;
    }

    .btn-whatsapp {
        background-color: #25D366; color: white; border: none;
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    }
    .btn-whatsapp:hover { background-color: #1eb956; color: white; transform: scale(1.1); }

    .card { border-radius: 1.25rem; }
    .table-hover tbody tr:hover { background-color: #fcfaff; }
</style>

<?= $this->endSection() ?>