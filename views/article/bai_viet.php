<?php
require_once dirname(__DIR__, 2) . '/config.php';
require_once dirname(__DIR__, 2) . '/includes/db.php';

// Header
require_once dirname(__DIR__, 2) . '/includes/header.php';
?>

<!-- Main -->
<?php
$limit = 7;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$loai = isset($_GET['loai']) ? trim($_GET['loai']) : '';
$keyword_param = "%" . $keyword . "%";
$count_sql = "SELECT COUNT(*) AS total FROM baiviet WHERE 1=1";
$params = [];
$types = "";
if (!empty($loai)) {
    $count_sql .= " AND loai_bai_viet = ?";
    $params[] = $loai;
    $types .= "s";
}
if (!empty($keyword)) {
    $count_sql .= " AND tieu_de LIKE ?";
    $params[] = $keyword_param;
    $types .= "s";
}
$stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$total_records = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();
$total_pages = ceil($total_records / $limit);
$sql = "SELECT id, tieu_de, mo_ta, ngay_dang, hinh_anh, loai_bai_viet 
        FROM baiviet 
        WHERE 1=1";
$params = [];
$types = "";
if (!empty($loai)) {
    $sql .= " AND loai_bai_viet = ?";
    $params[] = $loai;
    $types .= "s";
}
if (!empty($keyword)) {
    $sql .= " AND tieu_de LIKE ?";
    $params[] = $keyword_param;
    $types .= "s";
}
$sql .= " ORDER BY ngay_dang DESC LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$types .= "ii";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<main>
    <div class="container my-4 pt-5">
        <!-- Tiêu đề -->
        <div class="text-center mb-5">
            <h1 class="text-primary">
                <i class="bi bi-journal-medical me-2"></i>Cẩm Nang Sức Khỏe
            </h1>
            <p class="text-muted">
                Cập nhật những kiến thức y khoa và lời khuyên hữu ích giúp bạn duy trì một lối sống lành mạnh
            </p>
        </div>

        <!-- Form tìm kiếm -->
        <form class="bv-search-form mb-4" action="bai_viet.php" method="GET">
            <div class="input-group">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm bài viết..."
                    value="<?= htmlspecialchars($keyword) ?>">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
            </div>
        </form>

        <!--Loại-->
        <h2 class="mb-4 text-center text-primary fw-bold border-bottom pb-2">
            <?php
            if ($loai == 'dinh_duong')
                echo 'Bài viết về Dinh dưỡng';
            elseif ($loai == 'benh_ly')
                echo 'Bài viết về Bệnh lý';
            elseif ($loai == 'luyen_tap')
                echo 'Bài viết về Luyện tập';
            ?>
        </h2>

        <!-- Danh sách bài viết -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="row mb-4 align-items-center shadow-sm rounded p-3 bv-item overflow-hidden">
                    <div class="col-md-4 p-0">
                        <img src="../../assets/images/baiviet/<?= htmlspecialchars($row['hinh_anh']) ?>"
                            class="img-fluid rounded bv-thumbnail blog-thumbnail" alt="Ảnh bài viết">
                    </div>
                    <div class="col-md-8 p-3">
                        <h5 class="mb-2 bv-item-title"><?= htmlspecialchars($row['tieu_de']) ?></h5>
                        <div class="mb-2 bv-meta">
                            <strong style="color: red;">DucMyHealthNew</strong>
                            &nbsp; <?= date("d/m/Y", strtotime($row['ngay_dang'])) ?>
                        </div>
                        <p class="mb-2 bv-item-desc"><?= htmlspecialchars($row['mo_ta']) ?></p>
                        <a href="bai_viet_chi_tiet.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary bv-btn">Đọc
                            thêm</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">Không có bài viết nào.</p>
        <?php endif; ?>

        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
            <?php
            $max_links = 7;
            $start = max(1, $page - floor($max_links / 2));
            $end = min($total_pages, $start + $max_links - 1);

            if ($end - $start < $max_links - 1) {
                $start = max(1, $end - $max_links + 1);
            }
            ?>
            <nav class="blog-pagination mt-5">
                <ul class="pagination justify-content-center">
                    <!-- Nút « -->
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&page=<?= max(1, $page - 1) ?>">«</a>
                    </li>

                    <!-- Trang đầu -->
                    <?php if ($start > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&page=1">1</a>
                        </li>
                        <?php if ($start > 2): ?>
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Các trang giữa -->
                    <?php for ($i = $start; $i <= $end; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?keyword=<?= urlencode($keyword) ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Trang cuối -->
                    <?php if ($end < $total_pages): ?>
                        <?php if ($end < $total_pages - 1): ?>
                            <li class="page-item disabled"><a class="page-link">...</a></li>
                        <?php endif; ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="?keyword=<?= urlencode($keyword) ?>&page=<?= $total_pages ?>"><?= $total_pages ?></a>
                        </li>
                    <?php endif; ?>

                    <!-- Nút » -->
                    <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                        <a class="page-link"
                            href="?keyword=<?= urlencode($keyword) ?>&page=<?= min($total_pages, $page + 1) ?>">»</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
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