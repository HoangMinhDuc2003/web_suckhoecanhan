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
                <h3 class="text-center mb-4 text-success">Quên Mật Khẩu</h3>

                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['error']) . '</div>';
                    unset($_SESSION['error']);
                }
                ?>

                <form action="../controller/quen_mat_khau_xu_ly.php" method="POST">
                    <div class="mb-4">
                        <label for="taikhoan" class="form-label">Nhập email của bạn</label>
                        <input type="email" class="form-control input-custom" id="taikhoan" name="taikhoan" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Gửi Yêu Cầu</button>
                    </div>

                    <p class="mt-3 text-center">
                        Nhớ lại mật khẩu?
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