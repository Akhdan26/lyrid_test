<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id = $_GET['id'] ?? 0;

// jangan hapus diri sendiri
if ($id == $_SESSION['user']['id']) {
    header("Location: index.php?error=self_delete");
    exit;
}

$stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php?success=3");
exit;