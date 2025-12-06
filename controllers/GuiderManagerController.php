<?php
require './models/GuiderManagerModel.php';
class GuiderManagerController
{
    protected $GuiderManagerModel;
    public function __construct()
    {
        $this->GuiderManagerModel = new GuiderManagerModel();
    }
    public function index()
    {
        $guides = "";
        if (isset($_GET['keyword'])) {
            $guides = $this->GuiderManagerModel->searchGuide($_GET['keyword']);
        } else {
            $guides = $this->GuiderManagerModel->getAllGuider();

        }
        renderLayoutAdmin("admin/GuideManager/index.php", ["guides" => $guides], "Quản lý hướng dẫn viên");

    }
    public function detailGuide()
    {
        if (isset($_GET['id'])) {
            $guide = $this->GuiderManagerModel->getDetailGuide($_GET['id']);
            renderLayoutAdmin("admin/GuideManager/detailGuide.php", ["guide" => $guide], "Thông tin chi tiết");
        } else {
            echo "Không tìm thấy id";
        }


    }
    public function editGuide()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo "Không tìm thấy id";
            return;
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateOfBirth = $_POST['date_of_birth'];
            $gender = $_POST['gender'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $certifications = $_POST['certifications'];
            $language = $_POST['language'];
            $bio = $_POST['bio'];

            if ($gender === "male") {
                $_SESSION['errorMale'] = "TEST Cái";
            }
            if ($this->GuiderManagerModel->updateProfileGuide($_GET['id'], $dateOfBirth, $gender, $phone, $address, $certifications, $language, $bio)) {
                $_SESSION['success'] = "Cập nhật hướng dẫn viên thành công";
                header('location:/dashboard/guide-manager/profile-guide/edit?id=' . $id . '');
            } else {
                echo "FALSE";
            }
        }

        $guide = $this->GuiderManagerModel->getDetailGuide($id);
        if (!$guide) {
            echo "Không tìm thấy hướng dẫn viên";
            return;
        }

        renderLayoutAdmin(
            "admin/GuideManager/editGuide.php",
            ["guide" => $guide],
            "Sửa thông tin hướng dẫn viên"
        );
    }

}
?>