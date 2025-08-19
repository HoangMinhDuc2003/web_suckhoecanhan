<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM thongkesuckhoe WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $_SESSION['success'] = "Đã xóa chỉ số thành công.";
        } else {
            $_SESSION['error'] = "Không tìm thấy bản ghi cần xóa.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "⚠️ Lỗi truy vấn cơ sở dữ liệu.";
    }
} else {
    $_SESSION['error'] = "⚠️ Thiếu ID để xóa.";
}

$conn->close();
header("Location: ../user/nhat_ky.php");
exit;
?>