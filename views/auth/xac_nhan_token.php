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
                <h3 class="text-center mb-4 text-success">Xác Nhận Mã</h3>

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

                <form action="../controller/xac_nhan_token_xu_ly.php" method="POST">
                    <div class="mb-4">
                        <label for="token" class="form-label">Nhập mã xác nhận được gửi qua email</label>
                        <input type="text" class="form-control input-custom" id="token" name="token" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-login">Xác Nhận</button>
                    </div>

                    <p class="mt-3 text-center">
                        Chưa nhận được mã? <a href="quen_mat_khau.php" class="link-custom">Gửi lại yêu cầu</a>
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