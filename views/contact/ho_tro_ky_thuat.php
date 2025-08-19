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
            <h1 class="text-warning">
                <i class="bi bi-tools me-2"></i>Hỗ Trợ & Góp Ý
            </h1>
            <p class="text-muted">
                Giúp bạn giải đáp các vấn đề kỹ thuật liên quan đến website và ứng dụng hoặc gửi các góp ý về cho
                đội ngũ của chúng tôi
            </p>
        </div>

        <!-- Form hỗ trợ -->
        <div class="my-5 mx-auto" style="max-width: 1200px;">
            <div class="card shadow-sm p-4" style="border-radius: 12px;">

                <h2 class="text-muted mb-4 text-center">
                    Hãy góp ý và gửi yêu cầu hỗ trợ của bạn
                </h2>

                <form class="askDoctorForm" action="../controller/ho_tro_xu_ly.php" method="POST">
                    <!-- Hiển thị thông báo -->
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
                    <div class="mb-3">
                        <label for="topic" class="form-label">Chủ đề hỗ trợ <span class="text-danger">*</span></label>
                        <select class="form-select" id="topic" name="topic" required>
                            <option value="">-- Chọn chủ đề --</option>
                            <option value="dang_nhap">Vấn đề đăng nhập</option>
                            <option value="loi_he_thong">Lỗi hệ thống</option>
                            <option value="tu_van">Tư vấn sử dụng</option>
                            <option value="khac">Khác</option>
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn chủ đề.</div>
                    </div>

                    <!-- Nội dung -->
                    <div class="mb-3">
                        <label for="question" class="form-label">Nội dung yêu cầu <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="question" name="question" rows="5"
                            placeholder="Mô tả vấn đề của bạn..." required></textarea>
                        <div class="invalid-feedback">Vui lòng nhập nội dung yêu cầu.</div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">Gửi yêu cầu</button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Nút điều hướng -->
        <div class="text-center export-buttons">
            <a href="../../index.php" class="btn btn-warning me-2 export-btn-home">
                <i class="bi bi-house"></i> Trang chủ
            </a>
        </div>

    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>