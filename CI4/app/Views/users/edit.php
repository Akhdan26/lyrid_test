<div class="d-flex align-items-center mb-4">
    <a href="/users" class="btn btn-outline-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h3 class="mb-0 fw-bold">Edit User</h3>
</div>
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="/users/update/<?= $user['id'] ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="<?= esc($user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" name="username" class="form-control" value="<?= esc($user['username']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak ganti)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Update</button>
                <a href="/users" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>