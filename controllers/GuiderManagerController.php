<?php
require './models/GuiderManagerModel.php';

class GuiderManagerController
{
    protected $GuiderManagerModel;
    public function __construct()
    {
        $this->GuiderManagerModel = new GuiderManagerModel();
        // require_once './views/layout/headerAdminLayout.php';
    }
    public function index()
    {
        if (isset($_GET['keyword'])) {
            $guides = $this->GuiderManagerModel->searchGuide($_GET['keyword']);
        } else {
            $guides = $this->GuiderManagerModel->getAllGuider();

        }
        include "./views/admin/GuideManager/index.php";
    }
    public function detailGuide()
    {
        if (isset($_GET['id'])) {
            $guide = $this->GuiderManagerModel->getDetailGuide($_GET['id']);
        } else {
            echo "Không tìm thấy id";
        }
        include "./views/admin/GuideManager/detailGuide.php";

    }
    public function editGuide(){
        include "./views/admin/GuideManager/editGuide.php";

    }

}
?>