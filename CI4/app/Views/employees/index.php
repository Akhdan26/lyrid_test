<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold">Manajemen Pegawai</h3>
    <a href="/employees/create" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Pegawai</a>
</div>

<?php if ($success): ?>
    <?php if ($success == '1'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>Pegawai berhasil ditambahkan.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif ($success == '2'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>Pegawai berhasil diupdate.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php elseif ($success == '3'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i>Pegawai berhasil dihapus.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body px-4 py-3">
        <form method="get" class="row g-2 align-items-end mb-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="<?= esc($search) ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-outline-secondary"><i class="bi bi-search me-1"></i>Cari</button>
                <?php if ($search): ?>
                <a href="/employees" class="btn btn-outline-danger"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($employees)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>
                    <?php else: ?>
                    <?php $no = 1; foreach ($employees as $e): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <?php if ($e['photo'] && file_exists(FCPATH . 'uploads/' . $e['photo'])): ?>
                            <img src="/uploads/<?= esc($e['photo']) ?>" alt="foto" class="rounded-circle" style="width:45px;height:45px;object-fit:cover;">
                            <?php else: ?>
                            <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                <i class="bi bi-person text-secondary"></i>
                            </div>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($e['name']) ?></td>
                        <td><?= esc($e['email']) ?></td>
                        <td><?= esc($e['phone']) ?></td>
                        <td><?= esc($e['address']) ?></td>
                        <td class="text-center">
                            <a href="/employees/edit/<?= $e['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <a href="/employees/delete/<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pegawai ini?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>