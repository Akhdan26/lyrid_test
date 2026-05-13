<nav class="topbar bg-white shadow-sm fixed-top d-flex align-items-center justify-content-between px-4">
    <span class="fw-semibold text-secondary"><?= esc($title ?? 'Dashboard') ?></span>
    <div class="dropdown">
        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i><?= esc(session('user')['name'] ?? 'User') ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text text-muted small"><?= esc(session('user')['role'] ?? '') ?></span></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="/logout" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>
</nav>
<div class="main-content">
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>