<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<style>
    /* Berry Style Stats Cards */
    .card-berry-stat {
        border: none !important;
        border-radius: 16px !important;
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .card-berry-stat:hover {
        transform: translateY(-5px);
    }
    .icon-box-berry {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    /* Warna Khas Berry */
    .bg-light-purple { background-color: #ede7f6; color: #673ab7; }
    .bg-light-blue { background-color: #e3f2fd; color: #2196f3; }
    .bg-light-success { background-color: #b9f6ca; color: #00c853; }
    .bg-light-warning { background-color: #fff8e1; color: #ffc107; }
    .bg-light-danger { background-color: #fbe9e7; color: #d84315; }

    .berry-welcome-banner {
        background: #ede7f6; /* Ungu muda Berry */
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        border: none;
    }
    .berry-welcome-banner::after {
        content: '';
        position: absolute;
        width: 210px;
        height: 210px;
        background: #5e35b1;
        border-radius: 50%;
        top: -125px;
        right: -15px;
        opacity: 0.1;
    }
</style>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card berry-welcome-banner p-4 p-md-5 shadow-none">
                <div class="row align-items-center">
                    <div class="col-md-8 position-relative" style="z-index: 2;">
                        <h1 class="fw-bold mb-2" style="color: #121926;">Semangat Membaca, <?= session()->get('username'); ?>! ✨</h1>
                        <p class="text-muted fs-6 mb-4">Dashboard Anda siap. Mari jelajahi ilmu pengetahuan di DigiLibree hari ini.</p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-white text-dark shadow-sm p-2 px-3 rounded-pill">
                                <i class="bi bi-calendar3 me-2 text-primary"></i><?= date('d M Y'); ?>
                            </span>
                            <span class="badge bg-purple-berry text-white p-2 px-3 rounded-pill" style="background-color: #673ab7;">
                                <i class="bi bi-person-badge me-2"></i><?= ucfirst(session()->get('role')); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box-berry bg-light-purple"><i class="bi bi-book"></i></div>
                    </div>
                    <h3 class="fw-bold mb-0"><?= number_format($total_buku); ?></h3>
                    <small class="text-muted fw-semibold">Total Koleksi</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box-berry bg-light-blue"><i class="bi bi-arrow-repeat"></i></div>
                    </div>
                    <h3 class="fw-bold mb-0"><?= number_format($total_pinjam); ?></h3>
                    <small class="text-muted fw-semibold">Peminjaman Aktif</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box-berry bg-light-success"><i class="bi bi-people"></i></div>
                    </div>
                    <h3 class="fw-bold mb-0"><?= number_format($total_member); ?></h3>
                    <small class="text-muted fw-semibold">Total Member</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="icon-box-berry bg-light-danger"><i class="bi bi-wallet2"></i></div>
                    </div>
                    <h3 class="fw-bold mb-0">Rp<?= number_format($total_denda_lunas, 0, ',', '.'); ?></h3>
                    <small class="text-muted fw-semibold">Kas Denda</small>
                </div>
            </div>
        <?php else : ?>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="icon-box-berry bg-light-blue mb-3"><i class="bi bi-search"></i></div>
                    <h3 class="fw-bold mb-0"><?= number_format($total_buku); ?></h3>
                    <small class="text-muted fw-semibold">Buku Tersedia</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="icon-box-berry bg-light-purple mb-3"><i class="bi bi-journal-check"></i></div>
                    <h3 class="fw-bold mb-0"><?= number_format($my_pinjam); ?></h3>
                    <small class="text-muted fw-semibold">Buku Dipinjam</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="icon-box-berry bg-light-warning mb-3"><i class="bi bi-clock-history"></i></div>
                    <h3 class="fw-bold mb-0"><?= number_format($my_history); ?></h3>
                    <small class="text-muted fw-semibold">Riwayat Bacaan</small>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card card-berry-stat shadow-sm p-3">
                    <div class="icon-box-berry bg-light-danger mb-3"><i class="bi bi-cash-stack"></i></div>
                    <h3 class="fw-bold mb-0">Rp<?= number_format($my_denda, 0, ',', '.'); ?></h3>
                    <small class="text-muted fw-semibold">Total Denda</small>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent py-3 border-0 px-4">
                    <h5 class="m-0 fw-bold text-dark">Buku Terpopuler</h5>
                    <small class="text-muted">Statistik peminjaman bulan ini</small>
                </div>
                <div class="card-body px-4 pb-4">
                    <div style="height: 300px;"><canvas id="chartPopuler"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent py-3 border-0 px-4">
                    <h5 class="m-0 fw-bold text-dark">Navigasi Cepat</h5>
                </div>
                <div class="card-body px-4">
                    <div class="list-group list-group-flush">
                        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                            <a href="<?= base_url('/buku') ?>" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center mb-2">
                                <div class="icon-box-berry bg-light-blue me-3"><i class="bi bi-collection"></i></div>
                                <div><h6 class="mb-0 fw-bold">Data Buku</h6><small class="text-muted">Kelola koleksi</small></div>
                            </a>
                            <a href="<?= base_url('users') ?>" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center mb-2">
                                <div class="icon-box-berry bg-light-purple me-3"><i class="bi bi-people"></i></div>
                                <div><h6 class="mb-0 fw-bold">Data User</h6><small class="text-muted">Manajemen pengguna</small></div>
                            </a>
                        <?php else : ?>
                            <a href="<?= base_url('/buku') ?>" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center mb-2">
                                <div class="icon-box-berry bg-light-blue me-3"><i class="bi bi-search"></i></div>
                                <div><h6 class="mb-0 fw-bold">Cari Buku</h6><small class="text-muted">Pinjam buku baru</small></div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 text-white" style="background: #2196f3;">
                <div class="card-body p-4">
                    <i class="bi bi-chat-quote fs-1 mb-2 opacity-50"></i>
                    <p class="fst-italic mb-0">"Buku adalah jendela dunia, dan DigiLibree adalah kuncinya."</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataGrafik = <?= json_encode($grafik ?? []); ?>;
    if (dataGrafik.length > 0) {
        const ctx = document.getElementById('chartPopuler').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dataGrafik.map(item => item.judul),
                datasets: [{
                    label: 'Total Pinjam',
                    data: dataGrafik.map(item => item.total),
                    backgroundColor: '#673ab7', // Berry Purple
                    borderRadius: 8,
                    barThickness: 25
                }]
            },
            options: { 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { drawBorder: false, color: '#f0f0f0' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
</script>
<?= $this->endSection() ?>