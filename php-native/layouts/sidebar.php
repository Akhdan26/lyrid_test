<div class="col-auto col-md-3 col-xl-2 px-0 sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0"><i class="bi bi-building me-2"></i>PrimaTest</h4>
        <small class="text-white-50">Management System</small>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) == 'index.php' ? 'active' : '' ?>" href="../index.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['SCRIPT_NAME'], '/users/') !== false ? 'active' : '' ?>" href="../users/index.php">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= strpos($_SERVER['SCRIPT_NAME'], '/employees/') !== false ? 'active' : '' ?>" href="../employees/index.php">
                <i class="bi bi-person-badge"></i> Manajemen Pegawai
            </a>
        </li>
    </ul>
    <div class="mt-auto p-3" style="position: absolute; bottom: 0;">
        <small class="text-white-50">&copy; <?= date('Y') ?> PrimaTest</small>
    </div>
</div>