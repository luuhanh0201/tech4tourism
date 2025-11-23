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
    public function editGuide()
    {
        if (isset($_GET['id'])) {
            $guide = $this->GuiderManagerModel->getDetailGuide($_GET['id']);
        } else {
            echo "Không tìm thấy id";
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateOfBirth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $certifications = $_POST['certifications'];
            $language = $_POST['language'];
            $bio = $_POST['bio'];

            if ($this->GuiderManagerModel->updateProfileGuide($_GET['id'], $dateOfBirth, $gender, $phone, $address, $certifications, $language, $bio)) {
                $_SESSION['success'] = "";
            } else {
                echo "FALSE";
            }
        }
        include "./views/admin/GuideManager/editGuide.php";

    }

}
?>