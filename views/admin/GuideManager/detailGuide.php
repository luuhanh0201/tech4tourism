<div class="container py-5">
    <div class="text-start mb-3">
        <a href="/dashboard/guide-manager" class="btn btn-outline-secondary px-4">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>
    <div class="card shadow-lg border-0 p-4" style="border-radius: 16px;">

        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            <div class="rounded-circle d-flex justify-content-center align-items-center text-white fw-bold mr-4"
                style="width: 60px; height: 60px; background:#6366f1; font-size:22px;">
                <?= strtoupper(substr($guide['full_name'], 0, 1)); ?>
            </div>

            <div>
                <h3 class="fw-bold mb-1"><?= $guide['full_name'] ?></h3>
                <span
                    class="ml-2 status-badge <?= $guide['status'] === 'Đang dẫn' ? 'status-running' : 'status-free' ?>">
                    <?= $guide['status'] ?>
                </span>
            </div>
        </div>

        <hr>

        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="section-title">
                    Thông Tin Cơ Bản
                </div>
                <p><strong>Email:</strong> <?= $guide['email'] ?></p>
                <p><strong>Số điện thoại:</strong> <?= $guide['phone'] ?? '<i>Chưa cập nhật</i>' ?></p>
                <p><strong>Ngày sinh:</strong> <?= $guide['date_of_birth'] ?? '<i>Chưa cập nhật</i>' ?></p>
                <p><strong>Giới tính:</strong> <?= $guide['gender'] ?? '<i>Chưa cập nhật</i>' ?></p>
                <p><strong>Địa chỉ:</strong> <?= $guide['address'] ?? '<i>Chưa cập nhật</i>' ?></p>
            </div>

            <div class="col-md-6 mb-3">

                <div class="section-title">
                    Thông Tin nghề nghiệp
                </div>

                <p>
                    <strong>Đánh giá:</strong>
                    <?php
                    if ($guide['rate']) {
                        echo '<i class="fa-solid fa-star" style="color:#f59e0b;"></i> ' . $guide['rate'] . '/5';
                    } else {
                        echo '-';
                    }
                    ?>
                </p>

                <p>
                    <strong>Ngôn ngữ:</strong>
                    <span
                        class="badge bg-light text-primary border px-2 py-1"><?= $guide['language'] ?? "Không" ?></span>

                </p>

                <p>
                    <strong>Chứng chỉ:</strong><br>
                    <?= $guide['certifications'] ?>
                </p>
            </div>
        </div>

        <hr>

        <!-- Bio -->
        <div class="mt-3">
            <div class="section-title">
                Giới thiệu bản thân
            </div>
            <p class="text-muted">
                <?= $guide['bio'] ?>
            </p>
        </div>

    </div>
</div>

<style>
    .section-title {
        background: #FF8B6A;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
    }

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