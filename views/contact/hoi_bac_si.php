<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<!-- Main -->
<main>
    <div class="container py-4" style="max-width: 1200px;">
        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h1 class="text-danger ">
                <i class="bi bi-person-bounding-box me-2"></i>Hỏi Bác Sĩ
            </h1>
            <p class="text-muted">
                Gửi câu hỏi và nhận tư vấn sức khỏe từ bác sĩ chuyên khoa
            </p>
        </div>

        <!-- Hỏi bác sĩ -->
        <div class="my-5 mx-auto" style="max-width: 1200px;">
            <div class="card shadow-sm p-4" style="border-radius: 12px;">
                <h2 class="text-muted  mb-4 text-center">
                    Bạn cần hỏi bác sĩ về vấn đề gì?
                </h2>

                <form class="askDoctorForm" action="../controller/hoi_bac_si_xu_ly.php" method="POST">
                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                        unset($_SESSION['success']);
                    }

                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname"
                            placeholder="Nhập họ tên của bạn" required>
                        <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com"
                            required>
                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            placeholder="Nhập số điện thoại (không bắt buộc)">
                    </div>

                    <div class="ask-form-group mb-3">
                        <label for="topic" class="ask-form-label">Chủ đề câu hỏi</label>
                        <select id="topic" name="topic" class="ask-form-select form-select" required>
                            <option value="">-- Chọn chủ đề --</option>
                            <option value="tong-quat">Sức khỏe tổng quát</option>
                            <option value="dinh-duong">Dinh dưỡng</option>
                            <option value="tam-ly">Tâm lý</option>
                            <option value="san-nhi">Sản - Nhi</option>
                            <option value="da-lieu">Da liễu</option>
                            <option value="benh-thuong-gap">Các bệnh thường gặp</option>
                            <option value="phong-benh">Phòng bệnh & chăm sóc</option>
                            <option value="thuoc">Thuốc & điều trị</option>
                            <option value="tap-luyen">Tập luyện & phục hồi</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="question" class="form-label">Nội dung câu hỏi <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="question" name="question" rows="5"
                            placeholder="Mô tả chi tiết câu hỏi của bạn..." required></textarea>
                        <div class="invalid-feedback">Vui lòng nhập nội dung câu hỏi.</div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">Gửi câu hỏi</button>
                    </div>

                </form>
            </div>


            <!-- Đội ngũ chuyên gia -->
            <section class="mb-5 pt-5">
                <h2 class="mb-4">👨‍⚕️ Đội Ngũ Chuyên Gia</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <img src="../../assets/images/bacsi/bacsi1.jpg" class="card-img-top doctor-image"
                                alt="Dr. Lan">
                            <div class="card-body">
                                <h5 class="card-title">BS. Lan Nguyễn</h5>
                                <p class="card-text">Chuyên gia dinh dưỡng <br> 10 năm kinh nghiệm tư vấn sức khỏe.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <img src="../../assets/images/bacsi/bacsi3.jpg" class="card-img-top doctor-image"
                                alt="Dr. Minh">
                            <div class="card-body">
                                <h5 class="card-title">BS. Minh Trần</h5>
                                <p class="card-text">Bác sĩ nội khoa <br> chuyên theo dõi bệnh mãn tính.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <img src="../../assets/images/bacsi/bacsi2.jpg" class="card-img-top doctor-image"
                                alt="Dr. Trinh">
                            <div class="card-body">
                                <h5 class="card-title">BS. Phương Trinh</h5>
                                <p class="card-text">Bác sĩ tâm lý<br>Hơn 8 năm tư vấn và trị liệu tâm lý chuyên
                                    sâu.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- Nút điều hướng -->
        <div class="text-center export-buttons">
            <a href="../../index.php" class="btn btn-warning me-2 export-btn-home"><i class="bi bi-house"></i> Trang
                chủ</a>
        </div>
    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>