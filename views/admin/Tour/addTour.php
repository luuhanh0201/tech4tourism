<div class="container new-tour-page py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Thêm tour mới</h2>
            <p class="text-muted mb-0 small">Nhập đầy đủ thông tin để tạo tour du lịch mới</p>
        </div>
        <a href="/dashboard/tours-manager" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>

    <form method="post" enctype="multipart/form-data" id="tourForm">
        <?php if (!empty($_SESSION['error'])): ?>
            <p class="text-danger"><?= $_SESSION['error'] ?></p>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="row g-3">
            <div class="col-lg-6 d-flex">
                <div class="card-section">
                    <h5 class="card-section-title section-header-bar">Thông tin cơ bản</h5>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Tên tour <span class="text-danger">*</span></label>
                            <input type="text" name="tour_name" class="form-control form-control-rounded"
                                placeholder="Tour du lịch Quảng Bình">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Danh mục tour <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select form-control-rounded">
                                <option value="0" selected>Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Mô tả <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control form-control-rounded"
                                placeholder="Nhập mô tả chi tiết về tour..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

      
            <div class="col-lg-6 d-flex">
                <div class="card-section">
                    <h5 class="card-section-title section-header-bar">Lịch trình</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Số ngày <span class="text-danger">*</span></label>
                            <input type="number" name="duration_day" min="1" class="form-control form-control-rounded"
                                placeholder="Ví dụ: 5">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số đêm <span class="text-danger">*</span></label>
                            <input type="number" name="duration_night" min="0" class="form-control form-control-rounded"
                                placeholder="Ví dụ: 4">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Điểm khởi hành <span class="text-danger">*</span></label>
                            <input type="text" name="start_location" class="form-control form-control-rounded"
                                placeholder="Hà Nội, Hồ Chí Minh...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Điểm kết thúc <span class="text-danger">*</span></label>
                            <input type="text" name="end_location" class="form-control form-control-rounded"
                                placeholder="Đà Nẵng, Phú Quốc...">
                        </div>
                    </div>
                </div>
            </div>

        
            <div class="col-lg-6 d-flex">
                <div class="card-section h-100 w-100">
                    <h5 class="card-section-title section-header-bar">Thông tin khác</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Giá tour <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="price" min="0" step="1000" class="form-control"
                                    placeholder="Ví dụ: 3500000">
                                <span class="input-group-text">đ</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Chính sách hủy tour <span class="text-danger">*</span></label>
                            <textarea name="cancellation_policy" rows="3" class="form-control form-control-rounded"
                                placeholder="Quy định về hoàn/huỷ/đổi tour..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

       
            <div class="col-lg-6 d-flex">
                <div class="card-section upload-box">
                    <h5 class="card-section-title">Hình ảnh <span class="text-danger">*</span></h5>

                    <div class="upload-box-inner text-center upload-inner">
                        <input type="file" name="image" id="tourImage" class="d-none" accept="image/*">
                        <label for="tourImage" class="upload-inner" id="uploadLabel">
                            <div class="upload-icon mb-2">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="upload-text-main">Tải ảnh đại diện cho tour</div>
                            <div class="upload-text-sub">Kéo thả vào đây hoặc nhấn để chọn file</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

       <div class="text-end mt-3">
            <button style="color: white; background-color:var(--color-primary); border:none;"
                class="btn btn-primary px-4 py-2">Thêm tour</button>
        </div>
    </form>
</div>



