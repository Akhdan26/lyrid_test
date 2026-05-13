<div class="d-flex align-items-center mb-4">
    <a href="/employees" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h3 class="mb-0 fw-bold">Tambah Pegawai</h3>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="/employees/store" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. HP <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto <small class="text-muted">(JPG/JPEG, max 300KB)</small></label>
                    <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="/employees" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>