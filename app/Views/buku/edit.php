<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5" style="background-color: #f4f7fe; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
            
            <div class="d-flex align-items-center mb-4 animate-fade-in">
                <a href="<?= base_url('buku') ?>" class="btn btn-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center back-btn" style="width: 48px; height: 48px; border: 1px solid #e2e8f0;">
                    <i class="bi bi-arrow-left text-primary fs-5"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -1.5px;">Edit Data Koleksi ✏️</h2>
                    <p class="text-muted small mb-0">Perbarui informasi untuk buku: <span class="text-primary fw-bold"><?= $buku['judul'] ?></span></p>
                </div>
            </div>

            <form action="<?= base_url('buku/update/' . $buku['id_buku']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                            <div class="card-body p-4 text-center">
                                <label class="form-label fw-bold text-dark small text-uppercase ls-1 mb-3 d-block">Cover Buku</label>
                                
                                <div class="position-relative d-inline-block mb-3 group">
                                    <div class="overflow-hidden rounded-4 shadow" style="width: 210px; height: 300px;">
                                        <?php $pathCover = 'uploads/buku/cover/' . $buku['cover']; ?>
                                        <img src="<?= (!empty($buku['cover']) && file_exists($pathCover)) ? base_url($pathCover) : base_url('assets/img/no-cover.jpg') ?>" 
                                             id="img-preview" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <label for="cover" class="btn btn-primary rounded-circle position-absolute shadow-lg d-flex align-items-center justify-content-center" 
                                           style="width: 45px; height: 45px; bottom: -15px; right: -15px; border: 4px solid #fff; cursor: pointer;">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                    <input type="file" name="cover" id="cover" class="d-none" accept="image/*" onchange="previewCover()">
                                </div>
                                <p class="text-muted extra-small mt-3">Format: JPG, PNG, WEBP. Maks 2MB.<br>Kosongkan jika tidak ingin ganti cover.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <h5 class="fw-bold text-dark mb-1"><i class="bi bi-info-circle-fill text-primary me-2"></i>Informasi Utama</h5>
                                        <hr class="text-muted opacity-25">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Judul Lengkap</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-book icon-left text-primary"></i>
                                            <input type="text" name="judul" class="form-control-custom" value="<?= $buku['judul'] ?>" required placeholder="Masukkan judul buku">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Penulis</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-person-badge icon-left text-primary"></i>
                                            <select name="id_penulis" class="form-select-custom" required>
                                                <?php foreach($penulis as $p): ?>
                                                    <option value="<?= $p['id_penulis'] ?>" <?= $buku['id_penulis'] == $p['id_penulis'] ? 'selected' : '' ?>>
                                                        <?= $p['nama_penulis'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Penerbit</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-building icon-left text-primary"></i>
                                            <select name="id_penerbit" class="form-select-custom" required>
                                                <?php foreach($penerbit as $pen): ?>
                                                    <option value="<?= $pen['id_penerbit'] ?>" <?= $buku['id_penerbit'] == $pen['id_penerbit'] ? 'selected' : '' ?>>
                                                        <?= $pen['nama_penerbit'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <h5 class="fw-bold text-dark mb-1"><i class="bi bi-tags-fill text-primary me-2"></i>Klasifikasi & Stok</h5>
                                        <hr class="text-muted opacity-25">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Tahun Terbit</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-calendar-event icon-left text-primary"></i>
                                            <input type="number" name="tahun_terbit" class="form-control-custom" value="<?= $buku['tahun_terbit'] ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Kategori</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-tag icon-left text-primary"></i>
                                            <select name="id_kategori" class="form-select-custom" required>
                                                <?php foreach($kategori as $k): ?>
                                                    <option value="<?= $k['id_kategori'] ?>" <?= $buku['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                                        <?= $k['nama_kategori'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Lokasi Rak</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-geo-alt icon-left text-primary"></i>
                                            <select name="id_rak" class="form-select-custom" required>
                                                <?php foreach($rak as $r): ?>
                                                    <option value="<?= $r['id_rak'] ?>" <?= ($buku['id_rak'] ?? '') == $r['id_rak'] ? 'selected' : '' ?>>
                                                        <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Jumlah Unit Tersedia</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-box-seam icon-left text-primary"></i>
                                            <input type="number" name="tersedia" class="form-control-custom" value="<?= $buku['tersedia'] ?>" required>
                                            <span class="position-absolute end-0 me-3 badge bg-light text-muted border">Eksemplar</span>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Sinopsis Buku</label>
                                        <textarea name="deskripsi" class="form-control-custom w-100" rows="5" style="padding-left: 20px;" placeholder="Tuliskan ringkasan cerita atau detail isi buku..."><?= $buku['deskripsi'] ?></textarea>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex flex-column flex-sm-row gap-3 pt-4 border-top">
                                    <button type="submit" class="btn btn-warning rounded-pill px-5 py-3 fw-bold shadow-sm transition-hover flex-grow-1">
                                        <i class="bi bi-cloud-arrow-up-fill me-2"></i> Update Data Buku
                                    </button>
                                    <a href="<?= base_url('buku') ?>" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-muted border">
                                        Batalkan Perubahan
                                    </a>
                                </div>
                            </div>
                        </div>
                        <p class="text-center text-muted extra-small italic">Terakhir diperbarui sistem pada: <?= date('d/m/Y H:i') ?> WIB</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .ls-1 { letter-spacing: 0.8px; }
    .extra-small { font-size: 0.75rem; }
    
    /* Custom Input Styles */
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8faff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .input-group-custom:focus-within {
        background: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 12px 16px 12px 48px;
        border: none;
        background: transparent;
        outline: none;
        font-weight: 500;
        color: #1e293b;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .icon-left {
        position: absolute;
        left: 18px;
        font-size: 1.1rem;
    }

    /* Buttons */
    .btn-warning { background: #ffc107; color: #000; border: none; }
    .btn-warning:hover { background: #ffca2c; transform: translateY(-2px); box-shadow: 0 8px 15px rgba(255, 193, 7, 0.2); }
    .btn-white { background: #fff; color: #4f46e5; }
    .back-btn:hover { background: #4f46e5; color: #fff !important; transform: translateX(-5px); transition: 0.3s; }

    .transition-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
</style>

<script>
    function previewCover() {
        const cover = document.querySelector('#cover');
        const imgPreview = document.querySelector('#img-preview');
        
        if (cover.files && cover.files[0]) {
            const reader = new FileReader();
            reader.readAsDataURL(cover.files[0]);

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    }
</script>

<?= $this->endSection() ?>