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
        require_once __DIR__ . '/../views/admin/Category/index.php';
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
                header("location:?route=All_category");
                exit();
            }
        }
        require_once __DIR__ . '/../views/admin/Category/create.php';
    }
    public function Delete_category($id){
    if($id != ""){
        $data = $this->CategoryModel->delete($id);

        if($data > 0){
            header("location:?route=All_category");
            exit();
        } else {
            echo "<script>alert('Không tồn tại dữ liệu để xóa');</script>";
        }
    }
}

public function Update_category($id){
    if($id !==""){
        $data = $this->CategoryModel->All();
        $cate = $this->CategoryModel->detail($id);
        if (isset($_POST["submit"])) {
            $cate->name = trim($_POST["name"]);
            $cate->description = trim($_POST["description"]);
            $cate->created_at = date("Y-m-d H:i:s");
            $cate->updated_at = date("Y-m-d H:i:s");

            $data = $this->CategoryModel->update($cate);
            if ($data) {
                header("location:?route=All_category");
                exit();
            }
        }
        require_once __DIR__.'/../views/admin/Category/update.php';
    }
    
}

}
