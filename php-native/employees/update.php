<?php
require_once __DIR__ . "/../middleware/auth.php";
require_once __DIR__ . "/../config/database.php";

$id      = $_POST['id'] ?? 0;
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($name === '' || $email === '' || $phone === '') {
    header("Location: edit.php?id=$id&error=empty");
    exit;
}

// ambil data lama (untuk foto existing)
$stmt = mysqli_prepare($conn, "SELECT photo FROM employees WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$old       = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$photo_name = $old['photo'] ?? '';

// handle upload foto baru
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $file     = $_FILES['photo'];
    $max_size = 300 * 1024;
    $allowed  = ['image/jpeg', 'image/jpg'];

    if ($file['size'] > $max_size) {
        header("Location: edit.php?id=$id&error=size");
        exit;
    }
    if (!in_array($file['type'], $allowed)) {
        header("Location: edit.php?id=$id&error=format");
        exit;
    }

    // hapus foto lama
    if ($photo_name && file_exists(__DIR__ . "/../uploads/" . $photo_name)) {
        unlink(__DIR__ . "/../uploads/" . $photo_name);
    }

    $ext        = pathinfo($file['name'], PATHINFO_EXTENSION);
    $photo_name = time() . '_' . uniqid() . '.' . $ext;
    $dest       = __DIR__ . "/../uploads/" . $photo_name;
    move_uploaded_file($file['tmp_name'], $dest);
}

$stmt2 = mysqli_prepare($conn, "UPDATE employees SET name=?, email=?, phone=?, address=?, photo=? WHERE id=?");
mysqli_stmt_bind_param($stmt2, "sssssi", $name, $email, $phone, $address, $photo_name, $id);
mysqli_stmt_execute($stmt2);

header("Location: index.php?success=2");
exit;