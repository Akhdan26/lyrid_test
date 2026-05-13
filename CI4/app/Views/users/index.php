<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold">Manajemen User</h3>
    <a href="/users/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah User</a>
</div>

<?php if ($success): ?>
    <?php if ($success == '1'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>User berhasil ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif ($success == '2'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>User berhasil diupdate.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif ($success == '3'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>User berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
<?php endif; ?>
<?php if ($error == 'self_delete'): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>Anda tidak bisa menghapus diri sendiri.
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-4 py-3">
        <form method="get" class="row g-2 align-items-end mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau username..." value="<?= esc($search) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary"><i class="bi bi-search me-1"></i>Cari</button>
                <?php if ($search): ?>
                <a href="/users" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($users as $u): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($u['name']) ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><span class="badge <?= $u['role'] == 'admin' ? 'bg-primary' : 'bg-secondary' ?>"><?= esc($u['role']) ?></span></td>
                        <td class="text-center">
                            <a href="/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="/users/delete/<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>