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
                <img src="https://via.placeholder.com/600x350?text=Anh+Tour" class="card-img-top" alt="Tên tour">

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
                        <div><strong>Mã tour:</strong> #T001</div>
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
</style>