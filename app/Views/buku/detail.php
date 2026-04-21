<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="<?= base_url('buku') ?>" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Detail Buku</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-lg-4 d-flex align-items-center justify-content-center p-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="text-center text-white">
                    <div class="bg-white rounded-4 shadow-lg d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 180px; height: 260px;">
                        <i class="bi bi-book-half text-primary" style="font-size: 5rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-1">DigiLibree</h5>
                    <p class="small opacity-75">Premium Collection</p>
                    <span class="badge bg-warning text-dark px-3 rounded-pill shadow-sm">
                        <i class="bi bi-star-fill me-1"></i> Terpopuler
                    </span>
                </div>
            </div>

            <div class="col-lg-8 bg-white">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="badge rounded-pill px-3 py-2 mb-3" style="background-color: #eef2ff; color: #4f46e5;">
                                <i class="bi bi-tag-fill me-1"></i> <?= $buku['nama_kategori'] ?? 'Umum' ?>
                            </span>
                            <h1 class="fw-bold text-dark display-5 mb-2"><?= $buku['judul'] ?></h1>
                            <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i> Informasi lengkap detail koleksi perpustakaan.</p>
                        </div>
                        <div class="text-end border-start ps-4">
                            <h6 class="text-uppercase text-muted small fw-bold mb-1">Status Stok</h6>
                            <h4 class="fw-bold <?= $buku['stok'] > 0 ? 'text-success' : 'text-danger' ?> mb-0">
                                <?= $buku['stok'] > 0 ? 'Tersedia' : 'Kosong' ?>
                            </h4>
                            <span class="badge bg-light text-dark border mt-1"><?= $buku['stok'] ?> Eksemplar</span>
                        </div>
                    </div>

                    <div class="row g-4 py-4 border-top border-bottom mb-4">
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Penulis</label>
                            <span class="text-dark fw-semibold"><i class="bi bi-pencil-square me-2 text-primary"></i><?= $buku['nama_penulis'] ?? 'Tidak Diketahui' ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Penerbit</label>
                            <span class="text-dark fw-semibold"><i class="bi bi-building me-2 text-primary"></i><?= $buku['nama_penerbit'] ?? 'Pustaka Utama' ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Tahun Terbit</label>
                            <span class="text-dark fw-semibold"><i class="bi bi-calendar3 me-2 text-primary"></i><?= $buku['tahun_terbit'] ?></span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label class="text-muted small fw-bold text-uppercase d-block mb-1">Lokasi Rak</label>
                            <span class="text-dark fw-semibold"><i class="bi bi-geo-alt me-2 text-primary"></i><?= $buku['lokasi'] ?? 'Lantai 1' ?></span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-dark mb-3">Sinopsis Buku</h5>
                        <p class="text-muted lh-lg shadow-sm p-4 rounded-4 bg-light border-start border-primary border-4" style="text-align: justify;">
                            <?= $buku['deskripsi'] ?: 'Deskripsi belum tersedia untuk judul ini. Silakan hubungi petugas untuk ringkasan lebih lanjut.' ?>
                        </p>
                    </div>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <?php if (session()->get('role') != 'admin') : ?>
                            <a href="<?= base_url('peminjaman/create/'.$buku['id_buku']) ?>" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow fw-bold <?= $buku['stok'] <= 0 ? 'disabled' : '' ?>">
                                <i class="bi bi-bookmark-plus-fill me-2"></i> Pinjam Sekarang
                            </a>
                        <?php endif; ?>

                        <a href="<?= base_url('buku') ?>" class="btn btn-outline-dark btn-lg rounded-pill px-4 py-3 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>

                        <button class="btn btn-light btn-lg rounded-circle shadow-sm border p-3 ms-auto" title="Share">
                            <i class="bi bi-share text-dark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fa; }
    .display-5 { font-size: 2.5rem; letter-spacing: -1px; }
    .btn-primary { background: #4f46e5; border: none; transition: all 0.3s ease; }
    .btn-primary:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3); }
    .card { transition: transform 0.3s ease; }
    .rounded-4 { border-radius: 1.25rem !important; }
</style>

<?= $this->endSection() ?>