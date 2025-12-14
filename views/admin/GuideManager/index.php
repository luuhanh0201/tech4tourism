<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold">Quản Lý Hướng Dẫn Viên</h2>
            <p class="text-muted">Quản lý thông tin và lịch làm việc của đội ngũ HDV</p>
        </div>
        <a href="#" class="btn btn-primary px-4 py-2" style="background-color:var(--color-primary); border:none;">
            + Thêm HDV
        </a>
    </div>
    <div class="mb-4">
        <form class="input-group" method="get">
            <span class="input-group-text bg-white border-end-0">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input name="keyword" type="text" class="form-control border-start-0"
                placeholder="Tìm kiếm theo tên, email, số điện thoại...">
        </form>
    </div>
    <table class="table align-middle bg-white shadow-sm rounded">
        <thead class="text-muted fw-semibold">
            <tr>
                <th>Hướng Dẫn Viên</th>
                <th>Trạng thái</th>
                <th>Email</th>
                <th>Ngôn Ngữ</th>
                <th>Đánh giá</th>
                <th class="text-center">Thao Tác</th>
            </tr>
        </thead>

        <tbody>
            <!-- ITEM 1 -->
            <?php foreach ($guides as $guide): ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <strong><?= $guide['full_name'] ?></strong>

                            </div>
                        </div>
                    </td>
                    <td>
                        <span
                            class="ml-2 status-badge <?= $guide['status'] === 'Đang dẫn' ? 'status-running' : 'status-free' ?>">
                            <?= $guide['status'] ?>
                        </span>
                    </td>
                    <td>
                        <div><?= $guide['phone'] ?></div>
                        <div class="text-muted"><?= $guide['email'] ?></div>
                    </td>

                    <td>
                        <span
                            class="badge bg-light text-primary border px-2 py-1 me-1"><?= $guide['language'] ?? "Chưa cập nhật" ?></span>
                    </td>

                    <td>
                        <?php
                        if ($guide['rate']) {
                            echo '<i class="fa-solid fa-star" style="color:#f59e0b;"></i> ' . $guide['rate'] . '/5';
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>

                    <td class="text-center">

                        <a href="guide-manager/profile-guide?id=<?= $guide['id'] ?>" class="text-primary mx-2"><i
                                class="fa-solid fa-eye"></i></a>
                        <a href="guide-manager/profile-guide/edit?id=<?= $guide['id'] ?>" class="text-success mx-2"><i
                                class="fa-solid fa-pen"></i></a>
                        <!-- <a href="#" class="text-danger mx-2"><i class="fa-solid fa-trash"></i></a> -->
                    </td>
                </tr>
            <?php endforeach; ?>


        </tbody>
    </table>



</div>

<style>
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 30px;
        letter-spacing: 0.3px;
    }

    .status-free {
        background-color: #d1fae5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .status-running {
        background-color: #fef9c3;
        color: #92400e;
        border: 1px solid #fef3c7;
    }
</style>