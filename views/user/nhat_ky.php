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
    <div class="container health-log-container pt-5 pb-4">
        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h1 class="text-primary"><i class="bi bi-journal-medical me-2"></i>Nhật Ký Sức Khỏe</h1>
            <p class="text-muted">Giúp bạn theo dõi và ghi lại các chỉ số sức khỏe hàng ngày</p>
        </div>

        <!-- Bộ lọc ngày -->
        <div class="form-filter-date">
            <form id="loc-form" class="row g-3 mb-0" method="GET" action="#loc-form">
                <div class="col-md-5">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" name="tu_ngay" value="<?= $_GET['tu_ngay'] ?? '' ?>">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" name="den_ngay" value="<?= $_GET['den_ngay'] ?? '' ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-outline-danger w-100 btn-tinh-luu text-light">
                        <i class="bi bi-filter-circle"></i> Lọc
                    </button>
                </div>
            </form>
        </div>


        <!-- Hiển thị thông báo nếu có -->
        <div class="container mt-3">
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success text-center" role="alert">';
                echo htmlspecialchars($_SESSION['success']);
                echo '</div>';
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger text-center" role="alert">';
                echo htmlspecialchars($_SESSION['error']);
                echo '</div>';
                unset($_SESSION['error']);
            }
            ?>
        </div>

        <!-- Bảng dữ liệu -->
        <div class="card shadow-sm mb-4 mt-4 bang-suc-khoe">
            <div class="card-body">
                <h5 class="card-title">Dữ liệu gần đây</h5>
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Ngày</th>
                            <th>Nhịp tim</th>
                            <th>Huyết áp</th>
                            <th>Đường huyết</th>
                            <th>BMI</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_nguoi_dung = $_SESSION['user_id'] ?? null;
                        if ($id_nguoi_dung) {
                            $tu_ngay = $_GET['tu_ngay'] ?? '';
                            $den_ngay = $_GET['den_ngay'] ?? '';

                            $sql = "SELECT * FROM thongkesuckhoe WHERE id_nguoi_dung = ?";
                            $params = [$id_nguoi_dung];
                            $types = "i";
                            if ($tu_ngay && $den_ngay) {
                                $sql .= " AND ngay_ghi_nhan BETWEEN ? AND ?";
                                $params[] = $tu_ngay;
                                $params[] = $den_ngay;
                                $types .= "ss";
                            }
                            $sql .= " ORDER BY ngay_ghi_nhan DESC";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param($types, ...$params);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $ngay = date("d/m/Y", strtotime($row['ngay_ghi_nhan']));
                                $nhipTim = $row['nhip_tim'];
                                $huyetAp = $row['huyet_ap_tam_thu'] . '/' . $row['huyet_ap_tam_truong'];
                                $duongHuyet = $row['duong_huyet'];
                                $bmi = $row['BMI'];
                                echo "<tr>
                                <td>$ngay</td>
                                <td>{$nhipTim} bpm</td>
                                <td>{$huyetAp} mmHg</td>
                                <td>{$duongHuyet} mg/dL</td>
                                <td>{$bmi}</td>
                                <td>
                                    <a href='../controller/xoa_chi_so.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Bạn muốn xóa chỉ số này?\")'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                              </tr>";
                            }
                            $stmt->close();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Nút điều hướng -->
        <div class="text-center export-buttons">
            <a href="../../index.php" class="btn btn-warning me-2 export-btn-home"><i class="bi bi-house"></i>
                Trang
                chủ</a>
            <a href="../controller/xuat_file.php?tu_ngay=<?= $_GET['tu_ngay'] ?? '' ?>&den_ngay=<?= $_GET['den_ngay'] ?? '' ?>"
                class="btn btn-outline-success export-btn-excel">
                <i class="bi bi-file-earmark-excel"></i> Xuất Excel
            </a>
        </div>
    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>