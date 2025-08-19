<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$email = $_SESSION['reset_email'];
$matkhau = $_POST['matkhau'] ?? '';
$xacnhan = $_POST['xacnhan'] ?? '';

if ($matkhau !== $xacnhan) {
    $_SESSION['error'] = "Mật khẩu xác nhận không khớp.";
    header("Location: ../auth/xac_nhan_mat_khau.php");
    exit();
}

$hash = password_hash($matkhau, PASSWORD_DEFAULT);

$sql = "UPDATE nguoidung SET mat_khau = ? WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hash, $email);

if ($stmt->execute()) {
    unset($_SESSION['reset_email']);
    $_SESSION['success'] = "Mật khẩu đã được cập nhật. Bạn có thể đăng nhập.";
    header("Location: ../auth/dang_nhap.php");
    exit();
} else {
    $_SESSION['error'] = "Đã xảy ra lỗi. Vui lòng thử lại.";
    header("Location: ../auth/doi_mat_khau.php");
    exit();
}
?>