<style>
    .upload-box {
        width: 100%;
        border-radius: 16px;
        border: 1px dashed #e5e7eb;
        background: #f9fafb;
        padding: 26px 24px;
    }

    .upload-box-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        min-height: 180px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-inner {
        display: block;
        cursor: pointer;
        width: 100%;
    }

    .new-tour-page {
        padding-top: 10px;
        padding-bottom: 40px;
    }

    .card-section {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px 20px 20px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        width: 100%;
    }

    .card-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 14px;
    }

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .form-control-rounded,
    .form-select.form-control-rounded {
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        padding: 10px 14px;
        background-color: #ffffff;
        box-shadow: none;
    }

    textarea.form-control-rounded {
        border-radius: 8px;
        resize: vertical;
    }

    .form-control-rounded:focus,
    .form-select.form-control-rounded:focus {
        border-color: #ff8c00;
        box-shadow: 0 0 0 0.15rem rgba(255, 140, 0, 0.25);
        outline: none;
    }

    .upload-icon {
        width: 48px;
        height: 48px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        box-shadow: 0 8px 20px rgba(148, 64, 0, 0.35);
    }

    .upload-text-main {
        font-weight: 600;
        font-size: 14px;
        color: #111827;
    }

    .upload-text-sub {
        font-size: 12px;
        color: #9ca3af;
    }

    .section-header-bar {
        background-color: #ff8c00;
        color: #ffffff;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 12px;
    }

  
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.25);
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 4px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .upload-box.is-invalid {
        border-color: #dc3545;
        background-color: #fff5f5;
    }

    .upload-preview {
        text-align: center;
        width: 100%;
    }

    .upload-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('tourForm');
    
   
    const tourName = document.querySelector('input[name="tour_name"]');
    const categoryId = document.querySelector('select[name="category_id"]');
    const description = document.querySelector('textarea[name="description"]');
    const durationDay = document.querySelector('input[name="duration_day"]');
    const durationNight = document.querySelector('input[name="duration_night"]');
    const startLocation = document.querySelector('input[name="start_location"]');
    const endLocation = document.querySelector('input[name="end_location"]');
    const price = document.querySelector('input[name="price"]');
    const cancellationPolicy = document.querySelector('textarea[name="cancellation_policy"]');
    const imageInput = document.querySelector('input[name="image"]');


    function showError(element, message) {
        const parent = element.closest('.col-12, .col-md-8, .col-md-6, .col-md-4') || element.parentElement;
        
        
        const oldError = parent.querySelector('.error-message');
        if (oldError) oldError.remove();

  
        element.classList.add('is-invalid');

        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        parent.appendChild(errorDiv);
    }

    
    function clearError(element) {
        element.classList.remove('is-invalid');
        const parent = element.closest('.col-12, .col-md-8, .col-md-6, .col-md-4') || element.parentElement;
        const errorDiv = parent.querySelector('.error-message');
        if (errorDiv) errorDiv.remove();
    }

    // Validate từng trường
    function validateField(field) {
        clearError(field);

        if (!field.value.trim()) {
            showError(field, 'Vui lòng nhập trường này');
            return false;
        }

       
        
        if (field.name === 'tour_name' && field.value.trim().length < 5) {
            showError(field, 'Tên tour phải có ít nhất 5 ký tự');
            return false;
        }

        if (field.name === 'category_id' && field.value === '0') {
            showError(field, 'Vui lòng chọn danh mục');
            return false;
        }

        if (field.name === 'description' && field.value.trim().length < 20) {
            showError(field, 'Mô tả phải có ít nhất 20 ký tự');
            return false;
        }

        if (field.name === 'duration_day' && field.value < 1) {
            showError(field, 'Số ngày phải lớn hơn 0');
            return false;
        }

        if (field.name === 'duration_night' && field.value < 0) {
            showError(field, 'Số đêm không được âm');
            return false;
        }

        if (field.name === 'price' && field.value <= 0) {
            showError(field, 'Giá tour phải lớn hơn 0');
            return false;
        }

        return true;
    }

 
    function validateImage(input) {
        const uploadBox = input.closest('.card-section');
        const parent = uploadBox.querySelector('.upload-box-inner') || uploadBox;
        
  
        const oldError = uploadBox.querySelector('.error-message');
        if (oldError) oldError.remove();
        uploadBox.classList.remove('is-invalid');

        if (!input.files || !input.files[0]) {
            uploadBox.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-center mt-2';
            errorDiv.textContent = 'Vui lòng chọn hình ảnh';
            parent.appendChild(errorDiv);
            return false;
        }

        const file = input.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        const maxSize = 5 * 1024 * 1024; 

        if (!allowedTypes.includes(file.type)) {
            uploadBox.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-center mt-2';
            errorDiv.textContent = 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF)';
            parent.appendChild(errorDiv);
            input.value = '';
            return false;
        }

        if (file.size > maxSize) {
            uploadBox.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-center mt-2';
            errorDiv.textContent = 'Kích thước ảnh không được vượt quá 5MB';
            parent.appendChild(errorDiv);
            input.value = '';
            return false;
        }

       
        const reader = new FileReader();
        reader.onload = function(e) {
            const label = document.getElementById('uploadLabel');
            label.innerHTML = `
                <div class="upload-preview">
                    <img src="${e.target.result}" alt="Preview">
                    <div class="mt-2 upload-text-sub">Click để thay đổi ảnh</div>
                </div>
            `;
        };
        reader.readAsDataURL(file);

        return true;
    }

  
    const inputs = [tourName, categoryId, description, durationDay, durationNight, startLocation, endLocation, price, cancellationPolicy];
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                clearError(this);
            }
        });
    });

  
    imageInput.addEventListener('change', function() {
        validateImage(this);
    });

  
    price.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    durationDay.addEventListener('input', function() {
        if (this.value > 365) this.value = 365;
        if (this.value < 0) this.value = 0;
    });

    durationNight.addEventListener('input', function() {
        if (this.value > 365) this.value = 365;
        if (this.value < 0) this.value = 0;
    });


    form.addEventListener('submit', function(e) {
       
        let isValid = true;

   
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });


        if (!imageInput.files || !imageInput.files[0]) {
            const uploadBox = imageInput.closest('.card-section');
            uploadBox.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-center mt-2';
            errorDiv.textContent = 'Vui lòng chọn hình ảnh';
            uploadBox.querySelector('.upload-box-inner').appendChild(errorDiv);
            isValid = false;
        } else {
            if (!validateImage(imageInput)) {
                isValid = false;
            }
        }

        if (isValid) {
         
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Đang xử lý...';
            form.submit();
        } else {
           
            const firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});
</script>