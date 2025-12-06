
  <style>
    .guide-schedule-page {
      padding-top: 24px;
      padding-bottom: 40px;
    }
    .page-title {
      font-size: 28px;
      font-weight: 800;
      color: #111827;
    }
    .btn-toggle-status {
      border-radius: 999px;
      padding: 8px 18px;
      font-size: 14px;
      font-weight: 600;
      background: #4b5563;
      color: #fff;
      border: none;
      box-shadow: 0 6px 18px rgba(15, 23, 42, 0.25);
    }
    .btn-toggle-status:hover {
      background: #374151;
      color: #fff;
    }
    .status-card {
      background: linear-gradient(90deg, #ff8c00, #ff6b00);
      color: #ffffff;
      border-radius: 20px;
      padding: 22px 28px;
      box-shadow: 0 12px 32px rgba(148, 64, 0, 0.3);
      margin-bottom: 28px;
    }
    .status-icon-circle {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.14);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      margin-right: 16px;
    }
    .status-subtitle {
      font-size: 14px;
      font-weight: 500;
      opacity: 0.95;
    }
    .status-title {
      font-size: 22px;
      font-weight: 800;
    }
    .status-right-label {
      font-size: 14px;
      font-weight: 500;
      opacity: 0.9;
      margin-bottom: 2px;
    }
    .status-right-value {
      font-size: 24px;
      font-weight: 800;
    }
    .tour-card {
      border-radius: 22px;
      border: none;
      box-shadow: 0 14px 40px rgba(15, 23, 42, 0.10);
      margin-bottom: 28px;
    }
    .tour-title {
      font-size: 22px;
      font-weight: 800;
      color: #111827;
    }
    .tour-sub {
      color: #6b7280;
      font-size: 14px;
    }
    .pill-day {
      background: #d1fae5;
      color: #047857;
      border-radius: 999px;
      padding: 6px 16px;
      font-size: 13px;
      font-weight: 600;
    }
    .summary-box {
      border-radius: 18px;
      padding: 14px 18px;
      margin-top: 18px;
      height: 100%;
    }

    .summary-label {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 6px;
    }
    .summary-value-main {
      font-size: 22px;
      font-weight: 800;
    }
    .summary-box.blue {
      background: #e5f0ff;
      color: #1d4ed8;
    }
    .summary-box.green {
      background: #ecfdf3;
      color: #15803d;
    }
    .summary-box.purple {
      background: #f5ebff;
      color: #7c3aed;
    }
    .action-row {
      margin-top: 22px;
    }
    .action-btn {
      border-radius: 12px;
      padding: 12px 18px;
      font-weight: 600;
      color: #fff;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      font-size: 14px;
      box-shadow: 0 10px 26px rgba(15, 23, 42, 0.18);
    }

    .action-btn i {
      font-size: 16px;
    }

    .action-blue {
      background: #2563eb;
    }

    .action-green {
      background: #16a34a;
    }

    .action-purple {
      background: #8b5cf6;
    }

    .action-orange {
      background: #f97316;
    }

    .action-btn:hover {
      opacity: 0.93;
      color: #fff;
    }

    /* Timeline card */
    .timeline-card {
      border-radius: 22px;
      border: none;
      box-shadow: 0 14px 40px rgba(15, 23, 42, 0.12);
      margin-bottom: 28px;
    }

    .timeline-title {
      font-size: 20px;
      font-weight: 800;
      color: #111827;
      margin-bottom: 18px;
    }

    .timeline-item {
      border-radius: 16px;
      padding: 14px 18px;
      margin-bottom: 10px;
      display: flex;
      align-items: flex-start;
      gap: 16px;
      background: #f9fafb;
      border-left: 5px solid #e5e7eb;
    }

    .timeline-time {
      font-size: 14px;
      font-weight: 700;
      color: #111827;
      min-width: 48px;
    }

    .timeline-main-title {
      font-weight: 700;
      color: #111827;
      margin-bottom: 4px;
      font-size: 15px;
    }

    .timeline-desc {
      font-size: 13px;
      color: #6b7280;
    }

    .timeline-badge {
      border-radius: 999px;
      padding: 4px 10px;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
    }

    /* trạng thái item */
    .timeline-done {
      background: #ecfdf3;
      border-left-color: #22c55e;
    }

    .timeline-done .timeline-badge {
      background: #bbf7d0;
      color: #166534;
    }

    .timeline-running {
      background: #e5f0ff;
      border-left-color: #2563eb;
    }

    .timeline-running .timeline-badge {
      background: #dbeafe;
      color: #1d4ed8;
    }

    .timeline-upcoming {
      background: #f9fafb;
      border-left-color: #e5e7eb;
    }

    .timeline-upcoming .timeline-badge {
      background: #e5e7eb;
      color: #4b5563;
    }

    /* Notes & emergency cards */
    .note-card,
    .emergency-card {
      border-radius: 22px;
      border: none;
      box-shadow: 0 14px 40px rgba(15, 23, 42, 0.10);
      margin-bottom: 24px;
    }

    .section-heading {
      font-size: 20px;
      font-weight: 800;
      color: #111827;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .section-heading i {
      color: #ff8c00;
    }

    .note-item {
      border-radius: 14px;
      padding: 12px 16px;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .note-title {
      font-weight: 700;
      margin-bottom: 3px;
    }

    .note-desc {
      font-size: 13px;
      color: #6b7280;
    }

    .note-veg {
      background: #fffbeb;
      border-left: 4px solid #facc15;
    }

    .note-diabetes {
      background: #fef2f2;
      border-left: 4px solid #ef4444;
    }

    .note-room {
      background: #eff6ff;
      border-left: 4px solid #2563eb;
    }

    .note-kid {
      background: #f5f3ff;
      border-left: 4px solid #8b5cf6;
    }

    .emergency-item {
      border-radius: 14px;
      background: #f9fafb;
      padding: 12px 16px;
      margin-bottom: 8px;
      font-size: 14px;
    }

    .emergency-label {
      color: #6b7280;
      margin-bottom: 4px;
    }

    .emergency-value {
      font-weight: 700;
      font-size: 15px;
      color: #111827;
    }
  </style>



<div class="container py-5">

  <!-- Title + toggle -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="page-title mb-0">Lịch Làm Việc - HDV</h1>
    
  </div>

  <!-- Status card -->
  <div class="status-card d-flex justify-content-between align-items-center flex-wrap">
    <div class="d-flex align-items-center mb-2 mb-md-0">
      <div class="status-icon-circle">
        <i class="fa-solid fa-user-group"></i>
      </div>
      <div>
        <div class="status-subtitle">Trạng thái hiện tại</div>
        <div class="status-title">Đang dẫn tour</div>
      </div>
    </div>
    <div class="text-md-end">
      <div class="status-right-label">Số khách</div>
      <div class="status-right-value">22/25</div>
    </div>
  </div>

  <!-- Tour card -->
  <div class="card tour-card">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-start mb-2">
        <div>
          <div class="tour-title">Tour Nhật Bản </div>
          <div class="tour-sub">
            20/12/2025 - 27/12/2025 (7 ngày 6 đêm)
          </div>
        </div>
        <div class="ms-3">
          <span class="pill-day">Ngày 3/7</span>
        </div>
      </div>

      <!-- Summary -->
      <div class="row g-3">
        <div class="col-md-4">
          <div class="summary-box blue">
            <div class="summary-label">Số khách</div>
            <div class="summary-value-main">22</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="summary-box green">
            <div class="summary-label">Điểm tham quan</div>
            <div class="summary-value-main">5/12</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="summary-box purple">
            <div class="summary-label">Còn lại</div>
            <div class="summary-value-main">4 ngày</div>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="row g-3 action-row">
        <div class="col-md-12">
          <button class="w-100 action-btn action-blue">
            <i class="fa-solid fa-users"></i>
            Xem danh sách khách (22)
          </button>
        </div>
        <div class="col-md-6">
          <button class="w-100 action-btn action-green">
            <i class="fa-solid fa-circle-check"></i>
            Điểm danh
          </button>
        </div>
        <div class="col-md-6">
          <button class="w-100 action-btn action-purple">
            <i class="fa-solid fa-book-open"></i>
            Nhật ký tour
          </button>
        </div>
        <div class="col-md-12">
          <button class="w-100 action-btn action-orange">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Báo cáo sự cố
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Timeline today -->
  <div class="card timeline-card">
    <div class="card-body p-4">
      <div class="timeline-title mb-3">Lịch Trình Hôm Nay - 22/12/2025</div>

      <!-- item 1 -->
      <div class="timeline-item timeline-done">
        <div class="timeline-time text-center">
          <div class="mb-1"><i class="fa-regular fa-clock"></i></div>
          8:00
        </div>
        <div class="flex-grow-1">
          <div class="timeline-main-title">
            ✓ Tập trung khách sạn
          </div>
          <div class="timeline-desc">
            Điểm danh: 22/22 khách có mặt
          </div>
        </div>
        <div>
          <span class="timeline-badge">Hoàn thành</span>
        </div>
      </div>

      <!-- item 2 -->
      <div class="timeline-item timeline-running">
        <div class="timeline-time text-center">
          <div class="mb-1"><i class="fa-regular fa-clock"></i></div>
          10:00
        </div>
        <div class="flex-grow-1">
          <div class="timeline-main-title">
            <i class="fa-solid fa-circle-play text-primary me-1"></i>
            Thăm Chùa Vàng (Kinkaku-ji)
          </div>
          <div class="timeline-desc">
            Hướng dẫn 2 tiếng, chú ý giữ trật tự
          </div>
        </div>
        <div>
          <span class="timeline-badge">Đang diễn ra</span>
        </div>
      </div>

      <!-- item 3 -->
      <div class="timeline-item timeline-upcoming">
        <div class="timeline-time text-center">
          <div class="mb-1"><i class="fa-regular fa-clock"></i></div>
          12:30
        </div>
        <div class="flex-grow-1">
          <div class="timeline-main-title">
            Ăn trưa - Nhà hàng Sakura
          </div>
          <div class="timeline-desc">
            Set menu đặc biệt, 3 khách ăn chay
          </div>
        </div>
        <div>
          <span class="timeline-badge">Sắp tới</span>
        </div>
      </div>

      <!-- item 4 -->
      <div class="timeline-item timeline-upcoming mb-1">
        <div class="timeline-time text-center">
          <div class="mb-1"><i class="fa-regular fa-clock"></i></div>
          15:00
        </div>
        <div class="flex-grow-1">
          <div class="timeline-main-title">
            Tham quan Phố Cổ Gion
          </div>
          <div class="timeline-desc">
            Tự do chụp ảnh, tập trung 17:30
          </div>
        </div>
        <div>
          <span class="timeline-badge">Sắp tới</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Important notes -->
  <div class="card note-card">
    <div class="card-body p-4">
      <div class="section-heading">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span>Ghi Chú Quan Trọng</span>
      </div>

      <div class="note-item note-veg">
        <div class="note-title">Ăn chay: 3 khách</div>
        <div class="note-desc">Bà Lan (phòng 302), Chị Hoa, Anh Minh</div>
      </div>

      <div class="note-item note-diabetes">
        <div class="note-title">Tiểu đường: 1 khách</div>
        <div class="note-desc">Ông Tuấn (phòng 205) - cần ăn đúng giờ</div>
      </div>

      <div class="note-item note-room">
        <div class="note-title">Phòng đơn: 2 yêu cầu</div>
        <div class="note-desc">Phòng 401 và 402</div>
      </div>

      <div class="note-item note-kid mb-1">
        <div class="note-title">Trẻ em: 4 em nhỏ</div>
        <div class="note-desc">Độ tuổi: 5–10 tuổi, cần chú ý an toàn</div>
      </div>
    </div>
  </div>
  <div class="card emergency-card">
    <div class="card-body p-4">
      <div class="section-heading">
        <i class="fa-solid fa-phone-volume"></i>
        <span>Liên Hệ Khẩn Cấp</span>
      </div>

      <div class="emergency-item">
        <div class="emergency-label">Văn phòng Hà Nội</div>
        <div class="emergency-value">024-3456-7890</div>
      </div>

      <div class="emergency-item">
        <div class="emergency-label">Đại diện Nhật Bản</div>
        <div class="emergency-value">+81-3-1234-5678</div>
      </div>

      <div class="emergency-item mb-1">
        <div class="emergency-label">Cấp cứu địa phương</div>
        <div class="emergency-value">119</div>
      </div>
    </div>
  </div>

</div>



