<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$taikhoan = trim($_POST['taikhoan'] ?? '');
$matkhau = $_POST['matkhau'] ?? '';

$sql = "SELECT * FROM nguoidung WHERE email = ? OR so_dien_thoai = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $taikhoan, $taikhoan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $hash_db = $user['mat_khau'];
    // Mật khẩu đã được hash
    if (password_verify($matkhau, $hash_db)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ho_ten'] = $user['ho_ten'];
        header("Location: ../../index.php");
        exit();
    }
    // Mật khẩu trong DB là cũ
    if ($matkhau === $hash_db) {
        $hash_new = password_hash($matkhau, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE nguoidung SET mat_khau = ? WHERE id = ?");
        $update->bind_param("si", $hash_new, $user['id']);
        $update->execute();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['ho_ten'] = $user['ho_ten'];
        header("Location: ../../index.php");
        exit();
    }
    // Sai mật khẩu
    $_SESSION['error'] = "Mật khẩu không đúng.";
    header("Location: ../auth/dang_nhap.php");
    exit();
} else {
    $_SESSION['error'] = "Tài khoản không tồn tại.";
    header("Location: ../auth/dang_nhap.php");
    exit();
}

?>