<?php
session_start();
header('Content-Type: application/json');
require_once '../../includes/db.php';

$id_nguoi_dung = $_SESSION['user_id'] ?? 0;

if ($id_nguoi_dung > 0) {
        $stmt = $conn->prepare("SELECT ngay_ghi_nhan, can_nang, chieu_cao, BMI, huyet_ap_tam_thu, huyet_ap_tam_truong, nhip_tim, duong_huyet FROM thongkesuckhoe WHERE id_nguoi_dung = ? ORDER BY ngay_ghi_nhan ASC");
        $stmt->bind_param("i", $id_nguoi_dung);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];

        while ($row = $result->fetch_assoc()) {
                $data[] = $row;
        }

        echo json_encode($data);
} else {
        echo json_encode([]);
}
