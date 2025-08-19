//Phần hover để hiển thị các menu con
document.addEventListener("DOMContentLoaded", function () {
  const dropdownItems = document.querySelectorAll(".nav-item.dropdown");

  dropdownItems.forEach(function (item) {
    const link = item.querySelector(".dropdown-toggle");
    const menu = item.querySelector(".dropdown-menu");

    item.addEventListener("mouseenter", function () {
      menu.classList.add("show");
      link.classList.add("show");
    });

    item.addEventListener("mouseleave", function () {
      menu.classList.remove("show");
      link.classList.remove("show");
    });
  });
});
//Biểu đồ
fetch("chi_so_bieu_do.php")
  .then((response) => response.json())
  .then((data) => {
    const labels = data.map((item) => item.ngay_ghi_nhan);
    const nhipTim = data.map((item) => item.nhip_tim);
    const duongHuyet = data.map((item) => item.duong_huyet);
    const huyetApTamThu = data.map((item) => item.huyet_ap_tam_thu);
    const huyetApTamTruong = data.map((item) => item.huyet_ap_tam_truong);
    const bmi = data.map((item) => item.BMI);

    new Chart(document.getElementById("bieuDoNhipTim"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Nhịp tim",
            data: nhipTim,
            borderWidth: 2,
            borderColor: "red",
            fill: false,
            tension: 0.3,
          },
        ],
      },
    });

    new Chart(document.getElementById("bieuDoDuongHuyet"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Đường huyết",
            data: duongHuyet,
            borderWidth: 2,
            borderColor: "blue",
            fill: false,
            tension: 0.3,
          },
        ],
      },
    });

    new Chart(document.getElementById("bieuDoHuyetAp"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Huyết áp tâm thu",
            data: huyetApTamThu,
            borderWidth: 2,
            borderColor: "green",
            fill: false,
            tension: 0.3,
          },
          {
            label: "Huyết áp tâm trương",
            data: huyetApTamTruong,
            borderWidth: 2,
            borderColor: "orange",
            fill: false,
            tension: 0.3,
          },
        ],
      },
    });

    new Chart(document.getElementById("bieuDoBMI"), {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Chỉ số BMI",
            data: bmi,
            borderWidth: 2,
            borderColor: "purple",
            fill: false,
            tension: 0.3,
          },
        ],
      },
    });
  });
// Nút chia sẻ của bài viết