<form class="container py-5" method="post">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Danh Sách Khách Hàng</h1>
        <a href="/guide/current-tour" class="btn btn-outline-primary">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <!-- Summary Card -->
    <div class="status-card d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <div class="status-icon-circle">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="status-subtitle">Tổng số khách</div>
                <div class="status-title"><?= count($customers) ?> người</div>
            </div>
        </div>
    </div>

    <!-- Tour Info -->
    <div class="card tour-card">
        <div class="card-body p-4">
            <div class="tour-title"><?= htmlspecialchars($currentTour['tour_name']) ?></div>
            <div class="tour-sub">
                <?= $currentTour['assignment_started_at'] ?> - <?= $currentTour['assignment_ended_at'] ?>
            </div>
            <div class="mt-3">
                <span class="pill-day">
                    <i class="fa-solid fa-ticket me-2"></i><?= htmlspecialchars($currentTour['booking_code']) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Customer List -->
    <div class="card timeline-card">
        <div class="card-body p-4">
            <div class="timeline-title mb-4">
                <i class="fa-solid fa-address-book me-2"></i>
                Chi Tiết Khách Hàng
            </div>

            <?php if (empty($customers)): ?>
                <div class="text-center py-5">
                    <i class="fa-solid fa-user-slash" style="font-size: 64px; color: #e5e7eb;"></i>
                    <div class="mt-3 text-muted">Chưa có thông tin khách hàng</div>
                </div>
            <?php else: ?>
                <div class="row gx-4 gy-4">
                    <?php foreach ($customers as $index => $customer): ?>
                        <div class="col-md-4">
                            <div class="customer-item">
                                <div class="customer-header">
                                    <div class="customer-avatar">
                                        <?php if ($customer['gender'] === 'male'): ?>
                                            <i class="fa-solid fa-person"></i>
                                        <?php else: ?>
                                            <i class="fa-solid fa-person-dress"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="customer-name">
                                            <?= ($index + 1) ?>. <?= htmlspecialchars($customer['full_name']) ?>
                                        </div>
                                        <div class="customer-type">
                                            <span class="type-badge type-<?= $customer['gender'] ?>">
                                                <i
                                                    class="fa-solid fa-<?= $customer['gender'] === 'male' ? 'mars' : 'venus' ?> me-1"></i>
                                                <?= $customer['gender'] === 'male' ? 'Nam' : 'Nữ' ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="customer-check">
                                        <input type="hidden" name="checkin[<?= $customer['id'] ?>]" value="0">
                                        <input type="checkbox" name="checkin[<?= $customer['id'] ?>]" value="1"
                                            <?= $customer['is_checkin'] == 1 ? 'checked' : '' ?>>
                                    </div>
                                </div>

                                <div class="customer-details">
                                    <?php if (!empty($customer['phone'])): ?>
                                        <div class="detail-item">
                                            <i class="fa-solid fa-phone"></i>
                                            <span><?= htmlspecialchars($customer['phone']) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($customer['date_of_birth'])): ?>
                                        <div class="detail-item">
                                            <i class="fa-solid fa-cake-candles"></i>
                                            <span><?= date('d/m/Y', strtotime($customer['date_of_birth'])) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($customer['note_detail'])): ?>
                                        <div class="detail-item special-note">
                                            <i class="fa-solid fa-notes-medical"></i>
                                            <span><?= nl2br(htmlspecialchars($customer['note_detail'])) ?></span>
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

    <!-- Action Buttons -->
    <div class="row g-3">
        <div class="col-md-6">
            <button type="submit" class="btn action-btn action-green" id="">
                <i class="fa-solid fa-check-double me-2"></i>
                Lưu điểm danh
            </button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn action-btn action-blue" id="exportBtn">
                <i class="fa-solid fa-file-export me-2"></i>
                Xuất Danh Sách
            </button>
        </div>
    </div>
</form>

