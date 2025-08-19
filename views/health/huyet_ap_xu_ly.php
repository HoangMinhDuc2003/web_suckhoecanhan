<?php
session_start();
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tamthu"], $_POST["tamtruong"])) {
    $tamthu = intval($_POST["tamthu"]);
    $tamtruong = intval($_POST["tamtruong"]);
    $ngay_hom_nay = date("Y-m-d");
    $ketqua = "";

    if ($tamthu < 90 || $tamtruong < 60) {
        $ketqua .= '
            <div class="text-warning">
                ⚠️ <strong>Huyết áp thấp</strong><br>
                <em>Khuyến cáo:</em> Nghỉ ngơi, uống nước và ăn nhẹ. Nếu không cải thiện, hãy đi khám.
            </div>';
    } elseif ($tamthu > 140 || $tamtruong > 90) {
        $ketqua .= '
            <div class="text-danger">
                ❗ <strong>Huyết áp cao</strong><br>
                <em>Khuyến cáo:</em> Thư giãn, tránh căng thẳng. Hạn chế muối và mỡ. Thăm khám bác sĩ nếu kéo dài.
            </div>';
    } else {
        $ketqua .= '
            <div class="text-success">
                ✅ <strong>Huyết áp bình thường</strong><br>
                <em>Khuyến cáo:</em> Duy trì chế độ ăn uống và luyện tập lành mạnh.
            </div>';
    }

    if (isset($_SESSION['user_id'])) {
        $id_nguoi_dung = $_SESSION['user_id'];

        $stmt = $conn->prepare("SELECT id FROM thongkesuckhoe WHERE id_nguoi_dung = ? AND ngay_ghi_nhan = ?");
        $stmt->bind_param("is", $id_nguoi_dung, $ngay_hom_nay);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id_ban_ghi);
            $stmt->fetch();

            $stmt_update = $conn->prepare("UPDATE thongkesuckhoe SET huyet_ap_tam_thu = ?, huyet_ap_tam_truong = ? WHERE id = ?");
            $stmt_update->bind_param("iii", $tamthu, $tamtruong, $id_ban_ghi);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $stmt_insert = $conn->prepare("
                INSERT INTO thongkesuckhoe (id_nguoi_dung, huyet_ap_tam_thu, huyet_ap_tam_truong, ngay_ghi_nhan)
                VALUES (?, ?, ?, ?)
            ");
            $stmt_insert->bind_param("iiis", $id_nguoi_dung, $tamthu, $tamtruong, $ngay_hom_nay);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt->close();
        $conn->close();
    } else {
        $ketqua .= '
            <div class="mt-2 text-danger">
                🔒 <strong>Bạn chưa đăng nhập!</strong><br>
                Đăng nhập để lưu chỉ số huyết áp và theo dõi sức khỏe.
            </div>';
    }

    $_SESSION['ketqua_huyetap'] = $ketqua;
} else {
    $_SESSION['ketqua_huyetap'] = '<span class="text-danger">Thiếu dữ liệu huyết áp!</span>';
}

header("Location: chi_so.php");
exit;
