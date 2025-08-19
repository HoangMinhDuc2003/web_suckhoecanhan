<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';
$id_nguoi_dung = $_SESSION['user_id'];
$ho_ten = trim($_POST['ho_ten'] ?? '');
$email = trim($_POST['email'] ?? '');
$so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
$ngay_sinh = trim($_POST['ngay_sinh'] ?? '');
$gioi_tinh = trim($_POST['gioi_tinh'] ?? '');
$hinh_anh = "";
$sql_old = "SELECT hinh_anh FROM nguoidung WHERE id = ?";
$stmt_old = $conn->prepare($sql_old);
$stmt_old->bind_param("i", $id_nguoi_dung);
$stmt_old->execute();
$result_old = $stmt_old->get_result();
$row_old = $result_old->fetch_assoc();
$hinh_anh_cu = $row_old['hinh_anh'] ?? '';
$stmt_old->close();

if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['hinh_anh']['tmp_name'];
    $file_name = time() . "_" . basename($_FILES['hinh_anh']['name']);
    $file_size = $_FILES['hinh_anh']['size'];
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_type, $allowed_types)) {
        $_SESSION['error'] = "Chỉ chấp nhận file JPG, JPEG, PNG, GIF.";
        header("Location: ../user/chinh_sua_thong_tin.php");
        exit();
    }
    if ($file_size > 2 * 1024 * 1024) {
        $_SESSION['error'] = "Dung lượng ảnh tối đa 2MB.";
        header("Location: ../user/chinh_sua_thong_tin.php");
        exit();
    }

    $upload_dir = "../../assets/images/nguoidung/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file_tmp, $upload_dir . $file_name)) {
        $hinh_anh = $file_name;
        if (!empty($hinh_anh_cu) && $hinh_anh_cu !== 'default_avatar.png' && file_exists($upload_dir . $hinh_anh_cu)) {
            unlink($upload_dir . $hinh_anh_cu);
        }
    } else {
        $_SESSION['error'] = "Không thể tải ảnh lên.";
        header("Location: ../user/chinh_sua_thong_tin.php");
        exit();
    }
} else {
    $hinh_anh = $hinh_anh_cu;
}



$sql_update = "UPDATE nguoidung 
               SET ho_ten = ?, email = ?, so_dien_thoai = ?, ngay_sinh = ?, gioi_tinh = ?, hinh_anh = ?
               WHERE id = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("ssssssi", $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $hinh_anh, $id_nguoi_dung);

if ($stmt->execute()) {
    $_SESSION['success'] = "Cập nhật thông tin thành công!";
} else {
    $_SESSION['error'] = "Lỗi khi cập nhật thông tin.";
}

$stmt->close();
$conn->close();

header("Location: ../user/chinh_sua_thong_tin.php");
exit();
?>