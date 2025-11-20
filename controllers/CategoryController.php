<?php
class CategoryController
{
    public $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }

    public function All()
    {
        $danhsach = $this->CategoryModel->All();
        require_once __DIR__ . '/../views/admin/Category/index.php';
    }
    public function created()
    {
        $cate = new Category();
        if (isset($_POST["submit"])) {
            $cate->name = trim($_POST["name"]);
            $cate->description = trim($_POST["description"]);
            $cate->created_at = date("Y-m-d H:i:s");
            $cate->updated_at = date("Y-m-d H:i:s");

            $data = $this->CategoryModel->create($cate);
            if ($data) {
                header("location:?route=category");
                exit();
            }
        }
        require_once __DIR__ . '/../views/admin/Category/create.php';
    }
    public function Delete($id){
    if($id != ""){
        $data = $this->CategoryModel->delete($id);

        if($data > 0){
            header("location:?route=category");
            exit();
        } else {
            echo "<script>alert('Không tồn tại dữ liệu để xóa');</script>";
        }
    }
}

}
