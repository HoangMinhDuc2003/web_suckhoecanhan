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
                                            <a class="nav-link active" href="thong_tin_ca_nhan.php"><i
                                                    class="fas fa-user me-2"></i>Thông
                                                Tin Cá Nhân</a>
                                            <a class="nav-link" href="chinh_sua_thong_tin.php"><i
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
                                            <h5 class="mb-4">Thông Tin Cá Nhân</h5>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted">Họ và tên</label>
                                                    <div class="fw-semibold">
                                                        <?php echo htmlspecialchars($nguoi_dung['ho_ten']); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted">Email</label>
                                                    <div class="fw-semibold">
                                                        <?php echo htmlspecialchars($nguoi_dung['email']); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted">Số điện thoại</label>
                                                    <div class="fw-semibold">
                                                        <?php echo htmlspecialchars($nguoi_dung['so_dien_thoai']); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted">Ngày sinh</label>
                                                    <div class="fw-semibold">
                                                        <?php echo htmlspecialchars($nguoi_dung['ngay_sinh']); ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-muted">Giới tính</label>
                                                    <div class="fw-semibold">
                                                        <?php echo htmlspecialchars($nguoi_dung['gioi_tinh']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $sql = "SELECT ngay_ghi_nhan, can_nang, chieu_cao, nhip_tim, duong_huyet, 
                                                            huyet_ap_tam_thu, huyet_ap_tam_truong
                                                        FROM thongkesuckhoe
                                                        WHERE id_nguoi_dung = ?
                                                        ORDER BY ngay_ghi_nhan DESC
                                                        LIMIT 10";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bind_param("i", $user_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            ?>

                                            <div class="col-12 mt-4">
                                                <h5 class="mb-3">Chỉ Số Sức Khỏe Gần Đây</h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Ngày ghi nhận</th>
                                                                <th>Cân nặng (kg)</th>
                                                                <th>Chiều cao (cm)</th>
                                                                <th>BMI</th>
                                                                <th>Huyết áp</th>
                                                                <th>Nhịp tim (bpm)</th>
                                                                <th>Đường huyết (mg/dL)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($row = $result->fetch_assoc()):
                                                                $bmi = 0;
                                                                if (!empty($row['chieu_cao']) && !empty($row['can_nang'])) {
                                                                    $bmi = $row['can_nang'] / pow($row['chieu_cao'] / 100, 2);
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo date("d/m/Y", strtotime($row['ngay_ghi_nhan'])); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['can_nang']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['chieu_cao']); ?>
                                                                    </td>
                                                                    <td><?php echo number_format($bmi, 2); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['huyet_ap_tam_thu']) . '/' . htmlspecialchars($row['huyet_ap_tam_truong']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['nhip_tim']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['duong_huyet']); ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
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