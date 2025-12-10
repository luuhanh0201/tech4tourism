<?php

?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản Lý Booking</h2>
        <a href="booking-manager/create-booking" style="color: white; background-color:#ff8a65; border:none;"
            class="btn btn-primary px-4 py-2">Tạo booking</a>

    </div>
    <div class="tours-toolbar d-flex flex-wrap align-items-center mb-3">
        <div class="flex-grow-1 me-2 mb-2 mb-sm-0">
            <input type="search" class="form-control tours-search" placeholder="Tìm kiếm theo tên tour...">
        </div>
        <div class="mb-2 mb-sm-0">
            <select class="form-select tours-filter">
                <option value="">Tất cả trạng thái</option>
                <option value="pending">Chờ xác nhận</option>
                <option value="confirmed">Đã xác nhận</option>
                <option value="done">Đã hoàn thành</option>
                <option value="canceled">Đã huỷ</option>
            </select>
        </div>
    </div>
    <div class="table-container">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Booking code</th>
                    <th>Đại diện</th>
                    <th>Số khách</th>
                    <th>Tổng thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

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
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $booking['booking_code'] ?></td>
                        <td><?= $booking['contact_name'] ?></td>
                        <td><?= $booking['max_person'] ?></td>
                        <td><strong> <?= number_format($booking['price'] * $booking['max_person'], 0, ',', '.') . ' ₫' ?>
                        </td>
                        <td>
                            <span class="status-badge <?= $data['class'] ?>">
                                <?= htmlspecialchars($data['label']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="booking-manager/detail?id=<?= $booking['id'] ?>" class="text-primary mx-2"><i
                                    class="fa-solid fa-eye"></i></a>
                            <?php if ($booking['status'] === "done" || $booking['status'] === "canceled"): ?>
                                <button class="icon-btn icon-btn--disabled" disabled title="Không thể chỉnh sửa đơn hàng này"
                                    aria-label="Không thể chỉnh sửa đơn hàng này">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            <?php else: ?>
                                <a href="booking-manager/edit-booking?id=<?= $booking['id'] ?>" class="text-success mx-2"><i
                                        class="fa-solid fa-pen"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
    </div>
</div>
<style>
    .icon-btn {
        border: none;
        background: transparent;
        color: #9ca3af;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        line-height: 1;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.1);
        transition: background 0.2s ease, box-shadow 0.2s ease, transform 0.1s ease;
    }

    .icon-btn i {
        pointer-events: none;
    }

    .icon-btn--disabled {
        cursor: not-allowed;
        opacity: 0.7;
        box-shadow: none;
    }

    .icon-btn:not(:disabled):hover {
        background: #e5e7eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(15, 23, 42, 0.12);
    }

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

    .status-unknown {
        background-color: #e5e7eb;
        color: #374151;
    }


    .table-container {
        border-radius: 12px;
        background: white;
        padding: 20px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    th {
        font-weight: 700;
        color: #333;
    }

    .actions a {
        font-weight: 600;
        margin-right: 12px;
    }

    .actions a:first-child {
        color: #0066FF;
    }

    .actions a:last-child {
        color: #FF3333;
    }
</style>