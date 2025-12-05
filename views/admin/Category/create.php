<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Tạo danh mục</h2>
                <p class="text-muted mb-0">Nhập thông tin chi tiết cho tour du lịch</p>
            </div>
            <a href="/dashboard/categories-manager" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Quay lại danh sách
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="tourForm" action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên danh mục"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                            placeholder="Nhập mô tả ngắn về danh mục" required></textarea>
                    </div>

                    <!-- timestamp ẩn -->
                    <input type="hidden" name="created_at" id="created_at" value="<?= date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="updated_at" id="updated_at" value="<?= date('Y-m-d H:i:s') ?>">

                    <div class="d-flex justify-content-end mt-4">
                        <button name="submit" type="submit" class="btn btn-success">
                            Tạo mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('tourForm').addEventListener('submit', function (event) {
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();

            if (!name) {
                alert('Tên tour không được để trống');
                event.preventDefault();
                return;
            }

            if (!description) {
                alert('Mô tả không được để trống');
                event.preventDefault();
                return;
            }
        });
    </script>

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
</body>