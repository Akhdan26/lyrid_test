<?php
session_start();
require_once __DIR__ . "/../config/database.php";

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: login.php?error=failed");
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user   = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['user']  = $user;
    header("Location: ../index.php");
    exit;
} else {
    header("Location: login.php?error=failed");
    exit;
}