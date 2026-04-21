<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex align-items-center mb-4">
                <a href="<?= base_url('buku') ?>" class="btn btn-white rounded-circle shadow-sm me-3 border">
                    <i class="bi bi-arrow-left text-primary"></i>
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Edit Data Buku ✏️</h3>
                    <p class="text-muted mb-0">Perbarui detail buku: <span class="text-primary fw-bold"><?= $buku['judul'] ?></span></p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="row g-4">
                            <div class="col-12">
                                <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Informasi Utama</h5>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Judul Lengkap Buku</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-pencil-square text-primary"></i></span>
                                    <input type="text" name="judul" class="form-control bg-light border-0 py-3 fw-bold shadow-none" value="<?= $buku['judul'] ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Penulis</label>
                                <select name="id_penulis" class="form-select custom-input py-2 shadow-none" required>
                                    <?php foreach($penulis as $p): ?>
                                        <option value="<?= $p['id_penulis'] ?>" <?= $buku['id_penulis'] == $p['id_penulis'] ? 'selected' : '' ?>>
                                            <?= $p['nama_penulis'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Penerbit</label>
                                <select name="id_penerbit" class="form-select custom-input py-2 shadow-none" required>
                                    <?php foreach($penerbit as $pen): ?>
                                        <option value="<?= $pen['id_penerbit'] ?>" <?= $buku['id_penerbit'] == $pen['id_penerbit'] ? 'selected' : '' ?>>
                                            <?= $pen['nama_penerbit'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12 mt-5">
                                <h5 class="fw-bold text-primary mb-3 border-bottom pb-2">Detail & Klasifikasi</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Tahun Terbit</label>
                                <input type="number" name="tahun_terbit" class="form-control custom-input py-2" value="<?= $buku['tahun_terbit'] ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Kategori</label>
                                <select name="id_kategori" class="form-select custom-input py-2 shadow-none" required>
                                    <?php foreach($kategori as $k): ?>
                                        <option value="<?= $k['id_kategori'] ?>" <?= $buku['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                            <?= $k['nama_kategori'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Lokasi Rak</label>
                                <select name="id_rak" class="form-select custom-input py-2 shadow-none" required>
                                    <?php foreach($rak as $r): ?>
                                        <option value="<?= $r['id_rak'] ?>" <?= ($buku['id_rak'] ?? '') == $r['id_rak'] ? 'selected' : '' ?>>
                                            <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Jumlah Total</label>
                                <div class="input-group" style="max-width: 200px;">
                                    <input type="number" name="jumlah" class="form-control custom-input py-2" value="<?= $buku['jumlah'] ?>" required>
                                    <span class="input-group-text bg-light border-0 small fw-bold">Eks</span>
                                </div>
                            </div>
                            
                            <div class="col-md-6 text-end d-flex align-items-end justify-content-end">
                                <p class="text-muted small mb-2 italic">Diedit terakhir pada: <?= date('d M Y') ?></p>
                            </div>

                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold text-uppercase mb-1">Sinopsis / Deskripsi</label>
                                <textarea name="deskripsi" class="form-control custom-input py-2" rows="4"><?= $buku['deskripsi'] ?></textarea>
                            </div>
                        </div>

                        <div class="mt-5 d-flex gap-3 justify-content-end align-items-center pt-4 border-top">
                            <a href="<?= base_url('buku') ?>" class="text-decoration-none text-muted fw-bold px-3">Batal</a>
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill px-5 shadow-sm fw-bold">
                                <i class="bi bi-cloud-upload-fill me-2"></i> Update Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fa; }
    .btn-white { background-color: #fff; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .custom-input {
        background-color: #f1f3f9 !important;
        border: 2px solid transparent !important;
        border-radius: 10px !important;
        transition: all 0.3s ease;
    }
    .custom-input:focus {
        background-color: #fff !important;
        border-color: #4f46e5 !important;
        box-shadow: 0 5px 15px rgba(79, 70, 229, 0.1) !important;
    }
    .btn-warning { background-color: #ffc107; border: none; color: #000; }
    .btn-warning:hover { background-color: #ffca2c; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3); }
</style>

<?= $this->endSection() ?>