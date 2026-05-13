<style>
    body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    .auth-card { max-width: 420px; width: 100%; }
</style>
<div class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <div class="auth-card">
        <div class="text-center mb-3">
            <i class="bi bi-hexagon text-white" style="font-size: 3rem;"></i>
            <h4 class="text-white mt-2">CI4 App</h4>
        </div>
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title text-center mb-4">Register</h5>
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>
                <form action="/auth/processRegister" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-person-plus me-2"></i>Register</button>
                </form>
                <p class="text-center mt-3 mb-0 small">Sudah punya akun? <a href="/login">Login</a></p>
            </div>
        </div>
    </div>
</div>