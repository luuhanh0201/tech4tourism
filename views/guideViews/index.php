<div class="container py-5">
  <div id="free-view" class="dashboard-view active">
    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">
          <i style="font-size: 32px;" class="fa-solid fa-star"></i>
        </div>
        <div class="stat-value"><?= $guide['rate'] . '/5' ?? "Chưa có đánh giá" ?></div>
        <div class="stat-label">Đánh Giá Trung Bình</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">
          <i style="font-size: 32px;" class="fa-solid fa-flag-checkered"></i>
        </div>
        <div class="stat-value"><?= count($tourSuccess) ?></div>
        <div class="stat-label">Tour Hoàn Thành</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">
          <i style="font-size: 32px;" class="fa-solid fa-calendar-check"></i>
        </div>
        <div class="stat-value"><?= $currentTour ? 1 : 0 ?></div>
        <div class="stat-label">Tour Đang Thực Hiện</div>
      </div>
    </div>

    <!-- Empty State -->
    <?php if (!$currentTour): ?>
      <div class="card-section">
        <div class="empty-state">
          <div class="empty-icon">
            <i style="font-size: 100px;" class="fa-solid fa-calendar-day"></i>
          </div>
          <div class="empty-title">Bạn Chưa Có Tour Nào</div>
          <div class="empty-text">
            Hiện tại bạn đang rảnh và sẵn sàng nhận tour mới.<br>
            Admin sẽ phân công tour phù hợp cho bạn.
          </div>
          <button class="btn-action btn-primary-custom">
            <i class="fa-solid fa-bell me-2"></i>Bật Thông Báo
          </button>
        </div>
      </div>
    <?php else: ?>
      <div class="card-section">
        <div class="tour-header">
          <div class="tour-badge">
            <i class="fa-solid fa-map-location-dot me-2"></i>Tour Hiện Tại
          </div>
          <div class="tour-status status-ongoing ?>">
            <?=$currentTour['assignment_status'] ? "Đã xác nhận" : "" ?>
          </div>
        </div>

        <div class="tour-info-grid">
          <div class="tour-info-item">
            <div class="info-label">
              <i class="fa-solid fa-route me-2"></i>Tên Tour
            </div>
            <div class="info-value"><?php echo htmlspecialchars($currentTour['tour_name']); ?></div>
          </div>



          <div class="tour-info-item">
            <div class="info-label">
              <i class="fa-solid fa-calendar-check me-2"></i>Ngày Khởi Hành
            </div>
            <div class="info-value"><?php echo date('d/m/Y', strtotime($currentTour['booking_date'])); ?></div>
          </div>

          <div class="tour-info-item">
            <div class="info-label">
              <i class="fa-solid fa-calendar-xmark me-2"></i>Ngày Kết Thúc
            </div>
            <div class="info-value"><?php echo date('d/m/Y', strtotime($currentTour['departure_date'])); ?></div>
          </div>

          <div class="tour-info-item">
            <div class="info-label">
              <i class="fa-solid fa-clock me-2"></i>Thời Gian
            </div>
            <div class="info-value">
              <?php echo $currentTour['tour_duration_day']; ?> ngày
              <?php echo $currentTour['tour_duration_night']; ?> đêm
            </div>
          </div>

        </div>

        <?php if ($currentTour['assignment_notes']): ?>
          <div class="tour-notes">
            <div class="notes-header">
              <i class="fa-solid fa-note-sticky me-2"></i>Ghi Chú Từ Admin
            </div>
            <div class="notes-content">
              <?php echo nl2br(htmlspecialchars($currentTour['assignment_notes'])); ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="tour-customer-info">
          <div class="customer-header">
            <i class="fa-solid fa-user-circle me-2"></i>Thông tin khách hàng đại diện
          </div>
          <div class="customer-details">
            <div class="customer-item">
              <i class="fa-solid fa-user me-2"></i>
              <span><?php echo htmlspecialchars($currentTour['created_by_name']); ?></span>
            </div>
            <div class="customer-item">
              <i class="fa-solid fa-envelope me-2"></i>
              <span><?php echo htmlspecialchars($currentTour['created_by_email']); ?></span>
            </div>
          </div>
        </div>

        <div class="tour-actions">
          <button class="btn-action btn-primary-custom">
            <i class="fa-solid fa-circle-info me-2"></i><a href="/guide/current-tour"
              style="outline: none;text-decoration: none; color: #fff;">Xem chi tiết tour</a>
          </button>
          <button class="btn-action btn-secondary-custom">
            <i class="fa-solid fa-phone me-2"></i>Liên Hệ Khách Hàng
          </button>
        </div>
      </div>
    <?php endif; ?>

    <!-- Tour được phân công -->
    <?php if (!empty($detailAssignment)): ?>
      <div class="card-section">
        <h5 class="section-title">
          <i class="fa-solid fa-clipboard-list"></i>
          Tour Được Phân Công (<?= count($detailAssignment) ?>)
        </h5>

        <div class="alert-custom alert-info-custom">
          <i class="fa-solid fa-info-circle me-2"></i>
          <strong>Có tour mới</strong> được admin phân công cho bạn. Hãy xác nhận nhận tour!
        </div>

        <!-- Tour 1 -->
        <div class="tour-card">
          <div class="tour-header">
            <div>
              <div class="tour-title"><?= $detailAssignment['tour_name'] ?> (<?= $detailAssignment['tour_duration_day'] ?>
                ngày <?= $detailAssignment['tour_duration_night'] ?> đêm)</div>
              <div class="tour-code"><?= $detailAssignment['booking_code'] ?> - Được phân công bởi
                <b><?= $detailAssignment['created_by_name'] ?></b>
              </div>
            </div>
            <span class="tour-status status-assigned">
              <i class="fa-solid fa-clock me-1"></i>Chờ Xác Nhận
            </span>
          </div>

          <div class="tour-info">
            <div class="info-item">
              <i class="fa-solid fa-calendar"></i>
              <span><?= $detailAssignment['assignment_started_at'] ?> đến
                <?= $detailAssignment['assignment_ended_at'] ?></span>
            </div>
            <div class="info-item">
              <i class="fa-solid fa-users"></i>
              <span>4 người</span>
            </div>
            <div class="info-item pb-4">
              <i class="fa-solid fa-money-bill-wave"></i>
              <span><?= number_format($detailAssignment['booking_total_price']) ?>đ</span>
            </div>
          </div>
          <?= $detailAssignment['assignment_notes'] ? '<div class="alert-custom alert-warning-custom"><i class="fa-solid fa-exclamation-triangle me-2"></i> <strong>Lưu ý:</strong></div>' . $detailAssignment['assignment_notes'] : "" ?>

          <form method="post" class="tour-actions">
            <button type="submit" class="btn-action btn-primary-custom">
              <i class="fa-solid fa-check me-2"></i>Xác Nhận Nhận Tour
            </button>
            <a href="#" class="btn-action btn-outline-custom">
              <i class="fa-solid fa-info-circle me-2"></i>Chi Tiết
            </a>
          </form>
        </div>


      </div>
    <?php endif; ?>
    <div class="card-section">
      <h5 class="section-title">
        <i class="fa-solid fa-clock-rotate-left"></i>
        Tour Đã Hoàn Thành (<?= count($tourSuccess) ?>)
      </h5>

      <?php if (empty($tourSuccess)): ?>
        <div class="empty-state">
          <div class="empty-icon">
            <i style="font-size: 80px;" class="fa-solid fa-clipboard-check"></i>
          </div>
          <div class="empty-title">Chưa Có Tour Hoàn Thành</div>
          <div class="empty-text">
            Bạn chưa hoàn thành tour nào. Hãy cố gắng hoàn thành tour đầu tiên!
          </div>
        </div>
      <?php else: ?>
        <div class="timeline">
          <?php foreach ($tourSuccess as $tour): ?>
            <div class="timeline-item">
              <div class="timeline-marker completed"></div>
              <div class="timeline-content completed">
                <div class="timeline-time">
                  <?= date('d/m/Y', strtotime($tour['booking_date'])) ?> -
                  <?= date('d/m/Y', strtotime($tour['departure_date'])) ?>
                </div>
                <div class="timeline-text">
                  <strong><?= htmlspecialchars($tour['tour_name']) ?></strong>
                  (<?= $tour['tour_duration_day'] ?>N<?= $tour['tour_duration_night'] ?>Đ)
                  <div class="info-item" style="margin-top: 8px;">
                    <i class="fa-solid fa-ticket"></i>
                    <span><?= htmlspecialchars($tour['booking_code']) ?></span>
                  </div>
                  <div class="info-item">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <span><?= number_format($tour['booking_total_price'], 0, ',', '.') ?>đ</span>
                  </div>
                  <?php if ($tour['tour_rate']): ?>
                    <div style="margin-top: 10px;">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa-solid fa-star <?= $i <= $tour['tour_rate'] ? 'text-warning' : 'text-muted' ?>"></i>
                      <?php endfor; ?>
                      <span class="ms-2"><?= $tour['tour_rate'] ?>/5.0</span>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<style>
  /* ==== TOUR HEADER ==== */
  .tour-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
  }

  .tour-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: #fff;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.95rem;
  }

  .tour-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
  }

  .status-pending {
    background: #fff4e6;
    color: #f57c00;
  }

  .status-confirmed {
    background: #e3f2fd;
    color: #1976d2;
  }

  .status-ongoing {
    background: #d6f5d6;
    color: #1a8f1a;
  }

  .status-completed {
    background: #f0f0f0;
    color: #666;
  }

  /* ==== TOUR INFO GRID ==== */
  .tour-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
    margin-bottom: 20px;
  }

  .tour-info-item {
    background: #f8f9fa;
    padding: 14px;
    border-radius: 10px;
    border-left: 3px solid var(--color-primary);
  }

  .info-label {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    color: #999;
    margin-bottom: 6px;
    font-weight: 600;
  }

  .info-label i {
    color: var(--color-primary);
  }

  .info-value {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
  }

  .text-price {
    color: var(--color-primary);
    font-size: 1.1rem;
  }

  /* ==== TOUR NOTES ==== */
  .tour-notes {
    background: #fff4e6;
    border-left: 4px solid #f57c00;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 20px;
  }

  .notes-header {
    display: flex;
    align-items: center;
    font-weight: 700;
    color: #f57c00;
    margin-bottom: 8px;
    font-size: 0.95rem;
  }

  .notes-header i {
    margin-right: 8px;
  }

  .notes-content {
    color: #333;
    font-size: 0.95rem;
    line-height: 1.6;
  }

  /* ==== CUSTOMER INFO ==== */
  .tour-customer-info {
    background: var(--color-primary-soft);
    border-left: 4px solid var(--color-primary);
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 20px;
  }

  .customer-header {
    display: flex;
    align-items: center;
    font-weight: 700;
    color: var(--color-primary-dark);
    margin-bottom: 12px;
    font-size: 0.95rem;
  }

  .customer-header i {
    margin-right: 8px;
  }

  .customer-details {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .customer-item {
    display: flex;
    align-items: center;
    color: #333;
    font-size: 0.95rem;
  }

  .customer-item i {
    color: var(--color-primary);
    width: 20px;
    margin-right: 8px;
  }

  /* ==== TOUR ACTIONS ==== */
  .tour-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .btn-action {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: #fff;
  }

  .btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 138, 101, 0.4);
  }

  .btn-secondary-custom {
    background: #fff;
    color: var(--color-primary);
    border: 2px solid var(--color-primary);
  }

  .btn-secondary-custom:hover {
    background: var(--color-primary);
    color: #fff;
  }

  .dashboard-view {
    display: none;
  }

  .dashboard-view.active {
    display: block;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
  }

  .stat-card {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: #fff;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    box-shadow: var(--shadow-primary);
  }

  .stat-icon {
    font-size: 2.2rem;
    margin-bottom: 10px;
    opacity: 0.9;
  }

  .stat-value {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 4px;
  }

  .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
  }

  /* ==== CARD SECTION ==== */
  .card-section {
    background: #fff;
    border-radius: 16px;
    padding: 22px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 22px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
  }

  .card-section:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
  }

  .section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
  }

  .section-title i {
    color: var(--color-primary);
  }

  /* ==== EMPTY STATE ==== */
  .empty-state {
    text-align: center;
    padding: 40px 20px;
  }

  .empty-icon {
    font-size: 22px;
    color: var(--color-primary);
    opacity: 0.3;
    margin-bottom: 15px;
  }

  .empty-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--color-text-sub);
    margin-bottom: 8px;
  }

  .empty-text {
    color: #999;
    margin-bottom: 20px;
  }

  /* ==== TOUR CARD ==== */
  .tour-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    margin-bottom: 16px;
    border: 1.5px solid #f0f0f0;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
  }

  .tour-card:hover {
    border-color: var(--color-primary);
    box-shadow: 0 3px 12px rgba(255, 138, 101, 0.2);
  }

  .tour-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
  }

  .tour-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 4px;
  }

  .tour-code {
    color: var(--color-primary);
    font-weight: 600;
    font-size: 0.9rem;
  }

  .tour-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    white-space: nowrap;
  }

  .status-ongoing {
    background: #d6f5d6;
    color: #1a8f1a;
  }

  .status-upcoming {
    background: #e3f2fd;
    color: #1976d2;
  }

  .status-assigned {
    background: #fff4e6;
    color: #f57c00;
  }

  .tour-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
    gap: 10px 16px;
    margin-bottom: 12px;
  }

  .info-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--color-text-sub);
    font-size: 0.95rem;
  }

  .info-item i {
    color: var(--color-primary);
    width: 18px;
    text-align: center;
  }

  .tour-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  /* ==== BUTTONS ==== */
  .btn-action {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.95rem;
  }

  .btn-primary-custom {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    color: #fff;
  }

  .btn-primary-custom:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 10px rgba(255, 138, 101, 0.4);
  }

  .btn-outline-custom {
    background: #fff;
    color: var(--color-primary);
    border: 2px solid var(--color-primary);
  }

  .btn-outline-custom:hover {
    background: var(--color-primary);
    color: #fff;
  }

  /* ==== ALERTS ==== */
  .alert-custom {
    border-radius: 10px;
    border-left: 4px solid;
    padding: 10px 14px;
    margin-bottom: 12px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .alert-warning-custom {
    background: #fff4e6;
    border-color: #f57c00;
    color: #f57c00;
  }

  .alert-info-custom {
    background: var(--color-primary-soft);
    border-color: var(--color-primary);
    color: var(--color-primary-dark);
  }

  /* ==== TIMELINE ==== */
  .timeline {
    position: relative;
    padding-left: 30px;
  }

  .timeline::before {
    content: "";
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e0e0e0;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 20px;
  }

  .timeline-marker {
    position: absolute;
    left: -26px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid var(--color-primary);
  }

  .timeline-marker.completed {
    background: #4caf50;
    border-color: #4caf50;
  }

  .timeline-marker.active {
    background: var(--color-primary);
    border-color: var(--color-primary);
    box-shadow: 0 0 0 4px rgba(255, 138, 101, 0.2);
  }

  .timeline-content {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 10px;
  }

  .timeline-content.completed {
    background: #d6f5d6;
  }

  .timeline-content.active {
    background: var(--color-primary-soft);
    border: 2px solid var(--color-primary);
  }

  .timeline-time {
    font-size: 0.85rem;
    color: #999;
    margin-bottom: 4px;
    font-weight: 600;
  }

  .timeline-text {
    color: #333;
    font-size: 0.95rem;
  }

  /* ==== RESPONSIVE ==== */
  @media (max-width: 576px) {
    .tour-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .tour-status {
      align-self: flex-start;
    }

    .card-section {
      padding: 18px;
    }
  }
</style>