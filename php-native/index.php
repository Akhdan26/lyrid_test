<?php
require_once __DIR__ . "/middleware/auth.php";
require_once __DIR__ . "/config/database.php";

// hitung jumlah user & pegawai
$totalUsers  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$totalEmps   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM employees"))['total'];
?>
<?php include __DIR__ . "/layouts/header.php"; ?>
<div class="d-flex">
    <?php include __DIR__ . "/layouts/sidebar.php"; ?>
    <div class="col px-0">
        <?php include __DIR__ . "/layouts/navbar.php"; ?>
        <div class="main-content">
            <h4 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-people fs-1 text-primary"></i>
                            <h2 class="mt-3 fw-bold"><?= $totalUsers ?></h2>
                            <p class="text-muted mb-0">Total Users</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-person-badge fs-1 text-success"></i>
                            <h2 class="mt-3 fw-bold"><?= $totalEmps ?></h2>
                            <p class="text-muted mb-0">Total Pegawai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center p-4">
                        <div class="card-body">
                            <i class="bi bi-person-circle fs-1 text-warning"></i>
                            <h5 class="mt-3"><?= $_SESSION['user']['name'] ?></h5>
                            <p class="text-muted mb-0">Login sebagai <span class="badge bg-info"><?= $_SESSION['user']['role'] ?></span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include __DIR__ . "/layouts/footer.php"; ?>