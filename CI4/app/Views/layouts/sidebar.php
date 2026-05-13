<div class="sidebar d-flex flex-column py-3">
    <div class="px-3 mb-4">
        <h5 class="text-white mb-0"><i class="bi bi-hexagon me-2"></i>CI4 App</h5>
    </div>
    <nav class="flex-grow-1">
        <a href="/" class="nav-link <?= uri_string() == '/' ? 'active' : '' ?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="/users" class="nav-link <?= str_starts_with(uri_string(), 'users') ? 'active' : '' ?>"><i class="bi bi-people me-2"></i> Manajemen User</a>
        <a href="/employees" class="nav-link <?= str_starts_with(uri_string(), 'employees') ? 'active' : '' ?>"><i class="bi bi-person-badge me-2"></i> Manajemen Pegawai</a>
    </nav>
    <div class="px-3 mt-auto">
        <a href="/logout" class="btn btn-outline-light btn-sm w-100"><i class="bi bi-box-arrow-left me-2"></i>Logout</a>
    </div>
</div>