<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
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
            <h4 class="mb-4"><i class="bi bi-pencil me-2"></i>Edit User</h4>

            <div class="card">
                <div class="card-body p-4">
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password baru">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
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