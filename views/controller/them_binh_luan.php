<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_bai_viet = intval($_POST['id_bai_viet'] ?? 0);
    $ten = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $noi_dung = trim($_POST['comment'] ?? '');
    if ($id_bai_viet > 0 && $ten !== '' && $email !== '' && $noi_dung !== '') {
        $sql = "INSERT INTO binhluan (id_bai_viet, ten, email, noi_dung, ngay_gio) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $id_bai_viet, $ten, $email, $noi_dung);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Gửi bình luận thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
    }
    header("Location: ../article/bai_viet_chi_tiet.php?id=" . $id_bai_viet . "#danh_sach_binh_luan");
    exit();
} else {
    header("Location: ../article/bai_viet_chi_tiet.php?id=" . $id_bai_viet . "#danh_sach_binh_luan");
    exit();
}
?>