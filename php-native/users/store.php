<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

if ($name === '' || $username === '' || $password === '' || $role === '') {
    header("Location: create.php?error=empty");
    exit;
}

// cek username exist
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    header("Location: create.php?error=username_taken");
    exit;
}

$hashed = password_hash($password, PASSWORD_BCRYPT);
$stmt2  = mysqli_prepare($conn, "INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt2, "ssss", $name, $username, $hashed, $role);
mysqli_stmt_execute($stmt2);

header("Location: index.php?success=1");
exit;