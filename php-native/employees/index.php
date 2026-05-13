<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$search = $_GET['search'] ?? '';
$where  = '';
$params = [];
$types  = '';

if ($search !== '') {
    $where   = "WHERE name LIKE ? OR email LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $types   = "ss";
}

$sql  = "SELECT * FROM employees $where ORDER BY id DESC";
$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result    = mysqli_stmt_get_result($stmt);
$employees = mysqli_fetch_all($result, MYSQLI_ASSOC);

$success = $_GET['success'] ?? '';
$error   = $_GET['error'] ?? '';
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<div class="d-flex">
    <?php include __DIR__ . "/../layouts/sidebar.php"; ?>
    <div class="col px-0">
        <?php include __DIR__ . "/../layouts/navbar.php"; ?>
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i>Manajemen Pegawai</h4>
                <a href="create.php" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Pegawai</a>
            </div>

            <?php if ($success === '1'): ?>
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data pegawai berhasil disimpan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php elseif ($success === '2'): ?>
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data pegawai berhasil diupdate.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php elseif ($success === '3'): ?>
                <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>Data pegawai berhasil dihapus.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>
            <?php if ($error === 'size'): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>Ukuran file terlalu besar (maks 300KB).<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php elseif ($error === 'format'): ?>
                <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>Format file harus JPG/JPEG.<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Pegawai</span>
                    <form method="GET" class="d-flex" style="max-width:300px;">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pegawai..." value="<?= htmlspecialchars($search) ?>">
                        <button type="submit" class="btn btn-sm btn-outline-secondary ms-2"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Alamat</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($employees) === 0): ?>
                                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pegawai.</td></tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($employees as $e): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td>
                                                <?php if ($e['photo']): ?>
                                                    <img src="../uploads/<?= htmlspecialchars($e['photo']) ?>" alt="foto" class="rounded" width="50" height="50" style="object-fit:cover;">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($e['name']) ?></td>
                                            <td><?= htmlspecialchars($e['email']) ?></td>
                                            <td><?= htmlspecialchars($e['phone']) ?></td>
                                            <td style="max-width:200px;" class="text-truncate"><?= htmlspecialchars($e['address']) ?></td>
                                            <td class="text-end">
                                                <a href="edit.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                                <a href="delete.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pegawai ini?')"><i class="bi bi-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../layouts/footer.php"; ?>