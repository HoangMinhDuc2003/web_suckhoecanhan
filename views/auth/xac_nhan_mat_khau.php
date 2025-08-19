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
                <h3 class="text-center mb-4 text-success">Đặt Lại Mật Khẩu</h3>

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

                <form action="../controller/xac_nhan_mat_khau_xu_ly.php" method="POST">
                    <div class="mb-4">
                        <label for="matkhau" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control input-custom" id="matkhau" name="matkhau" required>
                    </div>
                    <div class="mb-4">
                        <label for="xacnhan" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control input-custom" id="xacnhan" name="xacnhan" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Đổi Mật Khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>