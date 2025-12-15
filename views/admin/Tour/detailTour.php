<div class="container py-5">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Chi Tiết Tour</h2>
            <p class="text-muted mb-0 card-section-title">Xem thông tin chi tiết tour du lịch</p>
        </div>
        <a href="/dashboard/tours-manager" class="btn btn-outline-secondary px-4">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>
    <div class="row g-4">
        <!-- CỘT ẢNH + THÔNG TIN CƠ BẢN -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <!-- Ảnh tour -->
                <img src="<?= BASE_URL . $tour['image_url'] ?>" class="card-img-top" alt="Tên tour">

                <div class="card-body">
                    <!-- Tên tour -->
                    <h4 class="card-title fw-bold mb-2 ">
                        <?= $tour['tour_name'] ?>
                    </h4>

                    <!-- Trạng thái -->
                    <span
                        class="<?= $tour['status'] === "active" ? "status-active" : "status-stop"; ?> mb-2 d-inline-block">
                        <?= $tour['status'] === "active" ? "Hoạt động" : "Ngừng hoạt động"; ?>
                    </span>

                    <!-- Giá -->
                    <div class="mt-3">
                        <div class="fw-semibold text-muted small mb-1">Giá tour</div>
                        <div class="fs-5 fw-bold text-danger">
                            <?= number_format($tour['price'], 0, ',', '.') . ' ₫' ?>
                        </div>
                    </div>

                    <!-- Mã tour + Danh mục -->
                    <div class="mt-3 small text-muted">

                        <div><strong>Danh mục:</strong><?= $tour['category_name'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CỘT THÔNG TIN CHI TIẾT -->
        <div class="col-md-8">
            <!-- Thông tin hành trình -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 section-header-bar">Thông tin hành trình</h5>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small fw-semibold">Thời lượng</div>
                            <div><?= $tour['duration_day'] ?> ngày - <?= $tour['duration_night'] ?> đêm</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small fw-semibold">Tình trạng tour</div>
                            <div>Đang mở bán</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small fw-semibold">Điểm khởi hành</div>
                            <div><?= $tour['start_location'] ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="text-muted small fw-semibold">Điểm kết thúc</div>
                            <div><?= $tour['end_location'] ?></div>
                        </div>
                    </div>

                    <hr>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <div class="text-muted small fw-semibold mb-1">Mô tả tour</div>
                        <p class="mb-0">
                            <?= $tour['description'] ?>
                        </p>
                    </div>

                    <!-- Chính sách hủy -->
                    <div>
                        <div class="text-muted small fw-semibold mb-1">Chính sách hủy tour</div>
                        <p class="mb-0">
                            <?= $tour['cancellation_policy'] ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="section-title mb-4">
                        <i class="fa-solid fa-route me-2"></i>Lịch trình chi tiết
                    </h5>

                    <?php

                    if (isset($tourItineraries) && count($tourItineraries) > 0):
                        foreach ($tourItineraries as $index => $day): ?>
                            <div class="itinerary-day">
                                <div class="day-marker">
                                    <div class="day-circle">
                                        <span><?= $day['day_number'] ?></span>
                                    </div>
                                    <?php if ($index < count($tourItineraries) - 1): ?>
                                        <div class="day-line"></div>
                                    <?php endif; ?>
                                </div>

                                <!-- Nội dung chi tiết ngày -->
                                <div class="day-content">
                                    <div class="day-header">
                                        <h6 class="day-title mb-1">
                                            <span class="badge bg-primary me-2">Ngày <?= $day['day_number'] ?></span>
                                            <?= htmlspecialchars($day['title']) ?>
                                        </h6>
                                        <div class="day-time">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            <?= date('H:i', strtotime($day['start_time'])) ?> -
                                            <?= date('H:i', strtotime($day['end_time'])) ?>
                                        </div>
                                    </div>
                                    <p class="day-description">
                                        <?= nl2br(htmlspecialchars($day['description'])) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach;
                    else: ?>
                        <!-- Trường hợp chưa có lịch trình -->
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-calendar-xmark fa-3x mb-3"></i>
                            <p class="mb-0">Chưa có lịch trình chi tiết cho tour này</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Thông tin hệ thống -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3 section-header-bar">Thông tin hệ thống</h6>
                    <div class="row small text-muted">
                        <div class="col-md-6 mb-2">
                            <strong>Ngày tạo:</strong> <?= $tour['created_at'] ?>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Cập nhật lần cuối:</strong> <?= $tour['updated_at'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .status-active {
        background: #D6F5D6;
        color: #1A8F1A;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-stop {
        background: #FFD6D6;
        color: #CC3333;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
    }

    .section-header-bar {
        background-color: #ff8c00;
        color: #ffffff;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 12px;
    }

    .section-title {
        color: #ff8c00;
        font-weight: 700;
        font-size: 18px;
        padding-bottom: 10px;
        border-bottom: 3px solid #ff8c00;
        display: inline-block;
    }

    /* Itinerary timeline container */
    .itinerary-day {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        position: relative;
    }

    .itinerary-day:last-child {
        margin-bottom: 0;
    }

    /* Day marker (số ngày bên trái) */
    .day-marker {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .day-circle {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ff8c00 0%, #ff6600 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
        box-shadow: 0 4px 8px rgba(255, 140, 0, 0.3);
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .day-circle:hover {
        transform: scale(1.1);
    }

    .day-line {
        width: 3px;
        flex-grow: 1;
        background: linear-gradient(180deg, #ff8c00 0%, #ffb84d 100%);
        margin-top: 5px;
        min-height: 30px;
    }

    /* Day content (nội dung bên phải) */
    .day-content {
        flex-grow: 1;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .day-content:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateX(5px);
        background: #ffffff;
    }


    .day-title {
        font-size: 16px;
        font-weight: 700;
        color: #212529;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .day-title .badge {
        font-size: 12px;
        padding: 6px 12px;
    }

    .day-time {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }

    .day-time i {
        color: #ff8c00;
    }

    /* Day description */
    .day-description {
        color: #495057;
        line-height: 1.7;
        margin: 0;
        font-size: 14px;
        white-space: pre-line;
    }

    /* Empty state */
    .text-center.text-muted i {
        color: #dee2e6;
    }
</style>