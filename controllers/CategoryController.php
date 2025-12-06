<?php

class CategoryController
{
    protected $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }

    function index()
    {
        $categories = $this->CategoryModel->getAllCategory();
        renderLayoutAdmin("admin/Category/index.php", ["categories" => $categories], "Quản lý danh mục");
    }

    function addNewCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $created_at = $_POST['created_at'];
            $updated_at = date('Y-m-d H:i:s');

            if (!$name || !$description) {
                $_SESSION["error"] = "vui lòng nhập đầy đủ thông tin";
                header("location:");
                exit();
            } else {
                $categories = $this->CategoryModel->addNewCategory(
                    $name,
                    $description,
                    $created_at,
                    $updated_at,
                );
                $_SESSION["success"] = "Tạo danh mục thành công";
                header("location: /dashboard/categories-manager");
            }
        }
        renderLayoutAdmin("admin/Category/CreateCategory.php", ["categories" => $categories], "thêm danh mục danh mục");
    }

    function deleteCategory()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if ($this->CategoryModel->deleteCategory($id)) {
                $_SESSION['sucess'] = "<script>alert('xóa thành công')</script>";
                header("location: /dashboard/categories-manager");
            } else {
                $_SESSION['errors'] = "<script>alert('xóa thất bại')</script>";
            }
            exit();
        } else {
            echo "<script>alert('không tìm thất id')</script>";
        }
    }

    function updateCategory()
    {
        $id = $_GET['id'];
        $categories = $this->CategoryModel->DetailCategory($id);

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $created_at = $categories['created_at'];
            $updated_at = date('Y-m-d H:i:s');

            if ($this->CategoryModel->UpdateCategory($id, $name, $description, $created_at, $updated_at)) {
                $_SESSION['success'] = "Sửa danh mục thành công";
                header('location: /dashboard/categories-manager');
                exit;
            }
        }
        renderLayoutAdmin("admin/Category/UpdateCategory.php",["categories"=>$categories],"sửa");
    }
}
