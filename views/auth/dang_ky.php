<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<!-- Main -->
<main>
    <div class="login-background">
        <div class="login-form-container">
            <div class="card">
                <h3 class="text-center mb-4 text-success">ĐĂNG KÝ</h3>
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['error']) . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="../controller/dang_ky_xu_ly.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control input-custom" name="hovaten" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control input-custom" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="tel" pattern="[0-9]{10,11}" class="form-control input-custom" name="sodienthoai"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control input-custom" name="matkhau" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control input-custom" name="xacnhanmatkhau" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Đăng Ký</button>
                    </div>
                    <p class="mt-3 text-center">
                        Đã có tài khoản?
                        <a href="dang_nhap.php" class="link-custom">Đăng nhập ngay</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>