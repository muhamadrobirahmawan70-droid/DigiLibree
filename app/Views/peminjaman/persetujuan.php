<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-5" style="background-color: #f8f9ff; min-height: 100vh;">
    <div class="row justify-content-center animate-fade-in">
        <div class="col-lg-11">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <div class="d-flex align-items-center">
                    <div class="bg-berry-gradient p-3 rounded-4 me-4 shadow-berry">
                        <i class="bi bi-shield-lock-fill text-white fs-3"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -1.5px;">Persetujuan Peminjaman 🔑</h2>
                        <p class="text-muted small mb-0">Kelola permintaan khusus member yang telah mencapai batas limit buku.</p>
                    </div>
                </div>
                <div class="d-none d-md-block">
                    <span class="badge bg-purple-soft text-purple-berry rounded-pill px-4 py-2 fw-bold border border-purple-light">
                        Admin Mode
                    </span>
                </div>
            </div>

            <div class="card border-0 shadow-soft rounded-5 overflow-hidden bg-white">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="bg-light-berry">
                                <th class="ps-4 py-4 text-uppercase extra-small fw-800 text-purple-berry" width="300">Nama Member</th>
                                <th class="py-4 text-uppercase extra-small fw-800 text-purple-berry">Buku yang Diminta</th>
                                <th class="py-4 text-uppercase extra-small fw-800 text-purple-berry">Tgl Pengajuan</th>
                                <th class="py-4 text-center text-uppercase extra-small fw-800 text-purple-berry">Keputusan Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($requests)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="mb-4">
                                                <i class="bi bi-check2-all text-light-gray display-1"></i>
                                            </div>
                                            <h4 class="fw-bold text-muted">Kerja Bagus, Min!</h4>
                                            <p class="text-muted small">Semua antrean permintaan sudah bersih dan diproses.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $r): ?>
                                    <tr class="transition-hover">
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-berry me-3 bg-berry-gradient rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm">
                                                    <?= strtoupper(substr($r['nama'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0"><?= $r['nama'] ?></div>
                                                    <div class="text-muted extra-small fw-semibold text-uppercase opacity-75">ID: #USR-<?= str_pad($r['id_user'] ?? '0', 3, '0', STR_PAD_LEFT) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <div class="fw-bold text-dark mb-1"><?= $r['judul'] ?></div>
                                            <span class="badge bg-danger-soft text-danger extra-small rounded-pill border border-danger-light">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Limit Terlampaui
                                            </span>
                                        </td>
                                        <td class="py-4">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-calendar3 me-2 text-purple-berry"></i>
                                                <span class="small fw-bold"><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center pe-4 py-4">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="<?= base_url('peminjaman/approve/' . $r['id_peminjaman']) ?>" 
                                                   class="btn btn-success-berry rounded-pill px-4 btn-sm fw-bold shadow-sm"
                                                   onclick="return confirm('Izinkan member meminjam buku ini?')">
                                                    <i class="bi bi-check-lg me-1"></i> Izinkan
                                                </a>
                                                <a href="<?= base_url('peminjaman/reject/' . $r['id_peminjaman']) ?>" 
                                                   class="btn btn-outline-danger-berry rounded-pill px-4 btn-sm fw-bold shadow-sm"
                                                   onclick="return confirm('Tolak permintaan ini?')">
                                                    <i class="bi bi-x-lg me-1"></i> Tolak
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <p class="text-center text-muted mt-4 small fw-semibold opacity-50">
                <i class="bi bi-info-circle me-1"></i> Keputusan admin bersifat final dan akan langsung merubah status kuota member.
            </p>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9ff; }
    
    /* Berry Theme Colors */
    .text-purple-berry { color: #673ab7 !important; }
    .bg-berry-gradient { background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%); }
    .bg-purple-soft { background-color: #f3e5f5; }
    .border-purple-light { border-color: #e1bee7 !important; }
    .bg-light-berry { background-color: #fcfaff; }
    
    /* Buttons */
    .btn-success-berry { background-color: #10b981; border: none; color: white; transition: all 0.3s; }
    .btn-success-berry:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3); color: white; }
    
    .btn-outline-danger-berry { border: 2px solid #ef4444; color: #ef4444; transition: all 0.3s; background: transparent; }
    .btn-outline-danger-berry:hover { background-color: #ef4444; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(239, 68, 68, 0.2); }

    /* Utility */
    .rounded-5 { border-radius: 2rem !important; }
    .extra-small { font-size: 0.65rem; }
    .fw-800 { font-weight: 800; }
    .text-light-gray { color: #e2e8f0; }
    .shadow-soft { box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important; }
    .shadow-berry { box-shadow: 0 10px 20px rgba(103, 58, 183, 0.2); }
    
    .avatar-berry { width: 42px; height: 42px; }
    
    /* Soft Badges */
    .bg-danger-soft { background-color: #fef2f2; }
    .border-danger-light { border-color: #fee2e2 !important; }

    /* Hover Effect */
    .transition-hover { transition: background-color 0.3s; }
    .transition-hover:hover { background-color: #f8f9ff !important; }

    /* Animation */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
</style>

<?= $this->endSection() ?>