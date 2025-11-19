<?php
 class CategoryController {
    public $CategoryModel;

    public function __construct()
    {
        $this->CategoryModel = new CategoryModel();
    }

    public function All() {
        $danhsach = $this->CategoryModel->All();
        require_once __DIR__ . '/../views/admin/Category/index.php';

    }
}

?>