<?php
session_start();
if (isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}
$error = $_GET['error'] ?? '';
?>
<?php include __DIR__ . "/../layouts/header.php"; ?>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card shadow">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-building fs-1 text-primary"></i>
                    <h4 class="mt-2 fw-bold">PrimaTest</h4>
                    <p class="text-muted">Sign in to your account</p>
                </div>

                <?php if ($error === 'failed'): ?>
                    <div class="alert alert-danger">Invalid username or password.</div>
                <?php endif; ?>

                <form action="process_login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Enter username" required autofocus>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <p class="text-center text-muted mb-0">
                    Don't have an account?
                    <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . "/../layouts/footer.php"; ?>