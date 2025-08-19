<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/db.php';

// Header
require_once __DIR__ . '/includes/header.php';
?>

<!-- Main -->
<main class="py-5 bg-light ">
  <div class="container">

    <!-- PHẦN GIỚI THIỆU -->
    <div class=" hero-section position-relative text-center mb-5">
      <div class="bg-blur border-blur"></div>
      <div class="hero-content position-relative">
        <h1 class="fw-bold">Nâng Cao Sức Khỏe - Sống Khỏe Mỗi Ngày</h1>
        <p class="lead text-muted">Hệ thống hỗ trợ theo dõi và chăm sóc sức khỏe toàn diện, cá nhân hóa cho bạn.</p>
        <a href="<?= $isLoggedIn ? 'views/health/chi_so.php' : 'views/auth/dang_nhap.php' ?>"
          class="btn btn-start btn-lg">Bắt đầu
          ngay</a>
      </div>
    </div>

    <!-- PHẦN TÍNH NĂNG -->
    <div class="row g-4 mb-5">
      <div class="col-md-3">
        <a href="views/health/chi_so.php" class="text-decoration-none text-dark">
          <div class="card feature-card text-center p-3 rounded-4 h-100">
            <i class="bi bi-activity display-4 text-primary mb-3"></i>
            <h5 class="fw-bold">Theo Dõi Chỉ Số</h5>
            <p class="text-muted">Nhập cân nặng, chiều cao, nhịp tim,... để đánh giá sức khỏe.</p>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="views/health/chi_so.php#thongke-suckhoe" class="text-decoration-none text-dark">
          <div class="card feature-card text-center p-3 rounded-4 h-100">
            <i class="bi bi-bar-chart-line-fill display-4 text-success mb-3"></i>
            <h5 class="fw-bold">Biểu Đồ Phân Tích</h5>
            <p class="text-muted">Hiển thị biểu đồ thay đổi chỉ số để bạn theo dõi dễ dàng.</p>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="views/article/bai_viet.php" class="text-decoration-none text-dark">
          <div class="card feature-card text-center p-3 rounded-4 h-100">
            <i class="bi bi-journal-medical display-4 text-warning mb-3"></i>
            <h5 class="fw-bold">Bài Viết Chuyên Sâu</h5>
            <p class="text-muted">Cập nhật kiến thức y tế, dinh dưỡng và mẹo chăm sóc sức khỏe.</p>
          </div>
        </a>
      </div>
      <div class="col-md-3">
        <a href="views/contact/hoi_bac_si.php" class="text-decoration-none text-dark">
          <div class="card feature-card text-center p-3 rounded-4 h-100">
            <i class="bi bi-headset display-4 text-danger mb-3"></i>
            <h5 class="fw-bold">Tư Vấn Trực Tuyến</h5>
            <p class="text-muted">Hỗ trợ tư vấn sức khỏe từ các chuyên gia nhanh chóng.</p>
          </div>
        </a>
      </div>
    </div>

    <!-- PHẦN BÀI VIẾT NỔI BẬT -->
    <?php
    $sql = "SELECT id, tieu_de, mo_ta, hinh_anh FROM baiviet ORDER BY ngay_dang DESC LIMIT 4";
    $result = $conn->query($sql);
    ?>
    <div class="mb-5">
      <h2 class="mb-4">📝 Bài Viết Nổi Bật</h2>
      <div class="row g-4">

        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="col-md-6">
            <div class="card h-100 shadow-sm rounded-4">
              <img src="assets/images/baiviet/<?php echo htmlspecialchars($row['hinh_anh']); ?>"
                class="card-img-top article-img" alt="<?php echo htmlspecialchars($row['tieu_de']); ?>">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['tieu_de']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($row['mo_ta']); ?></p>
                <a href="views/article/bai_viet_chi_tiet.php?id=<?php echo $row['id']; ?>" class="btn-read">Đọc bài
                  viết</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

    <!-- PHẦN CÂU HỎI THƯỜNG GẶP -->
    <div class="mb-5">
      <h2 class="mb-4">❓ Câu Hỏi Thường Gặp</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1"
              aria-expanded="true">
              <h4>Làm sao để tính chỉ số BMI?</h4>
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Chỉ số BMI = Cân nặng (kg) / (Chiều cao (m) × Chiều cao (m)). Hệ thống sẽ tính cho bạn tự động.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
              <h4>Làm sao để biết sức khỏe tim mạch của tôi ổn không?</h4>
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Bạn nên theo dõi nhịp tim thường xuyên. Mục "Chỉ số" cho phép bạn nhập và theo dõi nhịp tim mỗi ngày.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3"
              aria-expanded="true">
              <h4>Tôi có thể lưu lại các chỉ số sức khỏe mỗi ngày không?</h4>
            </button>
          </h2>
          <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Có, bạn có thể nhập các chỉ số như nhịp tim, huyết áp, cân nặng... mỗi ngày và hệ thống sẽ lưu trữ lại
              cho bạn.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4"
              aria-expanded="true">
              <h4>Tôi có thể xem lại lịch sử sức khỏe của mình không?</h4>
            </button>
          </h2>
          <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Hoàn toàn có thể. Bạn vào mục “Lịch sử chỉ số” để xem biểu đồ và bảng thống kê các lần đo trước.
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chỉ Số Sức Khỏe Gần Đây -->
    <?php
    $hasData = false;
    $row = null;

    if ($isLoggedIn) {
      $user_id = $_SESSION['user_id'];
      $sql = "SELECT huyet_ap_tam_thu, huyet_ap_tam_truong, nhip_tim, duong_huyet 
          FROM thongkesuckhoe 
          WHERE id_nguoi_dung = ? 
          ORDER BY ngay_ghi_nhan DESC 
          LIMIT 1";

      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hasData = true;
      }
    }
    ?>
    <section class="mb-5">
      <h2 class="mb-4">📊 Chỉ Số Sức Khỏe Gần Đây</h2>

      <?php if (!$isLoggedIn): ?>
        <div class="alert alert-info text-center">
          Vui lòng <a href="views/auth/dang_nhap.php" class="alert-link">đăng nhập</a> để xem chỉ số sức khỏe cá nhân
          của
          bạn.
        </div>
      <?php elseif (!$hasData): ?>
        <div class="alert alert-warning text-center">
          Bạn chưa nhập chỉ số sức khỏe nào. Hãy bắt đầu theo dõi sức khỏe ngay!
        </div>
      <?php else: ?>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Huyết Áp</h5>
                <p class="card-text fs-4">
                  <?= htmlspecialchars($row['huyet_ap_tam_thu']) ?>/<?= htmlspecialchars($row['huyet_ap_tam_truong']) ?>
                  mmHg
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Nhịp Tim</h5>
                <p class="card-text fs-4"><?= htmlspecialchars($row['nhip_tim']) ?> bpm</p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card text-center shadow-sm">
              <div class="card-body">
                <h5 class="card-title">Đường Huyết</h5>
                <p class="card-text fs-4"><?= htmlspecialchars($row['duong_huyet']) ?> mmol/L</p>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </section>


    <!-- Nhat ky -->
    <section class="text-center mb-5">
      <h2 class="mb-3">📔 Nhật Ký Sức Khỏe</h2>
      <p class="mb-4">Ghi lại cảm nhận, triệu chứng và hoạt động hàng ngày để theo dõi tiến trình sức khỏe.</p>
      <a href="<?php echo $isLoggedIn ? 'views/user/nhat_ky.php' : 'views/auth/dang_nhap.php'; ?> "
        class="btn btn-start btn-lg">Ghi nhật ký</a>
    </section>

    <!-- Đội ngũ chuyên gia -->
    <section class="mb-5">
      <h2 class="mb-4">👨‍⚕️ Đội Ngũ Chuyên Gia</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <img src="assets/images/bacsi/bacsi1.jpg" class="card-img-top doctor-image" alt="Dr. Lan">
            <div class="card-body">
              <h5 class="card-title">BS. Lan Nguyễn</h5>
              <p class="card-text">Chuyên gia dinh dưỡng <br> 10 năm kinh nghiệm tư vấn sức khỏe.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <img src="assets/images/bacsi/bacsi3.jpg" class="card-img-top doctor-image" alt="Dr. Minh">
            <div class="card-body">
              <h5 class="card-title">BS. Minh Trần</h5>
              <p class="card-text">Bác sĩ nội khoa <br> chuyên theo dõi bệnh mãn tính.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card text-center shadow-sm">
            <img src="assets/images/bacsi/bacsi2.jpg" class="card-img-top doctor-image" alt="Dr. Trinh">
            <div class="card-body">
              <h5 class="card-title">BS. Phương Trinh</h5>
              <p class="card-text">Bác sĩ tâm lý<br>Hơn 8 năm tư vấn và trị liệu tâm lý chuyên sâu.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="text-center py-3 border-top border-secondary" style="background: rgba(255,255,255,0.05);">
    </div>
    <!-- Giới thiệu -->
    <section class="container my-5">
      <h2 class="text-center mb-4">👥 Về chúng tôi</h2>
      <p class="text-center">
        Website giúp bạn quản lý và theo dõi các chỉ số sức khỏe quan trọng.
        Hãy bắt đầu hành trình sống khỏe mạnh và khoa học ngay hôm nay!
      </p>
    </section>
  </div>
</main>

<?php
// Footer
require_once __DIR__ . '/includes/footer.php';
?>