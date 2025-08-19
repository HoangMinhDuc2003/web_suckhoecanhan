<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<!-- Main -->
<main>
    <div class="container my-5">

        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h2 class="text-danger"><i class="bi bi-activity text-danger me-1"></i>Chỉ Số Sức Khỏe</h2>
            <p class="text-muted">Theo dõi và phân tích chỉ số theo thời gian</p>
        </div>

        <!-- Nhịp tim & Đường huyết -->
        <div class="row khung-suckhoe">
            <!-- Nhịp tim -->
            <div class="col-md-6 pt-4 d-flex">
                <div class="card shadow-sm w-100 d-flex flex-column card-nhiptim">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><i class="bi bi-heart-pulse text-danger me-2"></i> Nhập Nhịp Tim
                            </h5>
                            <form method="POST" action="nhip_tim_xu_ly.php">
                                <div class="mb-3">
                                    <label class="form-label">Nhịp tim (bpm)</label>
                                    <input type="number" name="nhiptim" class="form-control" required
                                        placeholder="Nhập nhịp tim">
                                </div>
                                <button type="submit" class="btn btn-danger btn-tinh-luu">
                                    <i class="bi bi-plus-circle"></i> Tính & Lưu
                                </button>
                            </form>
                        </div>
                        <?php if (isset($_SESSION['ketqua_nhiptim'])): ?>
                            <div class="mt-3 fw-bold">
                                <?= $_SESSION['ketqua_nhiptim']; ?>
                            </div>
                            <?php unset($_SESSION['ketqua_nhiptim']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Đường huyết -->
            <div class="col-md-6 pt-4 d-flex">
                <div class="card shadow-sm w-100 d-flex flex-column card-duonghuyet">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><i class="bi bi-droplet-half text-primary me-2"></i> Nhập Đường
                                Huyết</h5>
                            <form method="POST" action="xu_ly_duong_huyet.php">
                                <div class="mb-3">
                                    <label class="form-label">Đường huyết (mg/dL)</label>
                                    <input type="number" name="duonghuyet" class="form-control" required
                                        placeholder="Nhập đường huyết">
                                </div>
                                <button type="submit" class="btn btn-danger btn-tinh-luu">
                                    <i class="bi bi-plus-circle"></i> Tính & Lưu
                                </button>
                            </form>
                        </div>
                        <?php if (isset($_SESSION['ketqua_duonghuyet'])): ?>
                            <div class="mt-3 fw-bold">
                                <?= $_SESSION['ketqua_duonghuyet']; ?>
                            </div>
                            <?php unset($_SESSION['ketqua_duonghuyet']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMI & Huyết áp -->
        <div class="row mb-4 khung-suckhoe">
            <!-- BMI -->
            <div class="col-md-6 pt-4 d-flex">
                <div class="card shadow-sm w-100 d-flex flex-column card-bmi">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"> <i class="bi bi-body-text text-success me-2"></i> Tính Chỉ Số
                                BMI</h5>
                            <form method="POST" action="xu_ly_bmi.php">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Cân nặng (kg)</label>
                                        <input type="number" step="0.1" name="cannang" class="form-control"
                                            placeholder="Nhập cân nặng" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Chiều cao (cm)</label>
                                        <input type="number" step="0.1" name="chieucao" class="form-control"
                                            placeholder="Nhập chiều cao" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-danger mt-3 btn-tinh-luu">
                                    <i class="bi bi-plus-circle"></i> Tính & Lưu
                                </button>
                            </form>
                        </div>
                        <?php if (isset($_SESSION['ketqua_BMI'])): ?>
                            <div class="mt-3 fw-bold">
                                <?= $_SESSION['ketqua_BMI']; ?>
                            </div>
                            <?php unset($_SESSION['ketqua_BMI']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Huyết áp -->
            <div class="col-md-6 pt-4 d-flex">
                <div class="card shadow-sm w-100 d-flex flex-column card-huyetap">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title"><i class="bi bi-activity text-warning me-2"></i> Nhập Huyết Áp
                            </h5>
                            <form method="POST" action="huyet_ap_xu_ly.php">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Tâm thu (mmHg)</label>
                                        <input type="number" name="tamthu" class="form-control" placeholder="VD: 120"
                                            required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Tâm trương (mmHg)</label>
                                        <input type="number" name="tamtruong" class="form-control" placeholder="VD: 80"
                                            required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-danger mt-3 btn-tinh-luu   ">
                                    <i class="bi bi-plus-circle"></i> Tính & Lưu
                                </button>
                            </form>
                        </div>
                        <?php if (isset($_SESSION['ketqua_huyetap'])): ?>
                            <div class="mt-3 fw-bold">
                                <?= $_SESSION['ketqua_huyetap']; ?>
                            </div>
                            <?php unset($_SESSION['ketqua_huyetap']); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống Kê Sức Khỏe -->
        <div id="thongke-suckhoe" class="text-center mb-5 pt-5">
            <h2 class="text-danger"><i class="bi bi-heart-fill text-danger me-1"></i> Thống Kê Sức Khỏe</h2>
            <p class="text-muted"> Thống kê chỉ số theo thời gian</p>
            <?php
            if (!$isLoggedIn) {
                echo '<div class="alert alert-warning text-center" role="alert">';
                echo 'Hãy đăng nhập để xem chỉ số của bạn.';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Biểu đồ -->
        <div class="card bieu-do-card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title text-success">
                    <i class="bi bi-graph-up me-2 icon-bieu-do"></i>
                    Biểu Đồ Sức Khỏe
                </h5>
                <canvas id="bieuDoNhipTim" height="100" class="canvas-bieu-do"></canvas>
                <canvas id="bieuDoDuongHuyet" height="100" class="canvas-bieu-do mt-4"></canvas>
                <canvas id="bieuDoHuyetAp" height="100" class="canvas-bieu-do mt-4"></canvas>
                <canvas id="bieuDoBMI" height="100" class="canvas-bieu-do mt-4"></canvas>
            </div>
        </div>

        <!-- Thống kê nhanh -->
        <?php
        $id_nguoi_dung = $_SESSION['user_id'] ?? null;
        $trungBinh = $thapNhat = $caoNhat = 0;
        if ($id_nguoi_dung) {
            $sql = "SELECT 
                ROUND(AVG(nhip_tim), 1) AS tb,
                MIN(nhip_tim) AS min,
                MAX(nhip_tim) AS max
            FROM thongkesuckhoe
            WHERE id_nguoi_dung = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_nguoi_dung);
            $stmt->execute();
            $stmt->bind_result($tb, $min, $max);
            if ($stmt->fetch()) {
                $trungBinh = $tb;
                $thapNhat = $min;
                $caoNhat = $max;
            }
            $stmt->close();
        }
        ?>
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="alert alert-success text-center hover-box">
                    <strong>Trung bình:</strong> <?= $trungBinh ?> bpm
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-primary text-center hover-box">
                    <strong>Thấp nhất:</strong> <?= $thapNhat ?> bpm
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger text-center hover-box">
                    <strong>Cao nhất:</strong> <?= $caoNhat ?> bpm
                </div>
            </div>
        </div>
        <div class="cs-container">
            <div class="cs-box">
                <div class="cs-header">
                    <h1>4 Chỉ Số Sức Khỏe Quan Trọng Của Con Người</h1>
                </div>
                <div class="cs-content">

                    <div class="cs-section">
                        <h2>1. Đường huyết</h2>
                        <p>
                            Đường huyết là lượng glucose có trong máu – nguồn năng lượng chính của cơ thể. Chỉ số
                            đường huyết bình thường khi đói nằm trong khoảng 70–99 mg/dL. Mức đường huyết cao có thể
                            là dấu hiệu của tiểu đường, còn thấp quá lại gây ra các triệu chứng như mệt mỏi, run
                            rẩy, đổ mồ hôi.
                        </p>
                    </div>

                    <div class="cs-section">
                        <h2>2. Huyết áp</h2>
                        <p>
                            Huyết áp là lực tác động của dòng máu lên thành động mạch khi tim bơm máu. Chỉ số huyết
                            áp tối ưu là khoảng 120/80 mmHg. Huyết áp cao có thể dẫn đến đột quỵ, suy tim, còn huyết
                            áp thấp có thể khiến bạn chóng mặt, khó tập trung hoặc ngất.
                        </p>
                    </div>

                    <div class="cs-section">
                        <h2>3. BMI (Chỉ số khối cơ thể)</h2>
                        <p>
                            BMI = Cân nặng (kg) chia cho bình phương chiều cao (m). BMI từ 18.5–24.9 là bình thường.
                            Dưới 18.5 là thiếu cân, 25–29.9 là thừa cân, từ 30 trở lên là béo phì. BMI giúp đánh giá
                            nguy cơ mắc các bệnh tim mạch, tiểu đường và nhiều bệnh khác.
                        </p>
                    </div>

                    <div class="cs-section">
                        <h2>4. Nhịp tim</h2>
                        <p>
                            Nhịp tim là số lần tim đập trong một phút. Nhịp tim nghỉ ngơi bình thường ở người lớn từ
                            60 đến 100 lần/phút. Nhịp tim quá nhanh hoặc quá chậm có thể báo hiệu bệnh lý tim mạch
                            hoặc phản ứng với thuốc, tâm lý căng thẳng.
                        </p>
                    </div>

                    <div class="cs-footer">
                        © 2025 - Thông tin mang tính tham khảo, không thay thế ý kiến chuyên gia y tế.
                    </div>
                </div>
            </div>
        </div>

        <!-- Nút điều hướng -->
        <div class="text-center export-buttons pt-5">
            <a href="../../index.php" class="btn btn-warning me-2 export-btn-home"><i class="bi bi-house"></i> Trang
                chủ</a>
        </div>
    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>