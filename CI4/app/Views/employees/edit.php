<div class="d-flex align-items-center mb-4">
    <a href="/employees" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h3 class="mb-0 fw-bold">Edit Pegawai</h3>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="/employees/update/<?= $employee['id'] ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="<?= esc($employee['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?= esc($employee['email']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. HP <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" value="<?= esc($employee['phone']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto <small class="text-muted">(JPG/JPEG, max 300KB)</small></label>
                    <?php if ($employee['photo'] && file_exists(FCPATH . 'uploads/' . $employee['photo'])): ?>
                    <div class="mb-2">
                        <img src="/uploads/<?= esc($employee['photo']) ?>" alt="foto" class="rounded-3" style="width:80px;height:80px;object-fit:cover;">
                        <small class="text-muted ms-2">Foto saat ini</small>
                    </div>
                    <?php endif; ?>
                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3"><?= esc($employee['address']) ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Update</button>
                <a href="/employees" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>