<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <div class="row mb-4 align-items-center">
        <div class="col-lg-8">
            <h3 class="fw-bold text-dark mb-1">Katalog Koleksi <span style="color: #673ab7;">DigiLibree</span></h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item small active text-purple-berry fw-bold" aria-current="page">Katalog</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <?php if (session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku/create') ?>" class="btn btn-purple-berry shadow-sm px-4 py-2" style="background: #673ab7; color: white; border-radius: 10px; font-weight: 600;">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Koleksi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form method="get" class="row g-3">
                <div class="col-md-6">
                    <div class="input-group border rounded-3 overflow-hidden bg-light shadow-none">
                        <span class="input-group-text border-0 bg-transparent ps-3 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="keyword" class="form-control border-0 bg-transparent shadow-none" 
                               placeholder="Cari judul atau penulis..." value="<?= $keyword ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="sort" class="form-select border rounded-3 shadow-none fw-semibold text-muted bg-light" onchange="this.form.submit()">
                        <option value="">Urutkan: Terbaru</option>
                        <option value="rating" <?= ($sort ?? '') == 'rating' ? 'selected' : '' ?>>⭐ Rating Tertinggi</option>
                        <option value="populer" <?= ($sort ?? '') == 'populer' ? 'selected' : '' ?>>🔥 Paling Populer</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark w-100 rounded-3 fw-bold py-2" type="submit">Filter</button>
                </div>
            </form>

            <div class="d-flex align-items-center flex-wrap gap-2 mt-4 pt-3 border-top border-light">
                <button class="btn-berry-chip active" data-filter="all">Semua Koleksi</button>
                <?php foreach ($kategori as $kat) : ?>
                    <button class="btn-berry-chip" data-filter="kat-<?= $kat['id_kategori'] ?>">
                        <?= $kat['nama_kategori'] ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

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
                <div class="card h-100 border-0 shadow-sm overflow-hidden card-berry-hover" style="border-radius: 16px;">
                    <div class="row g-0 h-100">
                        <div class="col-5 berry-gradient-cover p-3 d-flex flex-column align-items-center justify-content-center text-white">
                            <div class="glass-shelf-badge mb-3">
                                <?= $b['nama_rak'] ?? 'Umum' ?>
                            </div>
                            <img src="<?= base_url('uploads/buku/cover/' . $b['cover']) ?>" 
                                 class="img-fluid rounded shadow-lg float-img" 
                                 style="height: 140px; width: 95px; object-fit: cover;">
                            <div class="mt-3 small opacity-75 fw-bold text-uppercase">B-<?= str_pad($b['id_buku'], 3, '0', STR_PAD_LEFT) ?></div>
                        </div>
                        
                        <div class="col-7 p-3 d-flex flex-column">
                            <div class="mb-auto">
                                <span class="text-purple-berry fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                    <?= $b['nama_kategori'] ?? 'Koleksi' ?>
                                </span>
                                <h6 class="fw-bold text-dark mt-1 text-limit-2" title="<?= $b['judul'] ?>"><?= $b['judul'] ?></h6>
                                
                                <div class="d-flex align-items-center mb-2">
                                    <span class="text-warning small"><i class="bi bi-star-fill me-1"></i><?= number_format($b['rata_rating'] ?? 0, 1) ?></span>
                                    <span class="mx-2 text-muted opacity-25">|</span>
                                    <span class="text-muted extra-small fw-bold"><?= $b['tersedia'] ?> Tersedia</span>
                                </div>
                                <p class="text-muted extra-small mb-0">Oleh: <span class="text-dark"><?= $b['nama_penulis'] ?? '-' ?></span></p>
                            </div>

                            <div class="mt-3 pt-2 border-top border-light">
                                <div class="d-flex gap-2">
                                    <?php if (session()->get('role') == 'admin'): ?>
                                        <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-sm btn-light border" style="border-radius: 8px;"><i class="bi bi-pencil-square text-primary"></i></a>
                                        <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-sm btn-purple-berry-soft flex-grow-1 fw-bold">Detail</a>
                                        <button type="button" class="btn btn-sm btn-light border btn-delete-anim" data-url="<?= base_url('buku/delete/' . $b['id_buku']) ?>"><i class="bi bi-trash3 text-danger"></i></button>
                                    <?php else: ?>
                                        <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-sm btn-light border flex-grow-1 fw-bold">Detail</a>
                                        <?php if ($checkStatus): ?>
                                            <span class="badge-status-berry flex-grow-1"><?= ucfirst($checkStatus['status']) ?></span>
                                        <?php elseif ($b['tersedia'] > 0): ?>
                                            <form action="<?= base_url('peminjaman/pinjamKilat/' . $b['id_buku']) ?>" method="post" class="flex-grow-1">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-sm btn-purple-berry w-100 fw-bold" onclick="return confirm('Pinjam sekarang?')">
                                                    Pinjam
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-light border disabled extra-small fw-bold">Habis</button>
                                        <?php endif; ?>
                                    <?php endif; ?>
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
    /* Berry UI Styles */
    .text-purple-berry { color: #673ab7; }
    .btn-purple-berry { background: #673ab7; color: white; border: none; border-radius: 8px; transition: 0.3s; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; box-shadow: 0 4px 12px rgba(103, 58, 183, 0.3); }
    .btn-purple-berry-soft { background: #ede7f6; color: #673ab7; border: none; border-radius: 8px; }

    .berry-gradient-cover { background: linear-gradient(135deg, #673ab7 0%, #2196f3 100%); }
    
    .btn-berry-chip {
        padding: 8px 18px;
        border-radius: 10px;
        border: 1px solid #e3e8ef;
        background: #fff;
        color: #364152;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.2s;
    }
    .btn-berry-chip.active { background: #673ab7; color: #fff; border-color: #673ab7; }
    .btn-berry-chip:hover:not(.active) { background: #f8faff; border-color: #673ab7; color: #673ab7; }

    .card-berry-hover { transition: all 0.3s ease; }
    .card-berry-hover:hover { transform: translateY(-5px); box-shadow: 0 12px 20px rgba(0,0,0,0.08) !important; }

    .glass-shelf-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-status-berry {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        text-align: center;
    }

    .text-limit-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em; }
    .extra-small { font-size: 0.7rem; }
    .float-img { transition: 0.3s; }
    .card-berry-hover:hover .float-img { transform: scale(1.05) rotate(2deg); }
    
    @keyframes throwToTrash { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(0) translateY(500px); opacity: 0; } }
    .item-delete-animation { animation: throwToTrash 0.7s forwards; }
</style>

<script>
    // JS Filter Kategori Tetap Dipertahankan & Dioptimalkan
    document.querySelectorAll('.btn-berry-chip').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.btn-berry-chip').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            const items = document.querySelectorAll('.book-item');

            items.forEach(item => {
                if (filter === 'all' || item.classList.contains(filter)) {
                    item.style.display = 'block';
                    item.animate([{ opacity: 0 }, { opacity: 1 }], { duration: 300 });
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    document.querySelectorAll('.btn-delete-anim').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-url');
            const card = this.closest('.book-item');
            if (confirm('Hapus buku ini?')) {
                card.classList.add('item-delete-animation');
                setTimeout(() => { window.location.href = url; }, 600);
            }
        });
    });
</script>

<?= $this->endSection() ?>