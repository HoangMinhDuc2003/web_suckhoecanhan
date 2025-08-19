<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<!-- Main -->
<main>
    <div class="container my-4 pt-5">
        <!-- Tiêu đề -->
        <?php
        $id_bai_viet = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $sql = "SELECT id, tieu_de, mo_ta, noi_dung, ngay_dang, id_quan_tri_vien, hinh_anh, loai_bai_viet 
                FROM baiviet 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_bai_viet);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $baiviet = $result->fetch_assoc();
            $theLoai = [
                'dinh_duong' => 'Dinh Dưỡng',
                'luyen_tap' => 'Luyện Tập',
                'benh_ly' => 'Bệnh Lý'
            ];

            $tenTheLoai = isset($theLoai[$baiviet['loai_bai_viet']])
                ? $theLoai[$baiviet['loai_bai_viet']]
                : $baiviet['loai_bai_viet'];
        } else {
            echo "<div class='alert alert-warning text-center'>Bài viết không tồn tại</div>";
            exit;
        }
        ?>
        <div class="text-center mb-5">
            <h1 class="text-primary">
                <i class="bi bi-journal-medical me-2"></i>
                <?= htmlspecialchars($baiviet['tieu_de']) ?>
            </h1>
            <p class="text-muted">
                <?= htmlspecialchars($baiviet['mo_ta']) ?>
            </p>
        </div>

        <!-- Chi tiet bai viet-->
        <div class="ctbv-root">
            <div class="ctbv-container">
                <!-- Thông tin-->
                <div class="ctbv-post-meta">
                    <span class="ctbv-post-meta__item">🗓️ Ngày đăng:
                        <?= htmlspecialchars($baiviet['ngay_dang']) ?></span>
                    <span class="ctbv-post-meta__item">📂 Thể loại: <?= htmlspecialchars($tenTheLoai) ?></span>
                </div>

                <!-- Ảnh -->
                <img src="../../assets/images/baiviet/<?= htmlspecialchars($baiviet['hinh_anh']) ?>"
                    alt="Hình ảnh bài viết" class="ctbv-post-image">

                <!-- Nội dung bài viết -->
                <div class="ctbv-post-content">
                    <?= nl2br(htmlspecialchars($baiviet['noi_dung'])) ?>
                </div>

                <!-- Tags -->
                <div class="ctbv-tags">
                    <a href="bai_viet.php?loai=<?= urlencode($baiviet['loai_bai_viet']) ?>" class="ctbv-tag">
                        #<?= htmlspecialchars($baiviet['loai_bai_viet']) ?>
                    </a>
                </div>


                <!-- Hành động -->
                <div class="ctbv-actions">
                    <button class="ctbv-btn" id="shareBtn">🔗 Chia sẻ</button>
                    <script>
                        document.getElementById('shareBtn').addEventListener('click', function () {
                            navigator.clipboard.writeText(window.location.href)
                                .then(() => {
                                    alert('Đã sao chép link bài viết!');
                                })
                                .catch(err => {
                                    console.error('Lỗi sao chép:', err);
                                });
                        });
                    </script>
                    <a href="bai_viet.php" class="ctbv-btn ctbv-btn--outline">⬅️ Quay lại</a>
                </div>
            </div>
        </div>

        <!-- Phần bình luận -->
        <div class="ctbv-comments">
            <h2 id="danh_sach_binh_luan" class="ctbv-comments-title">💬 Bình luận</h2>

            <!-- Form gửi bình luận -->
            <form class="ctbv-comment-form" action="../controller/them_binh_luan.php" method="post">
                <input type="hidden" name="id_bai_viet" value="<?php echo $baiviet['id']; ?>">
                <div class="ctbv-form-group">
                    <label for="name">Tên của bạn:</label>
                    <input type="text" id="name" name="name" placeholder="Nhập tên..." required>
                </div>

                <div class="ctbv-form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email..." required>
                </div>

                <div class="ctbv-form-group">
                    <label for="comment">Nội dung:</label>
                    <textarea id="comment" name="comment" rows="4" placeholder="Viết bình luận..." required></textarea>
                </div>
                <!-- Thông báo -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_SESSION['success']) ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php elseif (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_SESSION['error']) ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                <button type="submit" class="ctbv-btn">Gửi bình luận</button>
            </form>

            <!-- Danh sách bình luận -->
            <div class="ctbv-comment-list">
                <?php
                $id_bai_viet = $baiviet['id'];
                $sql = "SELECT ten, ngay_gio, noi_dung 
                            FROM binhluan 
                            WHERE id_bai_viet = ? 
                            ORDER BY ngay_gio DESC";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id_bai_viet);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="ctbv-comment-item">';
                        echo '<div class="ctbv-comment-author">' . htmlspecialchars($row['ten']) . '</div>';
                        echo '<div class="ctbv-comment-date">' . date("d/m/Y", strtotime($row['ngay_gio'])) . '</div>';
                        echo '<div class="ctbv-comment-content">' . nl2br(htmlspecialchars($row['noi_dung'])) . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-muted">Chưa có bình luận nào.</p>';
                }
                ?>
            </div>

            <!-- Nút điều hướng -->
            <div class="text-center export-buttons pt-5">
                <a href="../../index.php" class="btn btn-warning me-2 export-btn-home"><i class="bi bi-house"></i>
                    Trang
                    chủ</a>
            </div>

        </div>
    </div>
</main>

<?php
// Footer
require_once dirname(__DIR__, 2) . '/includes/footer.php';
?>