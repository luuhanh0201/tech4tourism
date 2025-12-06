<!-- Code giao diện Dashboard của admin -->
<!-- <h1>Dashboard admin</h1> -->
    <div class="main-content">
         <h1>Quản lý danh mục</h1>
        <div class="container mt-4">
            <div class="card shadow-sm border-0">
                <?php
                $keyword = isset($_GET["keyword"]) ? strtolower($_GET["keyword"]) : "";
                $filtereDate = [];
                if ($keyword !== "") {
                    foreach ($categories as $cate) {
                        if (strpos(strtolower($cate['name']), $keyword) !== false) {
                            $filtereDate[] = $cate;
                        }
                    }
                } else {
                    $filtereDate = $categories;
                }
                ?>
                <form method="GET">
                    <input type="hidden" name="route" value="dashboard/categories-manager">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="tìm kiếm" name="keyword">
                        <button type="submit" class="btn">Tìm kiếm</button>
                    </div>
                </form>

                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h4 class="fw-bold m-0">Danh sách danh mục</h4>
                    <a href="/dashboard/categories-manager/new-category" class="btn btn-primary px-4">+ Thêm danh mục</a>
                </div>

                <div class="card-body p-0">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th scope="col" class="py-3">Tên tour</th>
                                <th scope="col" class="py-3">Mô tả</th>
                                <th scope="col" class="py-3">Ngày tạo</th>
                                <th scope="col" class="py-3">Cập nhật</th>
                                <th scope="col" class="py-3">Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($filtereDate as $pro): ?>
                                <tr>
                                    <td><?= $pro['name'] ?></td>
                                    <td><?= $pro['description'] ?></td>
                                    <td><?= $pro['created_at'] ?></td>
                                    <td><?= $pro['updated_at'] ?></td>
                                    <td class="text-center" id='text-center'>
                                        <a href="categories-manager/update-category?id=<?=$pro['id']?>">
                                            <i class="fa-solid fa-pen" style="color:green;"></i>
                                        </a>
                                        <a href="categories-manager/delete-category?id=<?=$pro['id']?>"onclick="return confirm('bạn có chắn muốn xóa không?')">
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

<style>
    .main-content {
    margin-top: 100px; 
    margin-right: 30px;
}
    .btn{
        background-color: #ff8c00;
        color: white;
    }
    .btn:hover{
        background-color: #f85103ff;
    }
    h4{
       color:#ff8c00;
    }
    .text-center{
        gap: 15px;
    }
</style>

