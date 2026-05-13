<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold">Dashboard</h3>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total User</h6>
                        <h3 class="mb-0 fw-bold"><?= $users ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-person-badge text-success" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Pegawai</h6>
                        <h3 class="mb-0 fw-bold"><?= $employees ?? 0 ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-person-circle text-warning" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Logged In</h6>
                        <small class="fw-semibold"><?= esc(session('user')['name'] ?? '-') ?></small><br>
                        <small class="badge bg-secondary"><?= esc(session('user')['role'] ?? '-') ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>