<style>
    .tour-card {
        border: 1px solid #e9ecef;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(0, 0, 0, .06);
        overflow: hidden;
    }

    .tour-card .card-body {
        position: relative;
    }

    /* điểm nhấn bên trái */
    .tour-card .card-body::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: #2f6fed;
        border-radius: 16px 0 0 16px;
    }

    .tour-title {
        font-size: 22px;
        font-weight: 800;
        color: #212529;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .tour-sub {
        font-size: 14px;
        color: #6c757d;
        line-height: 1.4;
    }

    /* pill mã booking */
    .pill-day {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: #f1f5ff;
        border: 1px solid #dbe7ff;
        color: #2f6fed;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: .2px;
    }

    .pill-day i {
        font-size: 14px;
    }

    .action-btn {
        width: 100%;
        height: 54px;
        /* 2 nút bằng chiều cao nhau */
        border: 0;
        border-radius: 14px;
        font-weight: 700;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 0 16px;
        transition: transform .15s ease, box-shadow .2s ease, filter .2s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    /* Icon size */
    .action-btn i {
        font-size: 16px;
    }

    /* Hover/active */
    .action-btn:hover {
        transform: translateY(-1px);
        filter: brightness(1.02);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .12);
    }

    .action-btn:active {
        transform: translateY(0px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, .10);
    }

    /* Focus for accessibility */
    .action-btn:focus {
        outline: none;
    }

    .action-btn:focus-visible {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .25), 0 8px 20px rgba(0, 0, 0, .08);
    }

    /* Colors */
    .action-green {
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: #fff;
    }

    .action-blue {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        color: #fff;
    }

    .customer-grid {
        display: grid;
        gap: 16px;
    }

    .customer-item {
        border-radius: 16px;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        padding: 18px;
        transition: all 0.3s ease;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .customer-item:hover {
        border-color: #ff8c00;
        box-shadow: 0 8px 24px rgba(255, 140, 0, 0.15);
        transform: translateY(-2px);
    }

    .customer-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .customer-name {
        font-size: 16px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .customer-type {
        display: flex;
        gap: 6px;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
    }

    .type-male {
        background: #e5f0ff;
        color: #1d4ed8;
    }

    .type-female {
        background: #fef2f2;
        color: #dc2626;
    }

    .customer-check {
        flex-shrink: 0;
    }

    .customer-check .form-check-input {
        width: 22px;
        height: 22px;
        cursor: pointer;
        border: 2px solid #d1d5db;
    }

    .customer-check .form-check-input:checked {
        background-color: #16a34a;
        border-color: #16a34a;
    }

    .customer-details {
        display: grid;
        gap: 10px;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        color: #374151;
    }

    .detail-item i {
        width: 18px;
        color: #ff8c00;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .detail-item.special-note {
        background: #fffbeb;
        border-left: 3px solid #facc15;
        padding: 10px 12px;
        border-radius: 8px;
        margin-top: 6px;
    }

    .detail-item.special-note i {
        color: #facc15;
    }

    .status-card {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 14px 16px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        gap: 12px;
    }

    .status-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        background: #f1f5ff;
        border: 1px solid #dbe7ff;
        margin-right: 12px;
    }

    .status-icon-circle i {
        font-size: 18px;
        color: #2f6fed;
    }

    .status-subtitle {
        font-size: 12px;
        color: #6c757d;
        line-height: 1.2;
        margin-bottom: 3px;
    }

    .status-title {
        font-size: 20px;
        font-weight: 700;
        color: #212529;
        line-height: 1.2;
    }
</style>

<script>
    // Điểm danh từng khách
    document.querySelectorAll('.customer-check input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const customerId = this.dataset.customerId;
            const isChecked = this.checked;

            // TODO: Gửi AJAX request để cập nhật trạng thái điểm danh
            console.log(`Customer ${customerId} checked: ${isChecked}`);
        });
    });



</script>