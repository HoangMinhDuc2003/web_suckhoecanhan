<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['ho_ten'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Duc My Health</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/logo/logo.png" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <!-- Bootstrap Icons -->
    <link href="<?= BASE_URL ?>/assets/css/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark animated-gradient shadow-sm">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="<?= BASE_URL ?>/index.php">
                    <img src="<?= BASE_URL ?>/assets/images/logo/logo.png" alt="Logo" style="height: 40px;"
                        class="me-2">
                    <span class="fw-bold fs-4">Duc My Health</span>
                </a>

                <!-- Toggle mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-2">
                        <!-- Trang Chủ -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/index.php">
                                <i class="bi bi-house-door-fill text-warning me-1"></i>Trang Chủ
                            </a>
                        </li>

                        <!-- Chỉ Số -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>/views/health/chi_so.php">
                                <i class="bi bi-activity text-danger me-1"></i>Chỉ Số
                            </a>
                        </li>

                        <!-- Nhật Ký -->
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= BASE_URL ?><?php echo $isLoggedIn ? '/views/user/nhat_ky.php' : '/views/auth/dang_nhap.php'; ?>">
                                <i class="bi bi-journal-medical text-info me-1"></i>Nhật Ký
                            </a>
                        </li>

                        <!-- Bài Viết -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-book-half text-light me-1"></i> Bài Viết
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= BASE_URL ?>/views/article/bai_viet.php?loai=dinh_duong">
                                        <i class="bi bi-cup-straw text-success me-2"></i> Dinh Dưỡng
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= BASE_URL ?>/views/article/bai_viet.php?loai=benh_ly">
                                        <i class="bi bi-clipboard-pulse text-danger me-2"></i> Bệnh Lý
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="<?= BASE_URL ?>/views/article/bai_viet.php?loai=luyen_tap">
                                        <i class="bi bi-stopwatch text-primary me-2"></i> Luyện Tập
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="<?= BASE_URL ?>/views/article/bai_viet.php">
                                        <i class="bi bi-arrow-right-circle-fill text-secondary me-2"></i> Xem Tất Cả
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Liên Hệ -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#">
                                <i class="bi bi-envelope-fill text-warning me-1"></i>Liên Hệ
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/views/contact/hoi_bac_si.php"><i
                                            class="bi bi-chat-heart-fill text-primary me-1"></i>Hỏi Bác
                                        Sĩ</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/views/contact/ho_tro_ky_thuat.php"><i
                                            class="bi bi-tools text-secondary me-1"></i>Hỗ Trợ & Góp Ý</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Đăng nhập/đăng xuất -->
                        <?php if ($isLoggedIn): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#">
                                    <i class="bi bi-person-circle text-light me-1"></i>
                                    <?= htmlspecialchars($userName) ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/views/user/thong_tin_ca_nhan.php"><i
                                                class="bi bi-person-lines-fill text-primary me-2"></i>Thông Tin Cá Nhân</a>
                                    </li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/views/auth/doi_mat_khau.php"><i
                                                class="bi bi-lock-fill text-warning me-2"></i>Đổi
                                            Mật Khẩu</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger"
                                            href="<?= BASE_URL ?>/views/auth/dang_xuat.php"><i
                                                class="bi bi-box-arrow-right text-danger me-2"></i>Đăng Xuất</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>/views/auth/dang_nhap.php">
                                    <i class="bi bi-box-arrow-in-right text-light me-1"></i>Đăng Nhập
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>