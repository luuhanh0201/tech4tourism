<?php
$status = $booking['status'];

$mapStatus = [
    'confirmed' => ['class' => 'status-confirmed', 'label' => 'Đã xác nhận'],
    'pending' => ['class' => 'status-pending', 'label' => 'Chờ xác nhận'],
    'done' => ['class' => 'status-done', 'label' => 'Đã hoàn thành'],
    'canceled' => ['class' => 'status-canceled', 'label' => 'Đã Huỷ'],
];

$data = $mapStatus[$status] ?? ['class' => 'status-unknown', 'label' => $status];

// Format ngày tháng
$departureDate = isset($booking['departure_date']) ? date('d/m/Y', strtotime($booking['departure_date'])) : '--';
$returnDate = isset($booking['ended_at']) ? date('d/m/Y', strtotime($booking['ended_at'])) : '--';
?>
<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Chỉnh Sửa Booking #<?= $booking['booking_code'] ?></h2>
            <p class="text-muted mb-0">Ngày tạo: <?= date('d/m/Y H:i', strtotime($booking['booking_date'])) ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="/dashboard/booking-manager" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Quay Lại
            </a>
        </div>
    </div>

    <form method="POST">
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
                                        <h6 class="mb-2 fw-bold">
                                            <?= htmlspecialchars($tour['tour_name']) ?> -
                                            <?= $tour['duration_day'] ?> ngày
                                            <?= $tour['duration_night'] ?> đêm
                                        </h6>
                                        <div class="tour-meta">
                                            <span><i class="fa-solid fa-calendar me-1"></i><?= $departureDate ?> -
                                                <?= $returnDate ?></span>
                                            <span><i class="fa-solid fa-clock me-1"></i><?= $tour['duration_day'] ?>
                                                ngày <?= $tour['duration_night'] ?> đêm</span>
                                            <span><i class="fa-solid fa-users me-1"></i><span
                                                    id="totalGuestsDisplay"><?= count($customers) + 1 ?></span>
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
                            <div class="mb-3">
                                <label class="form-label">Điểm khởi hành:</label>
                                <input type="text" class="form-control" name="departure_point"
                                    value="<?= htmlspecialchars($tour['start_location']) ?>" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Điểm đến:</label>
                                <input type="text" class="form-control" name="destination"
                                    value="<?= htmlspecialchars($tour['end_location']) ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin Khách hàng đại diện -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-user me-2"></i>Thông Tin Người Đại Diện
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên: <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="contact_name"
                                    value="<?= htmlspecialchars($booking['contact_name']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Số điện thoại: <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="contact_phone"
                                    value="<?= htmlspecialchars($booking['contact_phone']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="contact_email"
                                    value="<?= htmlspecialchars($booking['contact_email'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách Khách tham gia -->
                <div class="card-section mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="section-title mb-0">
                            <i class="fa-solid fa-users me-2"></i>Danh Sách Khách Tham Gia (<span
                                id="customerCount"><?= count($customers) ?></span>)
                        </h5>
                    </div>
                    <div id="customerList">
                        <?php foreach ($customers as $index => $customer): ?>
                            <div class="guest-item mb-3" data-index="<?= $index ?>">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong>Khách #<?= $index + 1 ?> -
                                        <?= htmlspecialchars($customer['full_name']) ?> -
                                        <?= htmlspecialchars($customer['phone']) ?>
                                    </strong>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-link btn-sm toggle-details">
                                            <i class="fa-solid fa-eye"></i> Xem
                                        </button>
                                        <button type="button" class="btn btn-link btn-sm text-danger delete-guest">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                                <div class="row guest-details d-none">
                                    <input type="hidden" name="customer[<?= $index ?>][id]" value="<?= $customer['id'] ?>">
                                    <div class="col-md-6 mb-2">
                                        <input type="text" class="form-control"
                                            name="customer[<?= $index ?>][customer_name]" placeholder="Họ và tên"
                                            value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="tel" class="form-control"
                                            name="customer[<?= $index ?>][customer_phone]" placeholder="Số điện thoại"
                                            value="<?= htmlspecialchars($customer['phone']) ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <input type="date" class="form-control"
                                            name="customer[<?= $index ?>][date_of_birth]" placeholder="Ngày sinh"
                                            value="<?= $customer['date_of_birth'] ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <select class="form-select" name="customer[<?= $index ?>][gender]">
                                            <option value="male" <?= $customer['gender'] === 'male' ? 'selected' : '' ?>>Nam
                                            </option>
                                            <option value="female" <?= $customer['gender'] === 'female' ? 'selected' : '' ?>>Nữ
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ghi Chú Chi Tiết</label>
                                        <textarea class="form-control" name="customer[<?= $index ?>][customer_note_detail]"
                                            rows="4"
                                            placeholder="Nhập các yêu cầu đặc biệt khác..."><?= htmlspecialchars($customer['note_detail'] ?? '') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="addGuestBtn">
                        <i class="fa-solid fa-plus me-2"></i>Thêm Khách
                    </button>
                </div>

                <!-- Ghi chú đặc biệt -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-clipboard me-2"></i>Ghi Chú Đặc Biệt Của Đoàn
                    </h5>
                    <textarea class="form-control" name="booking_note" rows="4"
                        placeholder="Nhập ghi chú đặc biệt..."><?= htmlspecialchars($booking['notes'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="col-lg-4">
                <!-- Trạng thái & Hướng dẫn viên -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-cog me-2"></i>Cài Đặt Booking
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái booking:</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" <?= $booking['status'] === 'pending' ? 'selected' : '' ?>>Chờ xác nhận
                            </option>
                            <option value="confirmed" <?= $booking['status'] === 'confirmed' ? 'selected' : '' ?>>Đã xác
                                nhận</option>
                            <option value="done" <?= $booking['status'] === 'done' ? 'selected' : '' ?>>Đã hoàn thành
                            </option>
                            <option value="canceled" <?= $booking['status'] === 'canceled' ? 'selected' : '' ?>>Đã hủy
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phân công hướng dẫn viên:</label>
                        <select class="form-select" name="guide_id">
                            <option value="">-- Chưa phân công --</option>
                            <?php foreach ($guides as $guide): ?>
                                <?php if ($guide['status'] === "Trống lịch"): ?>
                                    <option value="<?= $guide['id'] ?>" <?= (isset($booking['guide_id']) && $booking['guide_id'] == $guide['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($guide['full_name']) ?> - <?= htmlspecialchars($guide['phone']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach ?>
                        </select>

                        <!-- Ghi chú nhỏ cho HDV -->
                        <label class="form-label mb-1 mt-3">Ghi chú cho hướng dẫn viên:</label>
                        <textarea class="form-control" name="guide_note" rows="2"
                            placeholder="Ghi chú..."><?= htmlspecialchars($booking['guide_note'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày khởi hành:</label>
                        <input type="date" class="form-control" name="departure_date" id="departureDate"
                            value="<?= $booking['departure_date'] ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc:</label>
                        <input type="date" class="form-control" name="ended_at" id="endedAt"
                            value="<?= $booking['ended_at'] ?? '' ?>" readonly>
                    </div>
                </div>

                <!-- Thanh toán -->
                <div class="card-section summary-card mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Thông Tin Thanh Toán
                    </h5>

                    <div class="summary-item">
                        <span>Số lượng khách:</span>
                        <strong id="totalGuests"><?= count($customers) + 1 ?> người</strong>
                    </div>

                    <div class="summary-item">
                        <span>Giá/người:</span>
                        <strong><?= number_format($tour['price'], 0, ',', '.') ?>đ</strong>
                    </div>

                    <hr>

                    <!-- Tổng thanh toán -->
                    <div class="summary-total">
                        <span>Tổng thanh toán:</span>
                        <strong id="finalTotal">
                            <?= number_format($booking['total_price'], 0, ',', '.') ?>đ
                        </strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán:</label>
                        <select class="form-select" name="payment_status">
                            <option value="transfer" <?= $booking['payment_status'] === 'transfer' ? 'selected' : '' ?>>
                                Chuyển khoản</option>
                            <option value="cash" <?= $booking['payment_status'] === 'cash' ? 'selected' : '' ?>>Tiền mặt
                            </option>
                            <option value="card" <?= $booking['payment_status'] === 'card' ? 'selected' : '' ?>>Thẻ tín
                                dụng</option>
                        </select>
                    </div>
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" name="total_price" id="totalPriceInput" value="<?= $booking['total_price'] ?>">

                <div class="card-section">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg"
                            onclick="return confirm('Mọi thay đổi sẽ không thể hoàn tác, bạn có chắc chắn?')">
                            <i class="fa-solid fa-save me-2"></i>Lưu Thay Đổi
                        </button>
                        <a href="/dashboard/booking-manager" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-times me-2"></i>Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const pricePerPerson = <?= $tour['price'] ?>;
    const durationDays = <?= (int) $tour['duration_day'] ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const customerList = document.getElementById('customerList');
        const addGuestBtn = document.getElementById('addGuestBtn');
        const departureInput = document.getElementById('departureDate');
        const endedAtInput = document.getElementById('endedAt');
        let guestIndex = customerList.querySelectorAll('.guest-item').length;

        // ========== HÀM CẬP NHẬT NGÀY KẾT THÚC ==========
        function updateEndDate() {
            const depVal = departureInput.value;
            if (!depVal) {
                endedAtInput.value = '';
                return;
            }

            // Parse ngày theo định dạng YYYY-MM-DD
            const parts = depVal.split('-');
            if (parts.length !== 3) {
                endedAtInput.value = '';
                return;
            }

            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10);
            const day = parseInt(parts[2], 10);

            const depDate = new Date(year, month - 1, day);
            if (isNaN(depDate.getTime())) {
                endedAtInput.value = '';
                return;
            }

            // Cộng thêm số ngày tour
            depDate.setDate(depDate.getDate() + durationDays);

            const y = depDate.getFullYear();
            const m = String(depDate.getMonth() + 1).padStart(2, '0');
            const d = String(depDate.getDate()).padStart(2, '0');

            endedAtInput.value = `${y}-${m}-${d}`;
        }

        // ========== HÀM TÍNH TỔNG TIỀN ==========
        function calculateTotal() {
            const customerRows = customerList.querySelectorAll('.guest-item').length;
            const totalGuests = customerRows + 1; // +1 người đại diện

            const totalPrice = totalGuests * pricePerPerson;

            // Cập nhật hiển thị
            document.getElementById('totalGuests').textContent = totalGuests + ' người';
            document.getElementById('totalGuestsDisplay').textContent = totalGuests;
            document.getElementById('customerCount').textContent = customerRows;
            document.getElementById('finalTotal').textContent = totalPrice.toLocaleString('vi-VN') + 'đ';

            // Cập nhật hidden input
            document.getElementById('totalPriceInput').value = totalPrice;
        }

        // ========== HÀM CẬP NHẬT LẠI SỐ THỨ TỰ KHÁCH ==========
        function updateGuestNumbers() {
            const guestItems = customerList.querySelectorAll('.guest-item');
            guestItems.forEach((item, index) => {
                const title = item.querySelector('strong');
                const name = item.querySelector('input[name*="[customer_name]"]')?.value || '';
                const phone = item.querySelector('input[name*="[customer_phone]"]')?.value || '';

                if (name && phone) {
                    title.textContent = `Khách #${index + 1} - ${name} - ${phone}`;
                } else {
                    title.textContent = `Khách #${index + 1}`;
                }
            });
        }

        // ========== XỬ LÝ TOGGLE CHI TIẾT KHÁCH ==========
        customerList.addEventListener('click', function (e) {
            if (e.target.classList.contains('toggle-details') || e.target.closest('.toggle-details')) {
                const button = e.target.closest('.toggle-details');
                const guestItem = button.closest('.guest-item');
                const details = guestItem.querySelector('.guest-details');
                const icon = button.querySelector('i');
                const text = button.childNodes[1]; // Text node sau icon

                if (details) {
                    const isHidden = details.classList.contains('d-none');

                    if (isHidden) {
                        // Đang ẩn -> Hiển thị
                        details.classList.remove('d-none');
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        // Đang hiện -> Ẩn
                        details.classList.add('d-none');
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                }
            }

            // ========== XỬ LÝ XÓA KHÁCH ==========
            if (e.target.classList.contains('delete-guest') || e.target.closest('.delete-guest')) {
                const guestItem = e.target.closest('.guest-item');
                const guestName = guestItem.querySelector('input[name*="[customer_name]"]')?.value || 'khách này';

                if (confirm(`Bạn có chắc chắn muốn xóa ${guestName}?`)) {
                    guestItem.remove();
                    updateGuestNumbers();
                    calculateTotal();
                }
            }
        });

        // ========== XỬ LÝ THÊM KHÁCH MỚI ==========
        addGuestBtn.addEventListener('click', function () {
            const lastGuest = customerList.querySelector('.guest-item:last-child');
            if (lastGuest) {
                const lastDetails = lastGuest.querySelector('.guest-details');
                if (lastDetails) lastDetails.classList.add('d-none');
            }

            const newGuestHtml = `
                <div class="guest-item mb-3" data-index="${guestIndex}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong>Khách #${guestIndex + 1}</strong>
                        <div class="btn-group">
                            <button type="button" class="btn btn-link btn-sm toggle-details">
                                <i class="fa-solid fa-eye"></i> 
                            </button>
                            <button type="button" class="btn btn-link btn-sm text-danger delete-guest">
                                <i class="fa-solid fa-trash"></i> 
                            </button>
                        </div>
                    </div>
                    <div class="row guest-details">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control"
                                name="customer[${guestIndex}][customer_name]"
                                placeholder="Họ và tên" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="tel" class="form-control"
                                name="customer[${guestIndex}][customer_phone]"
                                placeholder="Số điện thoại" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <input type="date" class="form-control"
                                name="customer[${guestIndex}][date_of_birth]"
                                placeholder="Ngày sinh" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <select class="form-select" name="customer[${guestIndex}][gender]">
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi Chú Chi Tiết</label>
                            <textarea class="form-control" name="customer[${guestIndex}][customer_note_detail]" rows="4"
                                placeholder="Nhập các yêu cầu đặc biệt khác..."></textarea>
                        </div>
                    </div>
                </div>`;

            customerList.insertAdjacentHTML('beforeend', newGuestHtml);
            guestIndex++;
            calculateTotal();
        });

        // ========== CẬP NHẬT TÊN KHÁCH KHI NHẬP ==========
        customerList.addEventListener('input', function (e) {
            if (e.target.matches('input[name*="[customer_name]"]') ||
                e.target.matches('input[name*="[customer_phone]"]')) {
                updateGuestNumbers();
            }
        });

        // ========== EVENT LISTENERS ==========
        departureInput.addEventListener('change', updateEndDate);

        // ========== KHỞI TẠO BAN ĐẦU ==========
        calculateTotal();
        updateEndDate();
    });
</script>

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

    .form-label {
        color: #555;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 0.2rem rgba(255, 138, 101, 0.25);
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

    .guest-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--color-primary);
        transition: all 0.3s ease;
    }

    .guest-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .guest-item strong {
        color: #333;
    }

    .btn-link {
        text-decoration: none;
        color: var(--color-primary);
        padding: 4px 8px;
        font-size: 0.875rem;
    }

    .btn-link:hover {
        color: var(--color-primary-dark);
    }

    .btn-link.text-danger {
        color: #dc3545 !important;
    }

    .btn-link.text-danger:hover {
        color: #c82333 !important;
    }

    .btn-group {
        display: flex;
        gap: 5px;
    }

    .text-danger {
        color: #dc3545;
    }

    @media (max-width: 991px) {
        .tour-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>