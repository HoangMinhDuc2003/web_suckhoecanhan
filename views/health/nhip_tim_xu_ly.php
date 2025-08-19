<?php
session_start();
include '../../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nhiptim"])) {
    $bpm = intval($_POST["nhiptim"]);
    $ngay_hom_nay = date("Y-m-d");
    $ketqua = "";

    if ($bpm < 60) {
        $ketqua .= '
            <div class="text-warning">
                ⚠️ <strong>Nhịp tim thấp</strong><br>
                <em>Khuyến cáo:</em> Nghỉ ngơi, uống nước ấm và theo dõi lại. Nếu không cải thiện, hãy liên hệ bác sĩ.
            </div>';
    } elseif ($bpm > 100) {
        $ketqua .= '
            <div class="text-danger">
                ❗ <strong>Nhịp tim cao</strong><br>
                <em>Khuyến cáo:</em> Thư giãn, hít thở sâu. Tránh vận động mạnh, nếu không giảm, hãy đi khám.
            </div>';
    } else {
        $ketqua .= '
            <div class="text-success">
                ✅ <strong>Nhịp tim bình thường</strong><br>
                <em>Khuyến cáo:</em> Duy trì lối sống lành mạnh và theo dõi định kỳ.
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

            $stmt_update = $conn->prepare("UPDATE thongkesuckhoe SET nhip_tim = ? WHERE id = ?");
            $stmt_update->bind_param("ii", $bpm, $id_ban_ghi);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $stmt_insert = $conn->prepare("
                INSERT INTO thongkesuckhoe (id_nguoi_dung, nhip_tim, ngay_ghi_nhan)
                VALUES (?, ?, ?)
            ");
            $stmt_insert->bind_param("iis", $id_nguoi_dung, $bpm, $ngay_hom_nay);
            $stmt_insert->execute();
            $stmt_insert->close();
        }

        $stmt->close();
        $conn->close();
    } else {
        $ketqua .= '
            <div class="mt-2 text-danger">
                🔒 <strong>Bạn chưa đăng nhập!</strong><br>
                Đăng nhập để lưu lại chỉ số và theo dõi sức khỏe của bạn.
            </div>';
    }

    $_SESSION['ketqua_nhiptim'] = $ketqua;
} else {
    $_SESSION['ketqua_nhiptim'] = '<span class="text-danger">Không có dữ liệu gửi!</span>';
}

header("Location: chi_so.php");
exit;
