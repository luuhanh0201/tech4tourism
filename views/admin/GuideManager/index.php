<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold">Quản người dùng</h2>
            <p class="text-muted">Quản lý thông tin và lịch làm việc của đội ngũ</p>
        </div>
        <a href="/sign-up" class="btn btn-primary px-4 py-2"
            style="background-color:var(--color-primary); border:none;">
            + Thêm HDV
        </a>
    </div>
    <div class="mb-4">
        <form class="row g-2" method="get">
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">Tất cả vai trò</option>
                    <option value="admin" <?= (($_GET['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                    <option value="guide" <?= (($_GET['role'] ?? '') === 'guide') ? 'selected' : '' ?>>Hướng dẫn viên
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Trống lịch" <?= (($_GET['status'] ?? '') === 'Trống lịch') ? 'selected' : '' ?>>Trống
                        lịch</option>
                    <option value="Đang dẫn" <?= (($_GET['status'] ?? '') === 'Đang dẫn') ? 'selected' : '' ?>>Đang dẫn
                    </option>
                    <option value="Tạm nghỉ" <?= (($_GET['status'] ?? '') === 'Tạm nghỉ') ? 'selected' : '' ?>>Tạm nghỉ
                    </option>
                </select>
            </div>

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input name="keyword" type="text" class="form-control border-start-0"
                        placeholder="Tìm theo tên, email, số điện thoại..."
                        value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-2 d-grid">
                <button class="btn" type="submit" style="background: var(--color-primary); color:#fff">Lọc</button>
            </div>
        </form>
    </div>
    <table class="table align-middle bg-white shadow-sm rounded">
        <thead class="text-muted fw-semibold">
            <tr>
                <th>Người dùng(vai trò)</th>
                <th>Vai trò</th>
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
                <?php

                $currentUserId = (int) ($_SESSION['user']['id'] ?? 0);
                $rowUserId = (int) ($guide['id'] ?? 0);
                $rowRole = $guide['role'] ?? '';

                $canEdit = true;
                if ($rowRole === 'admin') {
                    $canEdit = ($rowUserId === $currentUserId);
                }
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <strong><?= $guide['full_name'] ?></strong>

                            </div>
                        </div>
                    </td>
                    <td><?= $guide['role'] ?></td>
                    <td>
                        <?php
                        $status = $guide['status'];

                        $mapStatus = [
                            'Trống lịch' => ['class' => 'status-confirmed', 'label' => 'Trống lịch'],
                            'Đang dẫn' => ['class' => 'status-pending', 'label' => 'Đang dẫn'],
                            'Tạm nghỉ' => ['class' => 'status-canceled', 'label' => 'Tạm nghỉ'],
                        ];

                        $data = $mapStatus[$status] ?? ['class' => 'status-unknown', 'label' => $status];
                        ?>
                        <span class="ml-2 status-badge <?= $data['class'] ?>">
                            <?= $data['label'] ?>
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
                        <?php if ($canEdit): ?>
                            <a href="/dashboard/guide-manager/profile-guide/edit?id=<?= (int) $guide['id'] ?>"
                                class="text-success mx-2">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        <?php else: ?>
                            <span class="text-secondary mx-2" style="opacity: 0.4; cursor: not-allowed;"
                                title="Bạn chỉ có thể sửa thông tin admin của chính mình">
                                <i class="fa-solid fa-pen"></i>
                            </span>
                        <?php endif; ?>
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
</style>