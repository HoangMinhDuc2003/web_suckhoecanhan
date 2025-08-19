<?php
session_start();
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cannang"], $_POST["chieucao"])) {
    $can = floatval($_POST["cannang"]);
    $cao = floatval($_POST["chieucao"]);
    $ngay_hom_nay = date("Y-m-d");
    $ketqua = "";

    if ($cao <= 0) {
        $ketqua = '<div class="text-danger">Chiều cao không hợp lệ!</div>';
    } else {
        $cao_m = $cao / 100;
        $bmi = round($can / ($cao_m * $cao_m), 2);

        if ($bmi < 18.5) {
            $ketqua .= '
            <div class="text-warning">
                ⚠️ <strong>Thiếu cân</strong> (BMI: ' . $bmi . ')<br>
                <em>Khuyến cáo:</em> Tăng cường dinh dưỡng, bổ sung protein, vitamin và tập luyện nhẹ nhàng để tăng cân lành mạnh.
            </div>';
        } elseif ($bmi >= 25) {
            $ketqua .= '
            <div class="text-danger">
                ❗ <strong>Thừa cân</strong> (BMI: ' . $bmi . ')<br>
                <em>Khuyến cáo:</em> Giảm ăn đồ chiên, ngọt, tập thể dục đều đặn, hạn chế rượu bia và ngủ đủ giấc.
            </div>';
        } else {
            $ketqua .= '
            <div class="text-success">
                ✅ <strong>BMI bình thường</strong> (' . $bmi . ')<br>
                <em>Khuyến cáo:</em> Duy trì chế độ ăn uống lành mạnh và tập luyện thường xuyên để giữ chỉ số BMI ổn định.
            </div>';
        }
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
            $stmt_update = $conn->prepare("UPDATE thongkesuckhoe SET bmi = ?, chieu_cao = ?, can_nang = ? WHERE id = ?");
            $stmt_update->bind_param("dddi", $bmi, $cao, $can, $id_ban_ghi);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $stmt_insert = $conn->prepare("
                    INSERT INTO thongkesuckhoe (id_nguoi_dung, bmi, chieu_cao, can_nang, ngay_ghi_nhan)
                    VALUES (?, ?, ?, ?, ?)
                ");
            $stmt_insert->bind_param("iddds", $id_nguoi_dung, $bmi, $cao, $can, $ngay_hom_nay);

            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt->close();
        $conn->close();
    } else {
        $ketqua .= '
            <div class="mt-2 text-danger">
                🔒 <strong>Bạn chưa đăng nhập!</strong><br>
                Đăng nhập để lưu chỉ số BMI và theo dõi sức khỏe.
            </div>';
    }

    $_SESSION['ketqua_BMI'] = $ketqua;
} else {
    $_SESSION['ketqua_BMI'] = '<span class="text-danger">Thiếu dữ liệu BMI!</span>';
}

header("Location: chi_so.php");
exit;
