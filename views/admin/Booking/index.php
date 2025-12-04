</script>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản Lý Booking</h2>
        <a href="tours-manager/new-tour" style="color: white; background-color:#ff8a65; border:none;"
            class="btn btn-primary px-4 py-2">Tạo booking</a>

    </div>
    <div class="tours-toolbar d-flex flex-wrap align-items-center mb-3">
        <div class="flex-grow-1 me-2 mb-2 mb-sm-0">
            <input type="search" class="form-control tours-search" placeholder="Tìm kiếm theo tên tour...">
        </div>
        <div class="mb-2 mb-sm-0">
            <select class="form-select tours-filter">
                <option value="">Tất cả trạng thái</option>
                <option value="active">Hoạt động</option>
                <option value="inactive">Ngừng hoạt động</option>
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
                    <th>Số lượng</th>
                    <th>Tổng thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($bookings as $index => $booking): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $booking['booking_code'] ?></td>
                        <td><?= $booking['contact_name'] ?></td>
                        <td><?= $booking['max_person'] ?></td>
                        <td><strong> <?= number_format($booking['price'] ?? 1000, 0, ',', '.') . ' ₫' ?></td>
                        <td><span
                                class="<?= $booking['status'] === "active" ? "status-active" : "status-stop"; ?>"><?= $booking['status'] === "active" ? "Hoạt động" : "Ngừng hoạt động"; ?></span>
                        </td>
                        <td>
                            <a href="booking-manager/detail?id=<?= $booking['id'] ?>" class="text-primary mx-2"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="booking-manager/edit-booking?id=<?= $booking['id'] ?>" class="text-success mx-2"><i
                                    class="fa-solid fa-pen"></i></a>
                            <a href="booking-manager/delete-booking?id=<?= $booking['id'] ?>" class="text-danger mx-2"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>
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