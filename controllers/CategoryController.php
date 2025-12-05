<?php
class CategoryController
{
    public $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }

    public function All_category()
    {
        $danhsach = $this->CategoryModel->All();
        renderLayoutAdmin("admin/Category/index.php", ['danhsach' => $danhsach], "Danh sách category");
    }
    public function Created_category()
    {
        $cate = new Category();
        if (isset($_POST["submit"])) {
            $cate->name = trim($_POST["name"]);
            $cate->description = trim($_POST["description"]);
            $cate->created_at = date("Y-m-d H:i:s");
            $cate->updated_at = date("Y-m-d H:i:s");

            $data = $this->CategoryModel->create($cate);
            if ($data) {
                header("location:/dashboard/categories-manager");
                exit();
            }
        }
        renderLayoutAdmin("admin/Category/create.php", [], "Danh sách category");
        ;
    }
    public function Delete_category()
    {

        if (isset($_GET['id'])) {
            $data = $this->CategoryModel->delete($_GET['id']);

            if ($data > 0) {
                header("location:/dashboard/categories-manager");
                exit();
            } else {
                echo "<script>alert('Không tồn tại dữ liệu để xóa');</script>";
            }
        }
    }

    public function Update_category()
    {

        if (isset($_GET['id'])) {
            $data = $this->CategoryModel->All();
            $cate = $this->CategoryModel->detail($_GET['id']);
            if (isset($_POST["submit"])) {
                $cate->name = trim($_POST["name"]);
                $cate->description = trim($_POST["description"]);
                $cate->created_at = date("Y-m-d H:i:s");
                $cate->updated_at = date("Y-m-d H:i:s");

                $data = $this->CategoryModel->update($cate);
                if ($data) {
                    header("location:/dashboard/categories-manager");
                    exit();
                }
            }
            renderLayoutAdmin("admin/Category/update.php", ['cate' => $cate], "Danh sách category");

        }

    }

}
