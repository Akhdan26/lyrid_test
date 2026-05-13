<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($conn, "SELECT * FROM employees WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$employee = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$employee) {
    header("Location: index.php");
    exit;
}
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<div class="d-flex">
    <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
    <div class="col px-0">
        <?php include __DIR__ . "/../layouts/navbar.php"; ?>
        <div class="main-content">
            <h4 class="mb-4"><i class="bi bi-pencil me-2"></i>Edit Pegawai</h4>

            <div class="card">
                <div class="card-body p-4">
                    <form action="update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $employee['id'] ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($employee['name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($employee['email']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($employee['phone']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto <small class="text-muted">(jpg/jpeg, max 300KB)</small></label>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($employee['photo']): ?>
                                        <img src="../uploads/<?= htmlspecialchars($employee['photo']) ?>" alt="foto" class="rounded" width="60" height="60" style="object-fit:cover;">
                                    <?php endif; ?>
                                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg">
                                </div>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($employee['address']) ?></textarea>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning"><i class="bi bi-save me-2"></i>Update</button>
                            <a href="index.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../layouts/footer.php"; ?>