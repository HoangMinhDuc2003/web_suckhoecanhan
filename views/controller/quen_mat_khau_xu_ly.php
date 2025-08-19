<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

$taikhoan = trim($_POST['taikhoan'] ?? '');
$_SESSION['reset_email'] = $taikhoan;

$sql = "SELECT * FROM nguoidung WHERE email = ? OR so_dien_thoai = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $taikhoan, $taikhoan);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  $_SESSION['error'] = "Không tìm thấy tài khoản.";
  header("Location: ../auth/quen_mat_khau.php");
  exit();
}

$user = $result->fetch_assoc();
$email = $user['email'];

$reset_token = rand(100000, 999999);

$update = $conn->prepare("UPDATE nguoidung SET reset_token = ? WHERE id = ?");
$update->bind_param("si", $reset_token, $user['id']);
$update->execute();

$subject = "Yêu cầu đặt lại mật khẩu - Website Sức Khỏe";
$message = "
<html>
<head>
  <meta charset='UTF-8'>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
    }
    .email-container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      border-radius: 8px;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .btn {
      display: inline-block;
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      margin-top: 20px;
    }
    .code-box {
      font-size: 24px;
      font-weight: bold;
      color: #dc3545;
      background-color: #f8d7da;
      padding: 15px;
      border-radius: 5px;
      text-align: center;
      letter-spacing: 4px;
    }
  </style>
</head>
<body>
  <div class='email-container'>
    <h2>Yêu cầu đặt lại mật khẩu</h2>
    <p>Chào bạn,</p>
    <p>Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản trên hệ thống <strong>Website Sức Khỏe</strong>.</p>
    <p>Vui lòng sử dụng mã xác nhận bên dưới để tiếp tục:</p>
    <div class='code-box'>$reset_token</div>
    <p>Mã xác nhận này chỉ có hiệu lực trong vòng <strong>10 phút</strong>. Vui lòng không chia sẻ mã này với bất kỳ ai.</p>
    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
    <p style='margin-top: 30px;'>Trân trọng,<br><strong>Website Sức Khỏe</strong></p>
  </div>
</body>
</html>
";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html;charset=UTF-8\r\n";
$headers .= "From: Website Duc My Health <hoangminhduc21052003@gmail.com>\r\n";

if (mail($email, $subject, $message, $headers)) {
  $_SESSION['success'] = "Mã xác nhận đã được gửi đến email của bạn.";
  header("Location: ../auth/xac_nhan_token.php");
  exit();
} else {
  $_SESSION['error'] = "Không thể gửi email. Vui lòng thử lại.";
  header("Location: ../auth/quen_mat_khau.php");
  exit();
}
