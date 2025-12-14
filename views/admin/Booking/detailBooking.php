<?php
$status = $booking['status'];
$mapStatus = [
    'confirmed' => ['class' => 'status-confirmed', 'label' => 'Đã xác nhận'],
    'pending' => ['class' => 'status-pending', 'label' => 'Chờ xác nhận'],
    'done' => ['class' => 'status-done', 'label' => 'Đã hoàn thành'],
    'canceled' => ['class' => 'status-canceled', 'label' => 'Đã Huỷ'],
];
$data = $mapStatus[$status] ?? ['class' => 'status-unknown', 'label' => $status];

$paymentStatus = $booking['payment_status'];
$mapPaymentStatus = [
    'cash' => "Tiền mặt",
    'transfer' => "Chuyển khoản",
    'card' => "Thẻ",
];
$dataPaymentStatus = $mapPaymentStatus[$paymentStatus] ?? "Chưa xác định";

// Format ngày tháng
$departureDate = isset($booking['departure_date']) ? date('d/m/Y', strtotime($booking['departure_date'])) : '--';
$returnDate = isset($booking['ended_at']) ? date('d/m/Y', strtotime($booking['ended_at'])) : '--';
$totalPrice = floatval($booking['total_price']);
?>

<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Chi Tiết Booking #<?= $booking['booking_code'] ?></h2>
            <p class="text-muted mb-0">Ngày tạo: <?= date('d/m/Y H:i', strtotime($booking['booking_date'])) ?></p>
        </div>
        <div class="d-flex gap-2">
            <?php if ($booking['status'] !== "canceled" && $booking['status'] !== "done"): ?>
                <a href="/dashboard/booking-manager/edit-booking?id=<?= $booking['id'] ?>" class="btn btn-warning">
                    <i class="fa-solid fa-pen me-2"></i>Chỉnh Sửa
                </a>
            <?php endif ?>
            <a href="/dashboard/booking-manager" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Quay Lại
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Cột trái -->
        <div class="col-lg-8">
            <!-- Thông tin Tour -->
            <div class="card-section mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">
                        <i class="fa-solid fa-map-location-dot me-2"></i>Thông Tin Tour
                    </h5>
                    <span class="status-badge <?= $data['class'] ?>">
                        <?= htmlspecialchars($data['label']) ?>
                    </span>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="info-card">
                            <div class="tour-header">
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-bold"><?= htmlspecialchars($tour['tour_name']) ?> -
                                        <?= $tour['duration_day'] ?> ngày <?= $tour['duration_night'] ?> đêm</h6>
                                    <div class="tour-meta">
                                        <span><i class="fa-solid fa-calendar me-1"></i><?= $departureDate ?> -
                                            <?= $returnDate ?></span>
                                        <span><i class="fa-solid fa-clock me-1"></i><?= $tour['duration_day'] ?> ngày
                                            <?= $tour['duration_night'] ?> đêm</span>
                                        <span><i class="fa-solid fa-users me-1"></i><?= count($customers) + 1 ?>
                                            người</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="tour-price"><?= number_format($tour['price'], 0, ',', '.') ?>đ</div>
                                    <small class="text-muted">Giá/người</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Điểm khởi hành:</span>
                            <span class="value"><?= htmlspecialchars($tour['start_location']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Điểm đến:</span>
                            <span class="value"><?= htmlspecialchars($tour['end_location']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Hướng dẫn viên:</span>
                            <span class="value">
                                <?php if (isset($guide['full_name']) && !empty($guide['full_name'])): ?>
                                    <a href="#" class="text-primary"><?= htmlspecialchars($guide['full_name']) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">Chưa phân công</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thông tin Khách hàng -->
            <div class="card-section mb-4">
                <h5 class="section-title">
                    <i class="fa-solid fa-user me-2"></i>Thông tin người đại diện
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Họ và tên:</span>
                            <span class="value fw-bold"><?= htmlspecialchars($booking['contact_name']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item">
                            <span class="label">Số điện thoại:</span>
                            <span class="value">
                                <a href="tel:<?= $booking['contact_phone'] ?>"
                                    class="text-primary"><?= htmlspecialchars($booking['contact_phone']) ?></a>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="info-item">
                            <span class="label">Email:</span>
                            <span class="value">
                                <?php if (!empty($booking['contact_email'])): ?>
                                    <a href="mailto:<?= $booking['contact_email'] ?>"
                                        class="text-primary"><?= htmlspecialchars($booking['contact_email']) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">Chưa có</span>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danh sách Khách tham gia -->
            <div class="card-section mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title mb-0">
                        <i class="fa-solid fa-users me-2"></i>Danh Sách Khách Tham Gia (<?= count($customers) ?>)
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#checkInModal">
                        <i class="fa-solid fa-user-check me-2"></i>Check-in
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Họ và Tên</th>
                                <th>Số điện thoại</th>
                                <th>Giới Tính</th>
                                <th>Ghi chú</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $index => $customer): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($customer['full_name']) ?></td>
                                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                                    <td><?= $customer['gender'] === 'male' ? "Nam" : "Nữ" ?></td>
                                    <td><?= htmlspecialchars($customer['note_detail'] ?? '') ?></td>
                                    <td>
                                        <span class="badge <?= $customer['is_checkin'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <i
                                                class="fa-solid <?= $customer['is_checkin'] ? 'fa-check' : 'fa-clock' ?> me-1"></i>
                                            <?= $customer['is_checkin'] ? "Đã check-in" : "Chưa check-in" ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ghi chú đặc biệt -->
            <?php if (!empty($booking['notes'])): ?>
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-clipboard me-2"></i>Ghi Chú Đặc Biệt Của Đoàn
                    </h5>
                    <div class="special-notes">
                        <p><?= nl2br(htmlspecialchars($booking['notes'])) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cột phải -->
        <div class="col-lg-4">
            <!-- Thanh toán -->
            <div class="card-section summary-card mb-4">
                <h5 class="section-title">
                    <i class="fa-solid fa-file-invoice-dollar me-2"></i>Thông Tin Thanh Toán
                </h5>

                <div class="summary-item">
                    <div>
                        <span>Tổng <?= count($customers) + 1 ?> khách:</span>
                        <br>
                        <small class="text-muted"><?= count($customers) + 1 ?> ×
                            <?= number_format($tour['price'], 0, ',', '.') ?>đ</small>
                    </div>
                    <strong><?= number_format($totalPrice, 0, ',', '.') ?>đ</strong>
                </div>

                <hr>

                <div class="summary-total">
                    <span>Tổng thanh toán:</span>
                    <strong><?= number_format($totalPrice, 0, ',', '.') ?>đ</strong>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Phương thức thanh toán:</small>
                        <span class="badge bg-primary"><?= $dataPaymentStatus ?></span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="fa-solid fa-money-bill-wave me-2"></i>Xác Nhận Thanh Toán
                    </button>
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fa-solid fa-receipt me-2"></i>In Hóa Đơn
                    </button>
                </div>
            </div>

            <!-- Hành động nhanh -->
            <?php if ($booking['status'] !== 'canceled' && $booking['status'] !== "done"): ?>
                <form method="post" class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-bolt me-2"></i>Hành Động Nhanh
                    </h5>
                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">

                    <div class="d-grid gap-2">
                        <button type="submit" name="action" value="send_info" class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-paper-plane me-2"></i>Gửi Thông Tin Tour
                        </button>

                        <button type="submit" name="action" value="send_email" class="btn btn-outline-info btn-sm">
                            <i class="fa-solid fa-envelope me-2"></i>Gửi Email Xác Nhận
                        </button>

                        <button type="submit" name="action" value="remind" class="btn btn-outline-warning btn-sm">
                            <i class="fa-solid fa-bell me-2"></i>Nhắc Nhở Khách
                        </button>

                        <hr>

                        <!-- NÚT HỦY BOOKING -->
                        <button type="submit" name="action" value="cancel" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Bạn chắc chắn muốn hủy booking này?');">
                            <i class="fa-solid fa-ban me-2"></i>Hủy Booking
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="card-section mb-4">
                    <div class="alert alert-info mb-0">
                        <i class="fa-solid fa-info-circle me-2"></i>
                        Booking này đã <?= $booking['status'] === 'done' ? 'hoàn thành' : 'bị hủy' ?> và không thể thực hiện
                        thêm hành động.
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<style>
    .card-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        color: #333;
        font-weight: 700;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title i {
        color: var(--color-primary);
    }

    .status-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-confirmed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-done {
        background-color: #dbeafe;
        color: #1e3a8a;
    }

    .status-canceled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .status-unknown {
        background-color: #e5e7eb;
        color: #374151;
    }

    .info-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid var(--color-primary);
    }

    .tour-header {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .tour-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.875rem;
        color: var(--color-text-sub);
    }

    .tour-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-primary);
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item .label {
        color: var(--color-text-sub);
        font-weight: 500;
    }

    .info-item .value {
        color: #333;
        font-weight: 600;
        text-align: right;
    }

    .special-notes {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        color: #555;
    }

    .summary-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 2px solid var(--color-primary);
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 0.95rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--color-primary);
    }

    .btn-primary {
        background-color: var(--color-primary);
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: var(--color-primary-dark);
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #555;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    @media (max-width: 991px) {
        .tour-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .tour-price {
            font-size: 1.2rem;
        }
    }

    @media print {

        .btn,
        .card-section:last-child {
            display: none !important;
        }
    }
</style>