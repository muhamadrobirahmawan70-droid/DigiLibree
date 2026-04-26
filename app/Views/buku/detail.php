<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('buku') ?>" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Detail Koleksi</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-lg-4 d-flex align-items-center justify-content-center p-5" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);">
                <div class="text-center text-white">
                    <div class="bg-white rounded-4 shadow-lg overflow-hidden mb-4 cover-container" style="width: 220px; height: 310px; border: 8px solid rgba(255,255,255,0.2);">
                        <?php 
                            // Pastikan path ini sesuai dengan lokasi penyimpanan di folder public
                            $coverName = $buku['cover'];
                            $pathCover = 'uploads/buku/cover/' . $coverName;
                        ?>
                        <?php if (!empty($coverName) && file_exists(FCPATH . $pathCover)) : ?>
                            <img src="<?= base_url($pathCover) ?>" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="<?= $buku['judul'] ?>">
                        <?php else : ?>
                            <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light text-muted">
                                <i class="bi bi-image text-secondary opacity-25" style="font-size: 4rem;"></i>
                                <small class="fw-bold mt-2">TIDAK ADA SAMPUL</small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h5 class="fw-bold mb-1">DigiLibree</h5>
                    <p class="small opacity-75">Koleksi Terverifikasi</p>
                    
                    <?php if (isset($buku['total_dipinjam']) && $buku['total_dipinjam'] >= 5) : ?>
                        <span class="badge bg-warning text-dark px-3 rounded-pill shadow-sm">
                            <i class="bi bi-fire me-1"></i> Terpopuler
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-8 bg-white">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge rounded-pill px-3 py-2 mb-3" style="background-color: #eef2ff; color: #4f46e5;">
                                <i class="bi bi-tag-fill me-1"></i> <?= $buku['nama_kategori'] ?? 'Umum' ?>
                            </span>
                            <h1 class="fw-bold text-dark display-6 mb-2"><?= $buku['judul'] ?></h1>
                            
                            <div class="d-flex align-items-center mb-3 text-muted">
                                <i class="bi bi-hash text-primary me-1"></i>
                                <small class="fw-bold">ID BUKU: <?= $buku['id_buku'] ?></small>
                            </div>
                        </div>

                        <div class="text-end border-start ps-4">
                            <h6 class="text-uppercase text-muted small fw-bold mb-1">Status Stok</h6>
                            <h4 class="fw-bold <?= ($buku['tersedia'] ?? 0) > 0 ? 'text-success' : 'text-danger' ?> mb-0">
                                <?= ($buku['tersedia'] ?? 0) > 0 ? 'Tersedia' : 'Kosong' ?>
                            </h4>
                            <span class="badge bg-light text-dark border mt-1"><?= $buku['tersedia'] ?? 0 ?> Unit</span>
                        </div>
                    </div>

                    <div class="row g-4 py-4 border-top border-bottom mb-4 bg-light-subtle rounded-3">
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Penulis</label>
                            <span class="text-dark fw-semibold small"><i class="bi bi-pencil-square me-2 text-primary"></i><?= $buku['nama_penulis'] ?? 'N/A' ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Penerbit</label>
                            <span class="text-dark fw-semibold small"><i class="bi bi-building me-2 text-primary"></i><?= $buku['nama_penerbit'] ?? 'N/A' ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Tahun</label>
                            <span class="text-dark fw-semibold small"><i class="bi bi-calendar3 me-2 text-primary"></i><?= $buku['tahun_terbit'] ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted extra-small fw-bold text-uppercase d-block mb-1">Lokasi Rak</label>
                            <span class="text-dark fw-semibold small"><i class="bi bi-geo-alt me-2 text-primary"></i><?= $buku['nama_rak'] ?? 'Umum' ?></span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-dark mb-3">Sinopsis Buku</h5>
                        <div class="text-muted lh-lg shadow-sm p-4 rounded-4 bg-light border-start border-primary border-4" style="text-align: justify; font-size: 0.95rem;">
                            <?= !empty($buku['deskripsi']) ? nl2br($buku['deskripsi']) : '<em>Sinopsis untuk buku ini belum tersedia di pangkalan data kami.</em>' ?>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3 align-items-center pt-3">
                        <?php if (session()->get('role') != 'admin') : ?>
                            
                        <?php else: ?>
                            <a href="<?= base_url('buku/edit/'.$buku['id_buku']) ?>" class="btn btn-warning btn-lg rounded-pill px-5 py-3 shadow fw-bold text-dark">
                                <i class="bi bi-pencil-fill me-2"></i> Edit Data
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('buku') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 py-3 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fa; }
    .display-6 { font-size: 2.2rem; letter-spacing: -1px; line-height: 1.2; }
    .extra-small { font-size: 0.65rem; letter-spacing: 0.5px; }
    .btn-primary { background: #4f46e5; border: none; transition: all 0.3s ease; }
    .btn-primary:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }
    .rounded-4 { border-radius: 1.25rem !important; }
    
    .cover-container {
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .cover-container:hover {
        transform: scale(1.05) rotate(2deg);
    }
</style>

<?= $this->endSection() ?>