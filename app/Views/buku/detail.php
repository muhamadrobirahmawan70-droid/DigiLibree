<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 small">
            <li class="breadcrumb-item"><a href="<?= base_url('buku') ?>" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active text-purple-berry fw-bold" aria-current="page">Detail Koleksi</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
        <div class="row g-0">
            <div class="col-lg-4 d-flex align-items-center justify-content-center p-4 p-md-5 berry-gradient">
                <div class="text-center text-white">
                    <div class="bg-white rounded-4 shadow-lg overflow-hidden mb-4 cover-wrapper mx-auto">
                        <?php 
                            $coverName = $buku['cover'];
                            $pathCover = 'uploads/buku/cover/' . $coverName;
                        ?>
                        <?php if (!empty($coverName) && file_exists(FCPATH . $pathCover)) : ?>
                            <img src="<?= base_url($pathCover) ?>" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="<?= $buku['judul'] ?>">
                        <?php else : ?>
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light text-muted p-4">
                                <i class="bi bi-book-half text-purple-berry opacity-25" style="font-size: 4rem;"></i>
                                <span class="fw-bold mt-2 small">NO COVER</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h4 class="fw-bold mb-1">DigiLibree</h4>
                    <p class="small opacity-75 mb-3 text-uppercase ls-1">Koleksi Terverifikasi</p>
                    
                    <?php if (isset($buku['total_dipinjam']) && $buku['total_dipinjam'] >= 5) : ?>
                        <div class="badge bg-white text-purple-berry px-4 py-2 rounded-pill shadow-sm animate-bounce">
                            <i class="bi bi-star-fill me-1"></i> Terpopuler
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-4">
                        <div class="mb-3 mb-md-0">
                            <span class="badge-berry bg-purple-soft text-purple-berry mb-3">
                                <i class="bi bi-tag-fill me-1"></i> <?= $buku['nama_kategori'] ?? 'Umum' ?>
                            </span>
                            <h2 class="fw-bold text-dark display-6 mb-2"><?= $buku['judul'] ?></h2>
                            <div class="text-muted small fw-bold">
                                <span class="text-purple-berry">ID BUKU:</span> <?= $buku['id_buku'] ?>
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded-4 text-center border-0 shadow-sm" style="min-width: 140px;">
                            <h6 class="text-uppercase text-muted extra-small fw-bold mb-1">Status Stok</h6>
                            <h5 class="fw-bold <?= ($buku['tersedia'] ?? 0) > 0 ? 'text-success' : 'text-danger' ?> mb-1">
                                <?= ($buku['tersedia'] ?? 0) > 0 ? 'Tersedia' : 'Kosong' ?>
                            </h5>
                            <span class="badge bg-purple-berry text-white rounded-pill px-3"><?= $buku['tersedia'] ?? 0 ?> Unit</span>
                        </div>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded-4 bg-light-subtle h-100">
                                <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Penulis</label>
                                <span class="text-dark fw-bold small"><?= $buku['nama_penulis'] ?? '-' ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded-4 bg-light-subtle h-100">
                                <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Penerbit</label>
                                <span class="text-dark fw-bold small"><?= $buku['nama_penerbit'] ?? '-' ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded-4 bg-light-subtle h-100">
                                <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Tahun</label>
                                <span class="text-dark fw-bold small"><?= $buku['tahun_terbit'] ?></span>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3 border rounded-4 bg-light-subtle h-100">
                                <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Lokasi Rak</label>
                                <span class="text-dark fw-bold small"><?= $buku['nama_rak'] ?? 'Umum' ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Sinopsis Koleksi</h5>
                            <hr class="flex-grow-1 ms-3 opacity-10">
                        </div>
                        <div class="text-muted lh-lg p-4 rounded-4 bg-purple-soft-light border-start border-purple-berry border-4" style="text-align: justify; font-size: 0.95rem;">
                            <?= !empty($buku['deskripsi']) ? nl2br($buku['deskripsi']) : '<em>Sinopsis untuk buku ini belum tersedia di pangkalan data kami.</em>' ?>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <?php if (session()->get('role') == 'admin') : ?>
                            <a href="<?= base_url('buku/edit/'.$buku['id_buku']) ?>" class="btn btn-purple-berry rounded-pill px-5 py-3 shadow-sm fw-bold">
                                <i class="bi bi-pencil-square me-2"></i> Edit Data
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary rounded-pill px-4 py-3 fw-bold border-2">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Global Styling */
    .text-purple-berry { color: #673ab7 !important; }
    .bg-purple-berry { background: #673ab7 !important; }
    .bg-purple-soft { background: #f3e5f5; }
    .bg-purple-soft-light { background: #fbf9ff; }
    .ls-1 { letter-spacing: 1px; }
    .extra-small { font-size: 0.65rem; }
    .badge-berry { padding: 6px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; display: inline-block; }

    /* Gradient Background */
    .berry-gradient {
        background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%);
    }

    /* Cover Styling */
    .cover-wrapper {
        width: 220px; 
        height: 320px; 
        border: 10px solid rgba(255,255,255,0.15);
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .cover-wrapper:hover {
        transform: scale(1.05) rotate(1deg);
        border-color: rgba(255,255,255,0.3);
    }

    /* Buttons */
    .btn-purple-berry { background: #673ab7; color: white; border: none; transition: 0.3s; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(103, 58, 183, 0.2); }
    
    .rounded-5 { border-radius: 2rem !important; }

    /* Animation */
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .animate-bounce { animation: bounce 2s infinite; }

    .display-6 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1.5px; color: #1e293b; }
</style>

<?= $this->endSection() ?>