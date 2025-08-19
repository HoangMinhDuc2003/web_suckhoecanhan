<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/dang_nhap.php");
    exit();
}
?>

<!-- Main -->
<main>
    <div class="pt-5">
        <div class="container py-5">
            <div class="row">
                <?php
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM nguoidung WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $nguoi_dung = $result->fetch_assoc();
                ?>
                <div class="col-12 mb-4">
                    <div class="text-center">
                        <div class="position-relative d-inline-block">
                            <img src="<?php echo '../../assets/images/nguoidung/' . htmlspecialchars($nguoi_dung['hinh_anh']); ?>"
                                class="rounded-circle profile-pic" alt="Profile Picture">
                            <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h3 class="mt-3 mb-1">
                            <?php echo htmlspecialchars($nguoi_dung['ho_ten']); ?>
                        </h3>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-3 border-end">
                                    <div class="p-4">
                                        <div class="nav flex-column nav-pills">
                                            <a class="nav-link " href="thong_tin_ca_nhan.php"><i
                                                    class="fas fa-user me-2"></i>Thông
                                                Tin Cá Nhân</a>
                                            <a class="nav-link active" href="chinh_sua_thong_tin.php"><i
                                                    class="fas fa-lock me-2"></i>Chỉnh Sửa
                                                Thông Tin</a>
                                            <a class="nav-link" href="../auth/doi_mat_khau.php"><i
                                                    class="fas fa-lock me-2"></i>Đổi Mật
                                                Khẩu</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="p-4">
                                        <div class="mb-4">
                                            <h5 class="mb-4">Chỉnh sửa thông tin cá nhân</h5>
                                            <form action="../controller/chinh_sua_thong_tin_xu_ly.php" method="POST"
                                                enctype="multipart/form-data">
                                                <div class="mb-4">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Họ và tên</label>
                                                            <input type="text" class="form-control" name="ho_ten"
                                                                value="<?php echo htmlspecialchars($nguoi_dung['ho_ten']); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" name="email"
                                                                value="<?php echo htmlspecialchars($nguoi_dung['email']); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Số điện thoại</label>
                                                            <input type="tel" class="form-control" name="so_dien_thoai"
                                                                value="<?php echo htmlspecialchars($nguoi_dung['so_dien_thoai']); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Ngày sinh</label>
                                                            <input type="date" class="form-control" name="ngay_sinh"
                                                                value="<?php echo htmlspecialchars($nguoi_dung['ngay_sinh']); ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Giới tính</label>
                                                            <div>
                                                                <?php $gioi_tinh = $nguoi_dung['gioi_tinh']; ?>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gioi_tinh" value="Nam" <?php if ($gioi_tinh == 'Nam')
                                                                            echo 'checked'; ?>>
                                                                    <label class="form-check-label">Nam</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gioi_tinh" value="Nữ" <?php if ($gioi_tinh == 'Nu')
                                                                            echo 'checked'; ?>>
                                                                    <label class="form-check-label">Nữ</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gioi_tinh" value="Khác" <?php if ($gioi_tinh == 'Khac')
                                                                            echo 'checked'; ?>>
                                                                    <label class="form-check-label">Khác</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Ảnh đại diện</label>
                                                            <input type="file" class="form-control" name="hinh_anh">
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if (isset($_SESSION['success'])): ?>
                                                    <div class="alert alert-success text-center">
                                                        <?= htmlspecialchars($_SESSION['success']); ?>
                                                    </div>
                                                    <?php unset($_SESSION['success']); ?>
                                                <?php endif; ?>
                                                <?php if (isset($_SESSION['error'])): ?>
                                                    <div class="alert alert-danger text-center">
                                                        <?= htmlspecialchars($_SESSION['error']); ?>
                                                    </div>
                                                    <?php unset($_SESSION['error']); ?>
                                                <?php endif; ?>
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary px-4">Lưu thay
                                                        đổi</button>
                                                    <a href="thong_tin_ca_nhan.php"
                                                        class="btn btn-outline-secondary px-4 ms-2">Hủy</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$stmt->close();
$conn->close();
?>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>