<div class="container position-relative">
    <div class="main-container">
        <button type="button" onclick="history.back()" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay Lại
        </button>
        <!-- Header -->
        <div class="header-section text-center">

            <h2 class="mb-2">
                <i class="bi bi-pencil-square" style="color: #FF8B6A;"></i>
                Chỉnh Sửa Thông Tin Hướng Dẫn Viên
            </h2>
            <p class="text-muted ">Cập nhật thông tin hướng dẫn viên trong hệ thống</p>
            <div class="info-badge">
                <b style="font-size:24px"><?php echo $guide['full_name']; ?></b>
            </div>
        </div>

        <input type="hidden" id="guideId" value="<?php echo $guide['id']; ?>">

        <form method="post">
            <div class="text-center mb-4">
                <div class="avatar-preview-container" id="avatarPreview">
                    <b class="rounded-circle d-flex justify-content-center align-items-center text-white fw-bold"
                        style="width: 100%; height: 100%; background:#6366f1; font-size:100px;">
                        <?= strtoupper(substr($guide['full_name'], 0, 1)); ?>
                    </b>
                </div>
                <label for="editAvatar" style="background:;" class="btn-change-avatar">
                    <i class="bi bi-upload"></i> Đổi Avatar
                </label>
                <input type="file" class="d-none" id="editAvatar" name="avatar" accept="image/*">
                <div class="mt-2">
                    <small class="text-muted">Click vào avatar hoặc nút để thay đổi ảnh</small>
                </div>
            </div>

            <!-- Thông tin cơ bản -->
            <div class="section-title">
                <i class="bi bi-person-badge"></i> Thông Tin Cơ Bản
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="editUserId" value="<?= $guide['email']; ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Đánh Giá (Rate)</label>
                    <input type="text" class="form-control" value="<?= $guide['rate'] ?? "Chưa có đánh giá"; ?>"
                        readonly>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Ngày Sinh <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="editDateOfBirth" name="date_of_birth"
                        value="<?= $guide['date_of_birth']; ?>" required>
                </div>

                <div class="col-md-6">
                    <div class="form-label">Giới Tính <span class="text-danger">*</span></div>
                    <select class="form-select" id="editGender" name="gender" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="Nam" <?= $guide['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nu" <?= $guide['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>
            </div>
            <div class="section-title">
                <i class="bi bi-telephone"></i> Thông Tin Liên Hệ
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">
                        Số Điện Thoại <span class="required-text">*</span>
                    </label>
                    <input type="tel" class="form-control" id="editPhone" name="phone"
                        value="<?php echo $guide['phone']; ?>" placeholder="0901234567" required>
                    <small class="text-muted">Số điện thoại di động 10 chữ số</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Địa Chỉ <span class="required-text">*</span>
                    </label>
                    <input type="text" class="form-control" id="editAddress" name="address"
                        value="<?php echo $guide['address']; ?>"
                        placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" required>
                </div>
            </div>
            <div class="section-title">
                <i class="bi bi-briefcase"></i> Thông Tin Nghề Nghiệp
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 pt-2">
                    <label class="form-label">
                        Chứng Chỉ (Certifications)
                    </label>
                    <textarea class="form-control" id="editCertifications" name="certifications" rows="3"
                        placeholder="VD: Chứng chỉ HDV Quốc Gia, TOEIC 850, JLPT N2, Chứng chỉ Sơ cấp cứu..."><?php echo $guide['certifications']; ?></textarea>
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Liệt kê các chứng chỉ, bằng cấp liên quan, phân cách bằng
                        dấu phẩy
                    </small>
                </div>

                <div class="col-12 pt-2">
                    <label class="form-label">
                        Ngôn Ngữ (Language) <span class="required-text">*</span>
                    </label>
                    <input type="text" class="form-control" id="editLanguage" name="language"
                        value="<?php echo $guide['language']; ?>" placeholder="VD: Tiếng Việt, English, 中文, 日本語"
                        required>
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Nhập các ngôn ngữ có thể hướng dẫn, phân cách bằng dấu
                        phẩy
                    </small>
                </div>

                <div class="col-12 pt-2">
                    <label class="form-label">
                        Giới Thiệu Bản Thân (Bio)
                    </label>
                    <textarea class="form-control" id="editBio" name="bio" rows="4"
                        placeholder="Mô tả ngắn gọn về bản thân, kinh nghiệm làm việc, sở trường, điểm mạnh..."><?php echo $guide['bio']; ?></textarea>
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i> Giới thiệu chi tiết giúp khách hàng hiểu rõ hơn về hướng
                        dẫn viên
                    </small>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                <button type="button" onclick="history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay Lại
                </button>
                <div>
                    <button type="button" class="btn btn-outline-danger me-2">
                        <i class="bi bi-trash"></i> Xóa HDV
                    </button>
                    <button type="submit" class="btn btn-success">
                        Cập Nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-change-avatar {
        display: inline-block;
        padding: 8px 18px;
        border: 2px solid #FABC66;
        color: #ff7043;
        background: #fff;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: 0.25s;
    }

    .btn-change-avatar:hover {
        background: #ff8a65;
        color: #fff;
    }

    .main-container {
        border-radius: 15px;
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .header-section {
        border-bottom: 3px solid #FF8B6A;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 10;
    }

    .section-title {
        background: #FF8B6A;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .avatar-preview-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px dashed #FF8B6A;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        overflow: hidden;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .avatar-preview-container:hover {
        border-color: #FABC66;
        transform: scale(1.05);
    }

    .avatar-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .avatar-preview-container:hover .avatar-overlay {
        opacity: 1;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 2px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #FF8B6A;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    }

    textarea.form-control {
        resize: vertical;
    }

    .btn-success {
        background: #FF8B6A;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-success:hover {
        transform: translateY(-2px);
        background: #FA6F66;

    }

    .btn-secondary {
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-outline-secondary {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        border: 2px solid #FABC66;
    }

    .required-text {
        color: #dc3545;
        font-weight: 600;
    }

    .info-badge {
        background: #e7f3ff;
        color: #0066cc;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 20px;
    }
</style>