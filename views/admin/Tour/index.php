<script>
    document.title = "Quản lý tours"
</script>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản Lý Tour</h2>
        <a href="tours/new-tour" style="color: white;" class="btn btn-primary btn-lg">Thêm Tour Mới</a>
    </div>
    <input type='search' />
    <select name="" id="">
        <option value="12">Hoạt động</option>
    </select>
    <div class="table-container">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Tên Tour</th>
                    <th>Loại</th>
                    <th>Giá</th>
                    <th>Chỗ</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($tours as $tour): ?>
                    <tr>
                        <td><?= $tour['tour_name'] ?></td>
                        <td>Trong nước</td>
                        <td><strong><?= $tour['price'] ?></strong></td>
                        <td>20</td>
                        <td><span
                                class="<?= $tour['status'] === "active" ? "status-active" : "status-stop"; ?>"><?= $tour['status'] === "active" ? "Hoạt động" : "Ngừng hoạt động"; ?></span>
                        </td>
                        <td>
                            <a href="tours/detail?id=<?= $tour['id'] ?>" class="text-primary mx-2"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="tours/edit?id=<?= $tour['id'] ?>" class="text-success mx-2"><i
                                    class="fa-solid fa-pen"></i></a>
                            <a href="#" class="text-danger mx-2"><i class="fa-solid fa-trash"></i></a>
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