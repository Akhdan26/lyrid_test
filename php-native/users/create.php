<?php
require_once __DIR__ . "/../middleware/auth.php";
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<div class="d-flex">
    <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
    <div class="col px-0">
        <?php include __DIR__ . "/../layouts/navbar.php"; ?>
        <div class="main-content">
            <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i>Tambah User</h4>

            <div class="card">
                <div class="card-body p-4">
                    <form action="store.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
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