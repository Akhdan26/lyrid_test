<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id       = $_POST['id'] ?? 0;
$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role     = $_POST['role'] ?? '';

if ($name === '' || $username === '' || $role === '') {
    header("Location: edit.php?id=$id&error=empty");
    exit;
}

// cek username exist kecuali milik sendiri
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ? AND id != ?");
mysqli_stmt_bind_param($stmt, "si", $username, $id);
mysqli_stmt_execute($stmt);
if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    header("Location: edit.php?id=$id&error=username_taken");
    exit;
}

if ($password !== '') {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt2  = mysqli_prepare($conn, "UPDATE users SET name=?, username=?, password=?, role=? WHERE id=?");
    mysqli_stmt_bind_param($stmt2, "ssssi", $name, $username, $hashed, $role, $id);
} else {
    $stmt2 = mysqli_prepare($conn, "UPDATE users SET name=?, username=?, role=? WHERE id=?");
    mysqli_stmt_bind_param($stmt2, "sssi", $name, $username, $role, $id);
}
mysqli_stmt_execute($stmt2);

// update session jika yg diedit dirinya sendiri
if ($id == $_SESSION['user']['id']) {
    $_SESSION['user']['name']  = $name;
    $_SESSION['user']['role']  = $role;
    $_SESSION['user']['username'] = $username;
}

header("Location: index.php?success=2");
exit;