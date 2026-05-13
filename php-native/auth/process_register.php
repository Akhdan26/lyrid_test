<?php
session_start();
require_once __DIR__ . "/../config/database.php";

$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $username === '' || $password === '') {
    header("Location: register.php?error=empty");
    exit;
}

// cek username exist
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    header("Location: register.php?error=username_taken");
    exit;
}

// insert
$hashed = password_hash($password, PASSWORD_BCRYPT);
$stmt2  = mysqli_prepare($conn, "INSERT INTO users (name, username, password, role) VALUES (?, ?, ?, 'user')");
mysqli_stmt_bind_param($stmt2, "sss", $name, $username, $hashed);
mysqli_stmt_execute($stmt2);

header("Location: register.php?success=1");
exit;