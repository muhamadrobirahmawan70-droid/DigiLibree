<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5" style="background-color: #f8f9ff; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10">
            
            <div class="d-flex align-items-center mb-5 animate-fade-in">
                <a href="<?= base_url('buku') ?>" class="btn btn-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center back-btn" style="width: 48px; height: 48px; border: 1px solid #e2e8f0;">
                    <i class="bi bi-arrow-left text-purple-berry fs-5"></i>
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
                        <div class="card border-0 shadow-sm rounded-5 sticky-top" style="top: 20px;">
                            <div class="card-body p-4 text-center">
                                <label class="form-label fw-bold text-purple-berry small text-uppercase ls-1 mb-4 d-block">Sampul Koleksi</label>
                                
                                <div class="position-relative d-inline-block mb-3">
                                    <div class="overflow-hidden rounded-4 shadow-sm bg-light d-flex align-items-center justify-content-center preview-container" style="width: 220px; height: 320px; border: 3px dashed #d1d5db; transition: 0.3s;">
                                        <img src="" id="img-preview" class="img-fluid w-100 h-100 d-none" style="object-fit: cover;">
                                        <div id="placeholder-icon" class="text-center p-3">
                                            <i class="bi bi-cloud-arrow-up text-purple-berry opacity-25" style="font-size: 4rem;"></i>
                                            <p class="text-muted small fw-bold mt-2">Klik ikon plus untuk unggah sampul</p>
                                        </div>
                                    </div>
                                    
                                    <label for="cover" class="btn btn-berry-gradient rounded-circle position-absolute shadow-lg d-flex align-items-center justify-content-center" 
                                           style="width: 50px; height: 50px; bottom: -15px; right: -15px; border: 5px solid #fff; cursor: pointer;">
                                        <i class="bi bi-plus-lg text-white fs-5"></i>
                                    </label>
                                    <input type="file" name="cover" id="cover" class="d-none" accept="image/*" onchange="previewCover()">
                                </div>
                                <div class="alert alert-info border-0 rounded-4 mt-4 py-2">
                                    <small class="extra-small fw-bold text-purple-berry"><i class="bi bi-info-circle me-1"></i> Format: JPG, PNG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-5 mb-4">
                            <div class="card-body p-4 p-md-5">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="bg-purple-soft p-2 rounded-3 me-3">
                                                <i class="bi bi-info-circle-fill text-purple-berry"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-0">Informasi Utama</h5>
                                        </div>
                                        <hr class="text-muted opacity-10">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Judul Lengkap Buku</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-journal-text icon-left text-purple-berry"></i>
                                            <input type="text" name="judul" class="form-control-custom" placeholder="Masukkan judul buku..." required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Penulis</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-person-badge icon-left text-purple-berry"></i>
                                            <select name="id_penulis" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Penulis</option>
                                                <?php foreach($penulis as $p): ?>
                                                    <option value="<?= $p['id_penulis'] ?>"><?= $p['nama_penulis'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Penerbit</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-building icon-left text-purple-berry"></i>
                                            <select name="id_penerbit" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Penerbit</option>
                                                <?php foreach($penerbit as $pen): ?>
                                                    <option value="<?= $pen['id_penerbit'] ?>"><?= $pen['nama_penerbit'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <div class="d-flex align-items-center mb-1">
                                            <div class="bg-purple-soft p-2 rounded-3 me-3">
                                                <i class="bi bi-tags-fill text-purple-berry"></i>
                                            </div>
                                            <h5 class="fw-bold text-dark mb-0">Klasifikasi & Stok</h5>
                                        </div>
                                        <hr class="text-muted opacity-10">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Tahun Terbit</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-calendar-event icon-left text-purple-berry"></i>
                                            <input type="number" name="tahun_terbit" class="form-control-custom" placeholder="YYYY" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Kategori</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-tag icon-left text-purple-berry"></i>
                                            <select name="id_kategori" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                <?php foreach($kategori as $k): ?>
                                                    <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Lokasi Rak</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-geo-alt icon-left text-purple-berry"></i>
                                            <select name="id_rak" class="form-select-custom" required>
                                                <option value="" disabled selected>Pilih Rak</option>
                                                <?php foreach($rak as $r): ?>
                                                    <option value="<?= $r['id_rak'] ?>"><?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Jumlah Stok</label>
                                        <div class="input-group-custom">
                                            <i class="bi bi-box-seam icon-left text-purple-berry"></i>
                                            <input type="number" name="tersedia" class="form-control-custom" min="1" placeholder="0" required>
                                            <span class="position-absolute end-0 me-3 badge bg-purple-soft text-purple-berry border-0">Unit</span>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Sinopsis Koleksi</label>
                                        <textarea name="deskripsi" class="form-control-custom-area w-100" rows="5" placeholder="Tuliskan ringkasan cerita buku secara menarik..."></textarea>
                                    </div>
                                    <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Dokumen E-Book (PDF)</label>
                                    <div class="input-group-custom">
                                    <i class="bi bi-file-earmark-pdf icon-left text-danger"></i>
                                    <input type="file" name="file_pdf" class="form-control-custom" accept=".pdf">
                                    </div>
    
                                    </div>
                                </div>
                                <div class="mt-5 d-flex flex-column flex-sm-row gap-3 pt-4 border-top">
                                    <button type="submit" class="btn btn-berry-gradient rounded-pill px-5 py-3 fw-bold shadow transition-hover flex-grow-1">
                                        <i class="bi bi-cloud-plus-fill me-2"></i> Tambah ke Katalog
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
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9ff; }
    .text-purple-berry { color: #673ab7 !important; }
    .bg-purple-soft { background-color: #f3e5f5; }
    .ls-1 { letter-spacing: 0.8px; }
    .extra-small { font-size: 0.7rem; }
    .rounded-5 { border-radius: 2rem !important; }
    
    /* Input Custom Styles */
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .input-group-custom:focus-within {
        border-color: #673ab7;
        box-shadow: 0 10px 25px rgba(103, 58, 183, 0.1);
    }

    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 14px 16px 14px 52px;
        border: none;
        background: transparent;
        outline: none;
        font-weight: 600;
        color: #1e293b;
        font-size: 0.95rem;
    }

    .form-control-custom-area {
        width: 100%;
        padding: 16px 20px;
        border: 2px solid #f1f5f9;
        border-radius: 16px;
        background: #ffffff;
        outline: none;
        font-weight: 500;
        transition: 0.3s;
    }
    .form-control-custom-area:focus {
        border-color: #673ab7;
        background: #fff;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23673ab7' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1.2rem center;
        background-size: 16px 12px;
    }

    .icon-left {
        position: absolute;
        left: 20px;
        font-size: 1.2rem;
    }

    /* Buttons & Effects */
    .btn-berry-gradient {
        background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%);
        color: white;
        border: none;
    }
    .btn-berry-gradient:hover {
        color: white;
        filter: brightness(1.1);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(103, 58, 183, 0.3);
    }

    .btn-white { background: #fff; }
    .back-btn:hover { background: #673ab7; color: #fff !important; transform: translateX(-5px); transition: 0.3s; }

    .preview-container:hover {
        border-color: #673ab7 !important;
        background: #f3e5f5 !important;
    }

    .transition-hover { transition: all 0.3s ease; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.6s ease-out; }
</style>

<script>
    function previewCover() {
        const cover = document.querySelector('#cover');
        const imgPreview = document.querySelector('#img-preview');
        const placeholderIcon = document.querySelector('#placeholder-icon');
        const previewContainer = document.querySelector('.preview-container');
        
        if (cover.files && cover.files[0]) {
            const reader = new FileReader();
            reader.readAsDataURL(cover.files[0]);

            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.classList.remove('d-none');
                placeholderIcon.classList.add('d-none');
                previewContainer.style.borderStyle = 'solid';
                previewContainer.style.borderColor = '#673ab7';
            }
        }
    }
</script>

<?= $this->endSection() ?>