<body></body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-bold">Quản lý danh mục</h2>
            </div>
            <a href="/dashboard/categories-manager/new-category" class="btn btn-primary px-4 py-2"
                style="background-color:#ff8a65; border:none;">
                + Thêm danh mục
            </a>
        </div>

        <?php
        $keyword = isset($_GET["keyword"]) ? strtolower($_GET["keyword"]) : "";
        $filteredData = [];
        if ($keyword !== "") {
            foreach ($danhsach as $cate) {
                if (strpos(strtolower($cate->name), $keyword) !== false) {
                    $filteredData[] = $cate;
                }
            }
        } else {
            $filteredData = $danhsach;
        }
        ?>

        <div class="mb-4">
            <form class="input-group" method="get">
                <input type="hidden" name="route" value="All_category">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="keyword" class="form-control border-start-0"
                    placeholder="Tìm kiếm theo tên danh mục...">
            </form>
        </div>

        <table class="table align-middle bg-white shadow-sm rounded">
            <thead class="text-muted fw-semibold">
                <tr>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($filteredData as $pro): ?>
                    <tr>
                        <td><?= $pro['name'] ?></td>
                        <td><?= $pro['description'] ?></td>
                        <td class="text-center" style="gap: 20px;">
                            <a class="text-primary mx-2"
                                href="/dashboard/categories-manager/edit-category?id=<?= $pro['id'] ?>">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <a href="/dashboard/categories-manager/delete-category?id=<?= $pro['id'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa không?')">
                                <i class="fa-solid fa-trash-can" style="color:red"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>