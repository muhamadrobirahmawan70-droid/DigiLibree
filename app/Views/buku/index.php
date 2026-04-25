<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">

    <div class="row mb-5 align-items-center">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold text-dark mb-2">DigiLibree <span class="text-primary">Katalog</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Koleksi Buku</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-4 text-lg-end">
            <?php if (session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku/create') ?>" class="btn btn-dark rounded-4 px-4 py-3 shadow-lg border-0 transition-hover">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Koleksi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-5 p-4 mb-5 bg-white search-panel">
        <form method="get" class="row g-3">
            <div class="col-md-7">
                <div class="input-group input-group-lg border rounded-4 overflow-hidden bg-light custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-4 text-primary"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 bg-transparent shadow-none" 
                           placeholder="Cari judul, penulis, atau genre..." value="<?= $keyword ?? '' ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-lg border rounded-4 overflow-hidden bg-light custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3 text-warning"><i class="bi bi-filter-circle-fill"></i></span>
                    <select name="sort" class="form-select border-0 bg-transparent shadow-none small" onchange="this.form.submit()">
                        <option value="">Terbaru</option>
                        <option value="rating" <?= ($sort ?? '') == 'rating' ? 'selected' : '' ?>>⭐ Rating Tertinggi</option>
                        <option value="populer" <?= ($sort ?? '') == 'populer' ? 'selected' : '' ?>>🔥 Paling Populer</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-lg w-100 rounded-4 fw-bold shadow-sm" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <div class="mb-5">
        <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
            <button class="btn btn-primary rounded-pill px-4 fw-bold filter-btn active" data-filter="all">
                Semua Koleksi
            </button>
            <?php foreach ($kategori as $kat) : ?>
                <button class="btn btn-outline-dark rounded-pill px-4 fw-bold filter-btn" data-filter="kat-<?= $kat['id_kategori'] ?>">
                    <?= $kat['nama_kategori'] ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!$keyword && !empty($buku) && !isset($sort)): ?>
    <div class="mb-5">
        <div class="d-flex align-items-center mb-4">
            <span class="badge bg-primary p-2 me-3 rounded-3 shadow-sm"><i class="bi bi-lightning-fill"></i></span>
            <h3 class="fw-bold m-0 text-dark">Lagi Rame Dipinjam</h3>
        </div>
        <div class="row g-4">
            <?php 
            $top3 = array_slice($buku, 0, 3); 
            foreach ($top3 as $index => $t): 
                if ($t['total_dipinjam'] > 0): 
            ?>
            <div class="col-md-4">
                <div class="trending-item p-4 rounded-5 bg-white shadow-sm border-start border-primary border-5 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 small ls-2 fw-bold text-uppercase"><?= $t['nama_kategori'] ?? 'Umum' ?></span>
                        <div class="h3 fw-black text-light-gray m-0"><?= $index + 1 ?></div>
                    </div>
                    <h4 class="fw-bold my-3 text-dark text-limit-1"><?= $t['judul'] ?></h4>
                    <span class="small text-muted fw-semibold"><i class="bi bi-person me-1"></i><?= $t['nama_penulis'] ?? '-' ?></span>
                </div>
            </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row g-4" id="book-grid">
        <?php foreach ($buku as $b): ?>
            <?php 
                $db = \Config\Database::connect();
                $checkStatus = $db->table('peminjaman')
                    ->where(['id_buku' => $b['id_buku'], 'id_user' => session()->get('id')])
                    ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
                    ->orderBy('id_peminjaman', 'DESC')->get()->getRowArray();
            ?>
            
            <div class="col-md-6 col-xl-4 book-item kat-<?= $b['id_kategori'] ?>">
                <div class="book-card-premium">
                    <div class="card border-0 rounded-5 shadow-sm overflow-hidden h-100 bg-white position-relative">
                        
                        <?php if ($b['rata_rating'] >= 4.5): ?>
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                <span class="badge bg-warning text-dark rounded-pill shadow-sm py-2 px-3 small fw-bold">
                                    <i class="bi bi-patch-check-fill me-1"></i> Best Choice
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="row g-0 h-100">
                            <div class="col-5 bg-gradient-book p-3 d-flex flex-column justify-content-between text-white position-relative">
                                <div class="badge bg-white bg-opacity-25 rounded-pill py-2 px-2 small border border-white border-opacity-25 glass-badge text-truncate text-center">
                                    <?= $b['nama_rak'] ?? 'Tanpa Rak' ?>
                                </div>
                                
                                <div class="text-center my-2">
                                    <img src="<?= base_url('uploads/buku/cover/' . $b['cover']) ?>" 
                                         class="img-fluid rounded-3 shadow-lg icon-float" 
                                         style="height: 140px; width: 100%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                                </div>

                                <div class="text-center small opacity-75 fw-bold letter-spacing-1">ID: B-<?= str_pad($b['id_buku'], 3, '0', STR_PAD_LEFT) ?></div>
                            </div>
                            
                            <div class="col-7 p-4 d-flex flex-column">
                                <div class="mb-auto">
                                    <small class="text-primary fw-bold text-uppercase ls-1 extra-small d-block mb-1"><?= $b['nama_kategori'] ?? 'Umum' ?></small>
                                    <h5 class="fw-bold text-dark lh-base text-limit-2 mb-2"><?= $b['judul'] ?></h5>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="text-warning extra-small me-2">
                                            <i class="bi bi-star-fill"></i>
                                            <span class="text-dark fw-bold ms-1"><?= number_format($b['rata_rating'] ?? 0, 1) ?></span>
                                        </div>
                                        <div class="vr mx-2 text-muted opacity-25"></div>
                                        <small class="text-muted extra-small fw-bold"><?= $b['tersedia'] ?> Tersedia</small>
                                    </div>
                                    <p class="text-muted small mb-0">Oleh <span class="text-dark fw-semibold"><?= $b['nama_penulis'] ?? '-' ?></span></p>
                                </div>

                                <div class="action-zone mt-3">
                                    <div class="d-grid gap-2">
                                        <?php if (session()->get('role') == 'admin'): ?>
                                            <div class="d-flex gap-2">
                                                <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-outline-dark btn-sm rounded-3 px-3"><i class="bi bi-pencil-square"></i></a>
                                                <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-primary btn-sm rounded-3 flex-grow-1 fw-bold">Detail</a>
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-3 btn-delete-anim" data-url="<?= base_url('buku/delete/' . $b['id_buku']) ?>"><i class="bi bi-trash3-fill"></i></button>
                                            </div>
                                        <?php else: ?>
                                            <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-outline-primary btn-sm rounded-3 fw-bold">Detail</a>
                                            <?php if ($checkStatus): ?>
                                                <div class="status-box status-active">
                                                    <div class="dot-pulse me-2"></div> <?= ucfirst($checkStatus['status']) ?>
                                                </div>
                                            <?php elseif ($b['tersedia'] > 0): ?>
                                                <form action="<?= base_url('peminjaman/pinjamKilat/' . $b['id_buku']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-bold" onclick="return confirm('Pinjam sekarang?')">
                                                        <i class="bi bi-lightning-charge-fill me-1"></i> Pinjam Kilat
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <button class="btn btn-light btn-sm rounded-3 fw-bold disabled border">Stok Habis</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .extra-small { font-size: 0.65rem; }
    .text-limit-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .book-card-premium { transition: all 0.4s ease; height: 100%; }
    .book-card-premium:hover { transform: translateY(-10px); }
    .bg-gradient-book { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .glass-badge { backdrop-filter: blur(4px); }
    .status-box { padding: 6px; border-radius: 8px; font-weight: 700; font-size: 0.7rem; text-align: center; display: flex; align-items: center; justify-content: center; }
    .status-active { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .dot-pulse { width: 6px; height: 6px; border-radius: 50%; background-color: currentColor; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { transform: scale(0.95); opacity: 1; } 70% { transform: scale(1.5); opacity: 0; } 100% { transform: scale(0.95); opacity: 0; } }
    @keyframes throwToTrash { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(0) translateY(500px); opacity: 0; } }
    .item-delete-animation { animation: throwToTrash 0.7s forwards; }
    .filter-btn { transition: all 0.3s; }
    .filter-btn.active { box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3); }
</style>

<script>
    // JS Filter Kategori
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Toggle Class Active Tombol
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-dark');
            });
            this.classList.remove('btn-outline-dark');
            this.classList.add('btn-primary', 'active');

            const filter = this.getAttribute('data-filter');
            const items = document.querySelectorAll('.book-item');

            items.forEach(item => {
                if (filter === 'all' || item.classList.contains(filter)) {
                    item.style.display = 'block';
                    item.animate([
                        { opacity: 0, transform: 'scale(0.95)' },
                        { opacity: 1, transform: 'scale(1)' }
                    ], { duration: 400, fill: 'forwards' });
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // JS Animasi Hapus
    document.querySelectorAll('.btn-delete-anim').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            const card = this.closest('.book-item');
            if (confirm('Hapus buku ini dari perpustakaan?')) {
                card.classList.add('item-delete-animation');
                setTimeout(() => { window.location.href = url; }, 600);
            }
        });
    });
</script>

<?= $this->endSection() ?>