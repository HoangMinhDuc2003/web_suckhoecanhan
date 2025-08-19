<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$token = trim($_POST['token'] ?? '');

$sql = "SELECT id FROM nguoidung WHERE reset_token = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $update = $conn->prepare("UPDATE nguoidung SET reset_token = NULL WHERE id = ?");
    $update->bind_param("i", $user['id']);
    $update->execute();

    $_SESSION['success'] = "Xác nhận thành công. Vui lòng nhập mật khẩu mới.";
    header("Location: ../auth/xac_nhan_mat_khau.php");
    exit();
} else {
    $_SESSION['error'] = "Mã xác nhận không đúng.";
    header("Location: ../auth/xac_nhan_token.php");
    exit();
}
?>