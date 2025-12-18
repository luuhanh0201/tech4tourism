<?php requireAdmin(); ?>
<div class="container py-5">
    <h1 class="dashboard-title">Dashboard</h1>
    <div class="row g-3 mb-4">
        <!-- Tổng tour -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card stat-tour">
                <div>
                    <div class="stat-label">Tổng Tour</div>
                    <div class="stat-value"><?= count($tours) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
        </div>

        <!-- Booking -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card stat-booking">
                <div>
                    <div class="stat-label">Booking</div>
                    <div class="stat-value"><?= count($bookings) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Hướng dẫn viên -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card stat-guide">
                <div>
                    <div class="stat-label">Hướng Dẫn Viên</div>
                    <div class="stat-value"><?= count($guides) ?></div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>
        </div>

        <!-- Doanh thu -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="stat-card stat-revenue">
                <div>
                    <div class="stat-label">Doanh Thu Tháng</div>
                    <div class="stat-value">-</div>
                </div>
                <div class="stat-icon">
                    <i class="fa-solid fa-arrow-trend-up"></i>
                </div>
            </div>
        </div>
    </div>


    <!-- Two main sections -->
    <div class="row g-4">
        <div class="col-12">
            <div class="card section-card">
                <div class="card-header">
                    Tour Sắp Khởi Hành
                </div>
                <div class="card-body">
                    <?php foreach ($bookings as $index => $booking): ?>
                        <?php
                        $status = $booking['status'];

                        $mapStatus = [
                            'confirmed' => ['class' => 'status-confirmed', 'label' => 'Đã xác nhận'],
                            'pending' => ['class' => 'status-pending', 'label' => 'Chờ xác nhận'],
                            'done' => ['class' => 'status-done', 'label' => 'Đã hoàn thành'],
                            'canceled' => ['class' => 'status-canceled', 'label' => 'Đã Huỷ'],
                        ];
                        $data = $mapStatus[$status] ?? ['class' => 'status-unknown', 'label' => $status];
                        ?>
                        <?php if ($index < 3 && $booking['status'] != "done" && $booking['status'] != 'canceled'): ?>
                            <a href="/dashboard/booking-manager/edit-booking?id=<?= $booking['id'] ?>">
                                <div class="tour-item">
                                    <div>
                                        <div class="tour-title"><?= $booking['tour_name'] ?></div>
                                        <div class="tour-sub">HDV: <?= $booking['guide_full_name'] ?? "Chưa sắp xếp" ?></div>
                                    </div>
                                    <div class="tour-meta">
                                        <div class="date-text"><?= $booking['departure_date'] ?></div>
                                        <span class="status-badge <?= htmlspecialchars($data['class']) ?>">
                                            <?= htmlspecialchars($data['label']) ?>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>

        <!-- Booking gần đây -->
        <div class="col-12">
            <div class="card section-card">
                <div class="card-header">
                    Booking Gần Đây
                </div>
                <div class="card-body">
                    <!-- Booking 1 -->
                    <div class="card-body">
                        <?php foreach ($bookings as $index => $booking): ?>
                            <?php
                            $status = $booking['status'];

                            $mapStatus = [
                                'confirmed' => ['class' => 'status-confirmed', 'label' => 'Đã xác nhận'],
                                'pending' => ['class' => 'status-pending', 'label' => 'Chờ xác nhận'],
                                'done' => ['class' => 'status-done', 'label' => 'Đã hoàn thành'],
                                'canceled' => ['class' => 'status-canceled', 'label' => 'Đã Huỷ'],
                            ];
                            $data = $mapStatus[$status] ?? ['class' => 'status-unknown', 'label' => $status];
                            ?>
                            <?php if ($index < 3): ?>
                                <a href="/dashboard/booking-manager/edit-booking?id=<?= $booking['id'] ?>">
                                    <div class="booking-item">
                                        <div>
                                            <div class="booking-name"><?=$booking['contact_name']?></div>
                                            <div class="booking-sub"><?= $booking['tour_name'] ?> </div>
                                        </div>
                                        <div class="booking-meta">
                                            <span class="status-badge <?= htmlspecialchars($data['class']) ?>">
                                            <?= htmlspecialchars($data['label']) ?>
                                        </span>
                                        </div>
                                    </div>
                                </a>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
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
        background-color: #da463eff;
        color: #fff;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 800;
        color: #1f2933;
        margin-bottom: 20px;
    }

    .stat-card {
        border-radius: 16px;
        padding: 16px 18px;
        min-height: 150px;
        /* hoặc 130–140 tuỳ bạn */
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #fff;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
    }

    .stat-label {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.9;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
    }

    .stat-icon {
        font-size: 26px;
        opacity: 0.9;
    }

    /* màu cho 4 card – card đầu dùng cam của bạn */
    .stat-tour {
        background: linear-gradient(90deg, #ff8c00, #ff6b00);
    }

    .stat-booking {
        background: #16a34a;
    }

    .stat-guide {
        background: #a855f7;
    }

    .stat-revenue {
        background: #ea580c;
    }

    .section-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        margin-bottom: 24px;
    }

    .section-card .card-header {
        background: #ffffff;
        border-bottom: none;
        padding: 18px 24px 8px;
        font-weight: 700;
        font-size: 18px;
        color: #111827;
    }

    .section-card .card-body {
        padding: 8px 24px 20px;
    }

    .tour-item,
    .booking-item {
        background: #f9fafb;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tour-title,
    .booking-name {
        font-weight: 600;
        color: #111827;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .tour-sub,
    .booking-sub {
        font-size: 13px;
        color: #6b7280;
    }

    .tour-meta,
    .booking-meta {
        text-align: right;
        font-size: 13px;
    }

    .badge-soft-primary {
        background: rgba(255, 140, 0, 0.12);
        color: #ff8c00;
        border-radius: 999px;
        padding: 4px 10px;
        font-weight: 600;
        font-size: 12px;
    }

    .badge-soft-blue {
        background: rgba(59, 130, 246, 0.12);
        color: #2563eb;
        border-radius: 999px;
        padding: 4px 10px;
        font-weight: 600;
        font-size: 12px;
    }

    .badge-soft-yellow {
        background: rgba(234, 179, 8, 0.12);
        color: #b45309;
        border-radius: 999px;
        padding: 4px 10px;
        font-weight: 600;
        font-size: 12px;
    }

    .badge-soft-green {
        background: rgba(22, 163, 74, 0.12);
        color: #15803d;
        border-radius: 999px;
        padding: 4px 10px;
        font-weight: 600;
        font-size: 12px;
    }

    .date-text {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 4px;
    }
</style>