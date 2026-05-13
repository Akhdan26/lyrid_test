<?php
require_once __DIR__ . "/../middleware/auth.php";

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<div class="d-flex">
    <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
    <div class="col px-0">
        <?php include __DIR__ . "/../layouts/navbar.php"; ?>
        <div class="main-content">
            <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i>Tambah Pegawai</h4>
            <?php if ($success === '1'): ?>
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data Pegawai berhasil disimpan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if ($error === 'empty'): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>Nama, Email, dan No. Telepon wajib diisi.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if ($error === 'size'): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>Ukuran file lebih dari 300KB.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if ($error === 'format'): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>Format file tidak valid. Harap unggah file dengan format JPG atau JPEG.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body p-4">
                    <form action="store.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" placeholder="Masukkan no. telepon" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto <small class="text-muted">(jpg/jpeg, max 300KB)</small></label>
                                <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg">
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat"></textarea>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../layouts/footer.php"; ?>