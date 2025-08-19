<?php
session_start();
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["duonghuyet"])) {
    $duonghuyet = floatval($_POST["duonghuyet"]);
    $ngay_hom_nay = date("Y-m-d");
    $ketqua = "";

    if ($duonghuyet < 70) {
        $ketqua .= '
            <div class="text-warning">
                ⚠️ <strong>Hạ đường huyết</strong><br>
                <em>Khuyến cáo:</em> Uống nước đường hoặc ăn nhẹ. Nếu không cải thiện, cần khám bác sĩ.
            </div>';
    } elseif ($duonghuyet > 140) {
        $ketqua .= '
            <div class="text-danger">
                ❗ <strong>Tăng đường huyết</strong><br>
                <em>Khuyến cáo:</em> Kiểm soát ăn uống, tập thể dục và theo dõi lại sau ăn.
            </div>';
    } else {
        $ketqua .= '
            <div class="text-success">
                ✅ <strong>Đường huyết bình thường</strong><br>
                <em>Khuyến cáo:</em> Tiếp tục duy trì lối sống khoa học.
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

            $stmt_update = $conn->prepare("UPDATE thongkesuckhoe SET duong_huyet = ? WHERE id = ?");
            $stmt_update->bind_param("di", $duonghuyet, $id_ban_ghi);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $stmt_insert = $conn->prepare("
                INSERT INTO thongkesuckhoe (id_nguoi_dung, duong_huyet, ngay_ghi_nhan)
                VALUES (?, ?, ?)
            ");
            $stmt_insert->bind_param("ids", $id_nguoi_dung, $duonghuyet, $ngay_hom_nay);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt->close();
        $conn->close();
    } else {
        $ketqua .= '
            <div class="mt-2 text-danger">
                🔒 <strong>Bạn chưa đăng nhập!</strong><br>
                Đăng nhập để lưu lại chỉ số đường huyết.
            </div>';
    }

    $_SESSION['ketqua_duonghuyet'] = $ketqua;
} else {
    $_SESSION['ketqua_duonghuyet'] = '<span class="text-danger">Không có dữ liệu đường huyết!</span>';
}

header("Location: chi_so.php");
exit;
