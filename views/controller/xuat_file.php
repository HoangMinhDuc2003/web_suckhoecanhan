<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=du_lieu_suc_khoe.xls");
header("Pragma: no-cache");
header("Expires: 0");

$id_nguoi_dung = $_SESSION['user_id'] ?? null;
$tu_ngay = $_GET['tu_ngay'] ?? '';
$den_ngay = $_GET['den_ngay'] ?? '';

$sql = "SELECT * FROM thongkesuckhoe WHERE id_nguoi_dung = ?";
$params = [$id_nguoi_dung];
$types = "i";

if ($tu_ngay && $den_ngay) {
  $sql .= " AND ngay_ghi_nhan BETWEEN ? AND ?";
  $params[] = $tu_ngay;
  $params[] = $den_ngay;
  $types .= "ss";
}
$sql .= " ORDER BY ngay_ghi_nhan DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
echo "<table border='1'>";
echo "<tr>
        <th>Ngày</th>
        <th>Nhịp tim (bpm)</th>
        <th>Huyết áp (mmHg)</th>
        <th>Đường huyết (mg/dL)</th>
        <th>BMI</th>
      </tr>";
while ($row = $result->fetch_assoc()) {
  $ngay = date("d/m/Y", strtotime($row['ngay_ghi_nhan']));
  $nhipTim = $row['nhip_tim'];
  $huyetAp = $row['huyet_ap_tam_thu'] . '/' . $row['huyet_ap_tam_truong'];
  $duongHuyet = $row['duong_huyet'];
  $bmi = $row['BMI'];

  echo "<tr>
            <td>$ngay</td>
            <td>$nhipTim</td>
            <td>$huyetAp</td>
            <td>$duongHuyet</td>
            <td>$bmi</td>
          </tr>";
}
echo "</table>";
$stmt->close();
$conn->close();
?>