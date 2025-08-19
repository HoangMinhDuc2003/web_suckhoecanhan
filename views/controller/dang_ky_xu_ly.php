<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$ho_ten = trim($_POST['hovaten'] ?? '');
$email = trim($_POST['email'] ?? '');
$so_dien_thoai = trim($_POST['sodienthoai'] ?? '');
$mat_khau = $_POST['matkhau'] ?? '';
$xac_nhan = $_POST['xacnhanmatkhau'] ?? '';

if ($mat_khau !== $xac_nhan) {
    $_SESSION['error'] = "Mật khẩu xác nhận không khớp.";
    header("Location: ../auth/dang_ky.php");
    exit();
}

$sql_check = "SELECT id FROM nguoidung WHERE email = ? OR so_dien_thoai = ? LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ss", $email, $so_dien_thoai);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = "Email hoặc số điện thoại đã tồn tại.";
    header("Location: ../auth/dang_ky.php");
    exit();
}

$hash = password_hash($mat_khau, PASSWORD_DEFAULT);
$hinh_anh_mac_dinh = "default_avatar.png";

$sql_insert = "INSERT INTO nguoidung (ho_ten, email, so_dien_thoai, mat_khau, hinh_anh) VALUES (?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("sssss", $ho_ten, $email, $so_dien_thoai, $hash, $hinh_anh_mac_dinh);

if ($stmt_insert->execute()) {
    $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
    header("Location: ../auth/dang_nhap.php");
    exit();
} else {
    $_SESSION['error'] = "Đã xảy ra lỗi. Vui lòng thử lại.";
    header("Location: ../auth/dang_ky.php");
    exit();
}
?>