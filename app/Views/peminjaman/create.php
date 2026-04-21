<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Tambah Transaksi Peminjaman</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('peminjaman'); ?>" method="post">
                        <?= csrf_field(); ?>
                        

                        <div class="mb-3">
                            <label for="id_user" class="form-label fw-bold">Peminjam (User)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <select name="id_user" id="id_user" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Nama Peminjam --</option>
                                    <?php foreach ($users as $u) : ?>
                                        <option value="<?= $u['id']; ?>"><?= $u['username']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_buku" class="form-label fw-bold">Buku yang Dipinjam</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-book"></i></span>
                                <select name="id_buku" id="id_buku" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Judul Buku (Sisa Stok) --</option>
                                    <?php foreach ($buku as $b) : ?>
                                        <option value="<?= $b['id_buku']; ?>">
                                            <?= $b['judul']; ?> (Stok: <?= $b['stok']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <small class="text-muted text-italic">*Buku dengan stok 0 tidak muncul di daftar.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_pinjam" class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" 
                                       value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kembali" class="form-label fw-bold">Batas Pengembalian</label>
                                <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" 
                                       value="<?= date('Y-m-d', strtotime('+7 days')); ?>" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= base_url('peminjaman'); ?>" class="btn btn-outline-secondary px-4">
    <i class="bi bi-arrow-left"></i> Kembali
</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                <i class="bi bi-save"></i> Simpan Transaksi
                            </button>
                        </div>
                                        
                    </form>
                </div>
            </div>
            
            <div class="mt-3 p-3 bg-light border rounded">
                <p class="mb-0 small text-secondary">
                    <i class="bi bi-info-circle-fill text-primary"></i> 
                    <strong>Sistem Denda:</strong> Keterlambatan akan dikenakan denda otomatis sebesar Rp 2.000/hari saat proses pengembalian.
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>