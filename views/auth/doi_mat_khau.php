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
                                            <a class="nav-link" href="../user/thong_tin_ca_nhan.php"><i
                                                    class="fas fa-user me-2"></i>Thông Tin Cá Nhân</a>
                                            <a class="nav-link" href="../user/chinh_sua_thong_tin.php"><i
                                                    class="fas fa-edit me-2"></i>Chỉnh Sửa Thông Tin</a>
                                            <a class="nav-link active" href="doi_mat_khau.php"><i
                                                    class="fas fa-lock me-2"></i>Đổi Mật Khẩu</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="p-4">
                                        <h5 class="mb-4">Đổi Mật Khẩu</h5>
                                        <form action="../controller/doi_mat_khau_xu_ly.php" method="POST">
                                            <div class="row g-3 pb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Mật khẩu hiện tại</label>
                                                    <input type="password" class="form-control" name="matkhaucu"
                                                        required>
                                                </div>
                                                <div class="col-md-6"></div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Mật khẩu mới</label>
                                                    <input type="password" class="form-control" name="matkhaumoi"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                                    <input type="password" class="form-control" name="xacnhanmatkhau"
                                                        required>
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
                                            <div class="text-end mt-4">
                                                <button type="submit" class="btn btn-primary px-4">Lưu thay
                                                    đổi</button>
                                                <a href="../user/thong_tin_ca_nhan.php"
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
</main>
<?php
$stmt->close();
$conn->close();
?>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>