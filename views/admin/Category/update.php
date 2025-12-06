<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Cập nhật lại danh mục Tour</h2>
           
        </div>
        <a href="/dashboard/categories-manager" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Tên danh mục</label>
                    <input type="text" class="form-control" name="name" id="name" value="<?= $cate->name ?>"
                        placeholder="Nhập tên danh mục" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Mô tả</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                        placeholder="Nhập mô tả danh mục" required><?= $cate->description ?></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success px-4" name="submit">
                      Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .btn-success {
        background: #FF8B6A;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }
</style>