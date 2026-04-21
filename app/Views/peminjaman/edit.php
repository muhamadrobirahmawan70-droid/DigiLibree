<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="bi bi-pencil-fill"></i> Edit Peminjaman</h5>
        </div>
        <div class="card-body">
            <form action="<?= base_url('peminjaman/' . $pinjam['id_peminjaman']); ?>" method="post">
                <?= csrf_field(); ?>
                
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-3">
                    <label class="form-label fw-bold">Peminjam</label>
                    <select name="id_user" class="form-select">
                        <?php foreach($users as $u): ?>
                            <option value="<?= $u['id']; ?>" <?= ($u['id'] == $pinjam['id_user']) ? 'selected' : ''; ?>>
                                <?= $u['username']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Buku</label>
                    <select name="id_buku" class="form-select">
                        <?php foreach($buku as $b): ?>
                            <option value="<?= $b['id_buku']; ?>" <?= ($b['id_buku'] == $pinjam['id_buku']) ? 'selected' : ''; ?>>
                                <?= $b['judul']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" value="<?= $pinjam['tanggal_pinjam']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Batas Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="<?= $pinjam['tanggal_kembali']; ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="dipinjam" <?= ($pinjam['status'] == 'dipinjam') ? 'selected' : ''; ?>>Dipinjam</option>
                        <option value="kembali" <?= ($pinjam['status'] == 'kembali') ? 'selected' : ''; ?>>Kembali</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="<?= base_url('peminjaman'); ?>" class="btn btn-light border">Batal</a>
                    
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>