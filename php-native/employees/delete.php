<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id = $_GET['id'] ?? 0;

// ambil foto dulu
$stmt = mysqli_prepare($conn, "SELECT photo FROM employees WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$employee = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($employee && $employee['photo']) {
    $path = __DIR__ . "/../uploads/" . $employee['photo'];
    if (file_exists($path)) {
        unlink($path);
    }
}

$stmt2 = mysqli_prepare($conn, "DELETE FROM employees WHERE id = ?");
mysqli_stmt_bind_param($stmt2, "i", $id);
mysqli_stmt_execute($stmt2);

header("Location: index.php?success=3");
exit;