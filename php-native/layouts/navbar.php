<nav class="navbar-top d-flex justify-content-between align-items-center">
    <div>
        <h5 class="mb-0 text-primary fw-bold">PrimaTest</h5>
    </div>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle fs-5 me-2"></i>
            <span><?= $_SESSION['user']['name'] ?? 'User' ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="../auth/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>
</nav>