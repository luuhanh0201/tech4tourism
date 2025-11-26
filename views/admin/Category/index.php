<!-- Render danh sách các loại tour -->
<!-- Code giao diện Dashboard của admin -->
<!-- <h1>Dashboard admin</h1> -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourManager Pro - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</head>

<body>
    <div class="main-content">
        <div class="container mt-4">
            <div class="card shadow-sm border-0">
                <?php
                $keyword = isset($_GET["keyword"]) ? strtolower($_GET["keyword"]) : "";
                $filtereDate = [];
                if ($keyword !== "") {
                    foreach ($danhsach as $cate) {
                        if (strpos(strtolower($cate->name), $keyword) !== false) {
                            $filtereDate[] = $cate;
                        }
                    }
                } else {
                    $filtereDate = $danhsach;
                }
                ?>
                <form method="GET">
                    <input type="hidden" name="route" value="All_category">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="tìm kiếm" name="keyword">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>

                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="fw-bold m-0 text-primary">Danh sách danh mục</h4>
                    <a href="?route=Created_category" class="btn btn-primary px-4">+ Thêm danh mục</a>
                </div>

                <div class="card-body p-0">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" class="py-3">Tên tour</th>
                                <th scope="col" class="py-3">Mô tả</th>
                                <th scope="col" class="py-3">Ngày tạo</th>
                                <th scope="col" class="py-3">Cập nhật</th>
                                <th scope="col" class="text-center py-3">Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($filtereDate as $pro): ?>
                                <tr>
                                    <td><?= $pro->name ?></td>
                                    <td><?= $pro->description ?></td>
                                    <td><?= $pro->created_at ?></td>
                                    <td><?= $pro->updated_at ?></td>
                                    <td class="text-center" style="gap: 20px;">
                                        <a href="?route=Update_category&id=<?= $pro->id ?>">
                                            <i class="fa-solid fa-pen" style="color:blue"></i>
                                        </a>
                                        <a href="?route=Delete_category&id=<?= $pro->id ?>" onclick="return confirm('bạn có chắn muốn xóa không?')">
                                            <i class="fa-solid fa-trash-can" style="color:red"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>
</body>

</html>