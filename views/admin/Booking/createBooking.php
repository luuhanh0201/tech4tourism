<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Tạo Booking Mới</h2>
        <a href="/dashboard/booking-manager" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại
        </a>
    </div>

    <form method="POST" action="">
        <div class="row">
            <!-- Cột trái - Thông tin Tour -->
            <div class="col-lg-8">
                <!-- Thông tin Tour -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-map-location-dot me-2"></i>Thông Tin Tour
                    </h5>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Chọn Tour <span class="text-danger">*</span></label>
                            <select class="form-select" name="tour_id" id="tourSelect" required>
                                <option value="0" selected>-- Chọn tour --</option>
                                <?php foreach ($tours as $tour): ?>
                                    <?php if ($tour['status'] === "active"): ?>
                                        <option value="<?= $tour['id'] ?>" data-price="<?= $tour['price'] ?>"
                                            data-duration="<?= $tour['duration_day'] ?>"
                                            data-name="<?= htmlspecialchars($tour['tour_name']) ?>">
                                            <?= $tour['tour_name'] ?>
                                            (<?= $tour['duration_day'] ?> ngày - <?= $tour['duration_night'] ?> đêm)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày Khởi Hành <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="departure_date" id="departureDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ngày Kết Thúc</label>
                            <input type="date" class="form-control" name="return_date" id="returnDate" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ghi Chú</label>
                            <textarea class="form-control" name="booking_note" rows="4"
                                placeholder="Nhập các yêu cầu đặc biệt khác..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Thông tin Khách Hàng -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-user me-2"></i>Khách hàng đại diện
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_name" placeholder="Nguyễn Văn A"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Giới tính</label>
                            <select class="form-select" name="contact_gender">
                                <option value="male">Nam</option>
                                <option value="female">Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" name="contact_phone" placeholder="0912345678"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="contact_email"
                                placeholder="example@email.com">
                        </div>
                    </div>
                </div>

                <!-- Thêm khách hàng -->
                <div class="card-section mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-users me-2"></i>Danh Sách Khách Tham Gia
                    </h5>
                    <div id="customerList"></div>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="addGuestBtn">
                        <i class="fa-solid fa-plus me-2"></i>Thêm Khách
                    </button>
                </div>
            </div>

            <!-- Cột phải - Tổng Kết và Thanh Toán -->
            <div class="col-lg-4">
                <!-- Tổng Kết Booking -->
                <div class="card-section summary-card mb-4">
                    <h5 class="section-title">
                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>Tổng Kết
                    </h5>

                    <div class="summary-item">
                        <span>Tour đã chọn:</span>
                        <strong id="selectedTour">--</strong>
                    </div>
                    <div class="summary-item">
                        <span>Ngày khởi hành:</span>
                        <strong id="selectedDate">--</strong>
                    </div>
                    <div class="summary-item">
                        <span>Số lượng khách:</span>
                        <strong id="totalCustomer">1 người</strong>
                    </div>

                    <hr>

                    <div class="summary-total">
                        <span>Tổng Cộng:</span>
                        <span id="totalPrice">0 đ</span>
                    </div>

                    <input type="hidden" name="total_price" id="totalPriceInput" value="0">

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Phương Thức Thanh Toán</label>
                        <select class="form-select" name="payment_status">
                            <option value="cash">Tiền mặt</option>
                            <option value="transfer">Chuyển khoản</option>
                            <option value="card">Thẻ tín dụng</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng Thái</label>
                        <select class="form-select" name="status">
                            <option value="pending">Chờ xác nhận</option>
                            <option value="confirmed">Đã xác nhận</option>
                            <option value="done">Đã Hoàn thành</option>
                            <option value="canceled">Đã huỷ</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-save me-2"></i>Tạo Booking
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-rotate-left me-2"></i>Nhập Lại
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tourSelect = document.getElementById('tourSelect');
        const departureInput = document.getElementById('departureDate');
        const returnInput = document.getElementById('returnDate');
        const customerList = document.getElementById('customerList');
        const addGuestBtn = document.getElementById('addGuestBtn');
        const totalPriceDisplay = document.getElementById('totalPrice');
        const totalPriceInput = document.getElementById('totalPriceInput');
        const totalCustomerDisplay = document.getElementById('totalCustomer');
        const selectedTourDisplay = document.getElementById('selectedTour');
        const selectedDateDisplay = document.getElementById('selectedDate');

        let guestIndex = 0;

        function updateReturnDate() {
            const selectedOption = tourSelect.options[tourSelect.selectedIndex];
            const durationDays = Number(selectedOption?.dataset.duration || 0);

            if (!departureInput.value || !durationDays || tourSelect.value === '0') {
                returnInput.value = '';
                return;
            }

            const parts = departureInput.value.split('-');
            if (parts.length !== 3) {
                returnInput.value = '';
                return;
            }

            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10);
            const day = parseInt(parts[2], 10);

            const depDate = new Date(year, month - 1, day);
            if (isNaN(depDate.getTime())) {
                returnInput.value = '';
                return;
            }

            depDate.setDate(depDate.getDate() + durationDays);

            const y = depDate.getFullYear();
            const m = String(depDate.getMonth() + 1).padStart(2, '0');
            const d = String(depDate.getDate()).padStart(2, '0');

            returnInput.value = `${y}-${m}-${d}`;
        }

        function updateTotalPrice() {
            const selectedOption = tourSelect.options[tourSelect.selectedIndex];

            if (!selectedOption || tourSelect.value === '0') {
                totalPriceDisplay.textContent = '0 đ';
                totalPriceInput.value = 0;
                selectedTourDisplay.textContent = '--';
                return;
            }

            const pricePerPerson = Number(selectedOption.dataset.price || 0);
            const tourName = selectedOption.dataset.name || selectedOption.text;
            const customerCount = customerList.querySelectorAll('.guest-item').length;
            const totalGuests = customerCount + 1; // +1 người đại diện

            const totalPrice = pricePerPerson * totalGuests;

            totalPriceDisplay.textContent = totalPrice.toLocaleString('vi-VN') + ' đ';
            totalPriceInput.value = totalPrice;
            totalCustomerDisplay.textContent = totalGuests + ' người';
            selectedTourDisplay.textContent = tourName;
        }

        function updateSelectedDate() {
            if (departureInput.value) {
                const date = new Date(departureInput.value);
                const formattedDate = date.toLocaleDateString('vi-VN');
                selectedDateDisplay.textContent = formattedDate;
            } else {
                selectedDateDisplay.textContent = '--';
            }
        }

        customerList.addEventListener('click', function (e) {
            if (e.target.classList.contains('toggle-details')) {
                const guestItem = e.target.closest('.guest-item');
                const details = guestItem.querySelector('.guest-details');
                if (details) details.classList.toggle('d-none');
            }
        });

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
                    <button type="button" class="btn btn-link btn-sm toggle-details">
                        Xem / Ẩn
                    </button>
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
                        <label class="form-label">Yêu Cầu Đặc Biệt</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                name="customer[${guestIndex}][customer_note][]"
                                value="vegetarian" id="vegetarian${guestIndex}">
                            <label class="form-check-label" for="vegetarian${guestIndex}">
                                Ăn uống
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                name="customer[${guestIndex}][customer_note][]" 
                                value="allergy" id="allergy${guestIndex}">
                            <label class="form-check-label" for="allergy${guestIndex}">
                                Dị ứng
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                name="customer[${guestIndex}][customer_note][]"
                                value="wheelchair" id="wheelchair${guestIndex}">
                            <label class="form-check-label" for="wheelchair${guestIndex}">
                                Sức khoẻ
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" 
                                name="customer[${guestIndex}][customer_note][]" 
                                value="elderly" id="elderly${guestIndex}">
                            <label class="form-check-label" for="elderly${guestIndex}">
                                Khác
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi Chú Chi Tiết</label>
                        <textarea class="form-control" 
                            name="customer[${guestIndex}][customer_note_detail]" 
                            rows="4" placeholder="Nhập các yêu cầu đặc biệt khác..."></textarea>
                    </div>
                </div>
            </div>`;

            customerList.insertAdjacentHTML('beforeend', newGuestHtml);
            guestIndex++;
            updateTotalPrice();
        });

        tourSelect.addEventListener('change', function () {
            updateTotalPrice();
            updateReturnDate();
        });

        departureInput.addEventListener('change', function () {
            updateReturnDate();
            updateSelectedDate();
        });

        updateTotalPrice();
        updateReturnDate();
        updateSelectedDate();
    });
</script>

<style>
    .card-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .section-title {
        color: #333;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title i {
        color: #ff8a65;
    }

    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px 15px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #ff8a65;
        box-shadow: 0 0 0 0.2rem rgba(255, 138, 101, 0.25);
    }

    .guest-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #ff8a65;
    }

    .guest-item strong {
        color: #333;
    }

    .btn-link {
        text-decoration: none;
        color: #ff8a65;
        padding: 0;
    }

    .btn-link:hover {
        color: #ff6f47;
    }

    .summary-card {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 2px solid #ff8a65;
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
        color: #ff8a65;
    }

    .btn-primary {
        background-color: #ff8a65;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
    }

    .btn-primary:hover {
        background-color: #ff6f47;
    }

    .btn-outline-primary {
        border-color: #ff8a65;
        color: #ff8a65;
        border-radius: 8px;
    }

    .btn-outline-primary:hover {
        background-color: #ff8a65;
        color: white;
    }

    .btn-outline-secondary {
        border-radius: 8px;
    }

    .text-danger {
        color: #dc3545;
    }
</style>