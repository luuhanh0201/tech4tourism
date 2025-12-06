<div class="container new-tour-page py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Thêm tour mới</h2>
            <p class="text-muted mb-0 small">Nhập đầy đủ thông tin để tạo tour du lịch mới</p>
        </div>
        <a href="/dashboard/tours-manager" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <form method="post" enctype="multipart/form-data">
        <?php if (!empty($_SESSION['error'])): ?>
            <p class="text-danger"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-lg-6 d-flex">
                <div class="card-section">
                    <h5 class="card-section-title section-header-bar">Thông tin cơ bản</h5>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Tên tour</label>
                            <input type="text" name="tour_name" class="form-control form-control-rounded"
                                placeholder="Tour du lịch Quảng Bình">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Danh mục tour</label>
                            <select name="category_id" class="form-select form-control-rounded" required>
                                <option value="0" selected>Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" rows="4" class="form-control form-control-rounded"
                                placeholder="Nhập mô tả chi tiết về tour..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lịch trình -->
            <div class="col-lg-6 d-flex">
                <div class="card-section">
                    <h5 class="card-section-title section-header-bar">Lịch trình</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Số ngày</label>
                            <input type="number" name="duration_day" min="1" class="form-control form-control-rounded"
                                placeholder="Ví dụ: 5">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số đêm</label>
                            <input type="number" name="duration_night" min="0" class="form-control form-control-rounded"
                                placeholder="Ví dụ: 4">
                        </div>


                        <div class="col-md-6">
                            <label class="form-label">Điểm khởi hành</label>
                            <input type="text" name="start_location" class="form-control form-control-rounded"
                                placeholder="Hà Nội, Hồ Chí Minh...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Điểm kết thúc</label>
                            <input type="text" name="end_location" class="form-control form-control-rounded"
                                placeholder="Đà Nẵng, Phú Quốc...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin khác -->
            <div class="col-lg-6 d-flex">
                <div class="card-section h-100 w-100">
                    <h5 class="card-section-title section-header-bar">Thông tin khác</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Giá tour</label>
                            <div class="input-group">
                                <input type="number" name="price" min="0" step="1000" class="form-control"
                                    placeholder="Ví dụ: 3500000">
                                <span class="input-group-text ">đ</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Chính sách hủy tour</label>
                            <textarea name="cancellation_policy" rows="3" class="form-control form-control-rounded"
                                placeholder="Quy định về hoàn/huỷ/đổi tour..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hình ảnh -->
            <div class="col-lg-6 d-flex ">
                <div class="card-section upload-box">
                    <h5 class="card-section-title">Hình ảnh</h5>

                    <div class="upload-box text-center upload-inner">
                        <input type="file" name="image" id="tourImage" class="d-none">
                        <label for="tourImage" class="upload-inner">
                            <div class="upload-icon mb-2">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="upload-text-main">Tải ảnh đại diện cho tour</div>
                            <div class="upload-text-sub">Kéo thả vào đây hoặc nhấn để chọn file</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <button type="submit" style="color: white; background-color:#ff8a65; border:none;"
                class="btn btn-primary px-4 py-2">Thêm
                Tour Mới</button>
        </div>
    </form>
</div>

<style>
    .upload-box {
        width: 100%;
        border-radius: 16px;
        border: 1px dashed #e5e7eb;
        background: #f9fafb;
        padding: 26px 24px;
    }

    .upload-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 180px;
        cursor: pointer;
    }

    .new-tour-page {
        padding-top: 10px;
        padding-bottom: 40px;
    }

    .card-section {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 20px 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
    }

    .card-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 14px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .form-control-rounded,
    .form-select.form-control-rounded {
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        padding: 10px 14px;
        background-color: #ffffff;
        box-shadow: none;
    }

    textarea.form-control-rounded {
        border-radius: 8px;
        resize: vertical;
    }

    .form-control-rounded:focus,
    .form-select.form-control-rounded:focus {
        border-color: #ff8c00;
        box-shadow: 0 0 0 0.15rem rgba(255, 140, 0, 0.25);
        outline: none;
    }

    /* upload box */
    .upload-box {
        border-radius: 16px;
        border: 1px dashed #e5e7eb;
        background: #f9fafb;
        padding: 26px 16px;
    }

    .upload-inner {
        display: block;
        cursor: pointer;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(148, 64, 0, 0.35);
    }

    .upload-text-main {
        font-weight: 600;
        font-size: 14px;
        color: #111827;
    }

    .upload-text-sub {
        font-size: 12px;
        color: #9ca3af;
    }

    .btn-save-tour {
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        border: none;
        color: #ffffff;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 999px;
        box-shadow: 0 10px 26px rgba(148, 64, 0, 0.4);
        font-size: 14px;
    }

    .btn-save-tour:hover {
        color: #ffffff;
        opacity: 0.96;
        transform: translateY(-1px);
        box-shadow: 0 14px 32px rgba(148, 64, 0, 0.45);
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