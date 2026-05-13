<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($name === '' || $email === '' || $phone === '') {
    header("Location: create.php?error=empty");
    exit;
}

$photo_name = '';

// handle upload foto
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $file      = $_FILES['photo'];
    $max_size  = 300 * 1024; // 300KB
    $allowed   = ['image/jpeg', 'image/jpg'];

    if ($file['size'] > $max_size) {
        header("Location: create.php?error=size");
        exit;
    }
    if (!in_array($file['type'], $allowed)) {
        header("Location: create.php?error=format");
        exit;
    }

    $ext        = pathinfo($file['name'], PATHINFO_EXTENSION);
    $photo_name = time() . '_' . uniqid() . '.' . $ext;
    $dest       = __DIR__ . "/../uploads/" . $photo_name;

    move_uploaded_file($file['tmp_name'], $dest);
}

$stmt = mysqli_prepare($conn, "INSERT INTO employees (name, email, phone, address, photo) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $phone, $address, $photo_name);
mysqli_stmt_execute($stmt);

header("Location: index.php?success=1");
exit;