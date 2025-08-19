<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$id_nguoi_dung = $_SESSION['user_id'];

$current_password = $_POST['matkhaucu'] ?? '';
$new_password = $_POST['matkhaumoi'] ?? '';
$confirm_password = $_POST['xacnhanmatkhau'] ?? '';

if ($new_password !== $confirm_password) {
    $_SESSION['error'] = "Mật khẩu mới và xác nhận mật khẩu không trùng khớp.";
    header("Location: ../auth/doi_mat_khau.php");
    exit();
}

$sql = "SELECT mat_khau FROM nguoidung WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_nguoi_dung);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    $_SESSION['error'] = "Không tìm thấy người dùng.";
    header("Location: ../auth/doi_mat_khau.php");
    exit();
}

$db_password = $user['mat_khau'];
$is_hashed = password_get_info($db_password)['algo'] !== 0;
$password_correct = false;
if ($is_hashed) {
    if (password_verify($current_password, $db_password)) {
        $password_correct = true;
    }
} else {
    if ($current_password === $db_password) {
        $password_correct = true;
    }
}

if (!$password_correct) {
    $_SESSION['error'] = "Mật khẩu hiện tại không đúng.";
    header("Location: ../auth/doi_mat_khau.php");
    exit();
}
$hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
$update_sql = "UPDATE NguoiDung SET mat_khau = ? WHERE id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("si", $hashed_new_password, $id_nguoi_dung);

if ($stmt->execute()) {
    $_SESSION['success'] = "Đổi mật khẩu thành công!";
} else {
    $_SESSION['error'] = "Lỗi khi cập nhật mật khẩu.";
}

header("Location: ../auth/doi_mat_khau.php");
exit();
