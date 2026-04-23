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
                    <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -1.5px;">Tambah Koleksi Baru 📚</h2>
                    <p class="text-muted small mb-0">Lengkapi detail buku untuk memperkaya katalog perpustakaan</p>
                </div>
            </div>

            <form action="<?= base_url('buku/store') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">
                            <div class="card-body p-4 text-center">
                                <label class="form-label fw-bold text-dark small text-uppercase ls-1 mb-3 d-block">Sampul Buku</label>
                                
                                <div class="position-relative d-inline-block mb-3 group">
                                    <div class="overflow-hidden rounded-4 shadow-sm bg-light d-flex align-items-center justify-content-center" style="width: 210px; height: 300px; border: 2px dashed #cbd5e1;">
                                        <img src="" id="img-preview" class="img-fluid w-100 h-100 d-none" style="object-fit: cover;">
                                        <div id="placeholder-icon" class="text-center">
                                            <i class="bi bi-image text-muted opacity-50" style="font-size: 4rem;"></i>
                                            <p class="text-muted small px-2">Preview Sampul</p>
                                        </div>
                                    </div>
                                    <label for="cover" class="btn btn-primary rounded-circle position-absolute shadow-lg d-flex align-items-center justify-content-center" 
                                           style="width: 45px; height: 45px; bottom: -15px; right: -15px; border: 4px solid #fff; cursor: pointer;">
                                        <i class="bi bi-plus-lg"></i>
                                    </label>
                                    <input type="file" name="cover" id="cover" class="d-none" accept="image/*" onchange="previewCover()">
                                </div>
                                <p class="text-muted extra-small mt-3">Rekomendasi ukuran 2:3<br>(Contoh: 600x900px)</p>
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
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Judul Lengkap Buku</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-journal-text icon-left text-primary"></i>
                                            <input type="text" name="judul" class="form-control-custom" placeholder="Contoh: Laskar Pelangi" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Penulis</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-person-badge icon-left text-primary"></i>
                                            <select name="id_penulis" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Penulis</option>
                                                <?php foreach($penulis as $p): ?>
                                                    <option value="<?= $p['id_penulis'] ?>"><?= $p['nama_penulis'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Penerbit</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-building icon-left text-primary"></i>
                                            <select name="id_penerbit" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Penerbit</option>
                                                <?php foreach($penerbit as $pen): ?>
                                                    <option value="<?= $pen['id_penerbit'] ?>"><?= $pen['nama_penerbit'] ?></option>
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
                                            <input type="number" name="tahun_terbit" class="form-control-custom" placeholder="YYYY" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Kategori</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-tag icon-left text-primary"></i>
                                            <select name="id_kategori" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                <?php foreach($kategori as $k): ?>
                                                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Lokasi Rak</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-geo-alt icon-left text-primary"></i>
                                            <select name="id_rak" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Rak</option>
                                                <?php foreach($rak as $r): ?>
                                                    <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Jumlah Stok (PENTING)</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-box-seam icon-left text-primary"></i>
                                            <input type="number" name="tersedia" class="form-control-custom" min="1" placeholder="Masukkan jumlah buku" required>
                                            <span class="position-absolute end-0 me-3 badge bg-light text-muted border">Eks</span>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1">Sinopsis Buku</label>
                                        <textarea name="deskripsi" class="form-control-custom w-100" rows="5" style="padding-left: 20px;" placeholder="Tuliskan ringkasan cerita buku..."></textarea>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex flex-column flex-sm-row gap-3 pt-4 border-top">
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-sm transition-hover flex-grow-1">
                                        <i class="bi bi-cloud-check-fill me-2"></i> Simpan ke Katalog
                                    </button>
                                    <a href="<?= base_url('buku') ?>" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-muted border">
                                        Batalkan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; }
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

    .btn-white { background: #fff; color: #4f46e5; }
    .back-btn:hover { background: #4f46e5; color: #fff !important; transform: translateX(-5px); transition: 0.3s; }

    .transition-hover { transition: all 0.3s ease; }
    .transition-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(79, 70, 229, 0.2) !important; }
    
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
</style>

<script>
    function previewCover() {
        const cover = document.querySelector('#cover');
        const imgPreview = document.querySelector('#img-preview');
        const placeholderIcon = document.querySelector('#placeholder-icon');
        
        if (cover.files && cover.files[0]) {
            const reader = new FileReader();
            reader.readAsDataURL(cover.files[0]);

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
                placeholderIcon.classList.add('d-none');
            }
        }
    }
</script>

<?= $this->endSection() ?>