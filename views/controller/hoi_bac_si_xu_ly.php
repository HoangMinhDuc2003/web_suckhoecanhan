<?php
require_once dirname(__DIR__, 2) . '/includes/db.php';
session_start();
$ho_ten = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$so_dien_thoai = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$chu_de = isset($_POST['topic']) ? trim($_POST['topic']) : '';
$loai_cau_hoi = 'hoi_bs';
$noi_dung = isset($_POST['question']) ? trim($_POST['question']) : '';
$stmt = $conn->prepare("INSERT INTO cauhoi (ho_ten, email, so_dien_thoai, chu_de, loai_cau_hoi, noi_dung) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $ho_ten, $email, $so_dien_thoai, $chu_de, $loai_cau_hoi, $noi_dung);
if ($stmt->execute()) {
    $_SESSION['success'] = "Gửi câu hỏi thành công. Bạn sẽ sớm nhận được câu trả lời qua gmail!";
} else {
    $_SESSION['error'] = "Lỗi khi gửi câu hỏi: " . $stmt->error;
}
header("Location: ../contact/hoi_bac_si.php");
$stmt->close();
$conn->close();
?>