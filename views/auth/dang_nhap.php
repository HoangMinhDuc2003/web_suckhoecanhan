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
                <h3 class="text-center mb-4 text-success">ĐĂNG NHẬP</h3>
                <?php
                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success text-center">' . htmlspecialchars($_SESSION['success']) . '</div>';
                    unset($_SESSION['success']);
                }
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['error']) . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="../controller/dang_nhap_xu_ly.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email hoặc số điện thoại</label>
                        <input type="text" class="form-control input-custom" name="taikhoan" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control input-custom" name="matkhau" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Đăng Nhập</button>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="quen_mat_khau.php" class="link-custom">Quên mật khẩu?</a>
                    </div>
                    <p class="mt-3 text-center">
                        Chưa có tài khoản?
                        <a href="dang_ky.php" class="link-custom">Đăng ký ngay</a>
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