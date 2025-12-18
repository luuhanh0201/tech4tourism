<?php
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
      public function profileGuide()
    {
        if (isset($_GET['id'])) {
            $guide = $this->GuiderManagerModel->getDetailGuide($_GET['id']);
            renderLayoutAdmin("guideViews/profile.php", ["guide" => $guide], "Thông tin chi tiết");
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
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dateOfBirth = trim($_POST['date_of_birth']);
        $gender = $_POST['gender'] ?? '';
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $certifications = trim($_POST['certifications']);
        $language = trim($_POST['language']);
        $bio = trim($_POST['bio']);

       

        if ($this->GuiderManagerModel->updateProfileGuide($id, $dateOfBirth, $gender, $phone, $address, $certifications, $language, $bio)) {
            $_SESSION['success'] = "Cập nhật hướng dẫn viên thành công";
            header('location: /dashboard/guide-manager/profile-guide?id=' . $id);
            exit;
        } else {
            echo "FALSE";
        }
    }

    $guide = $this->GuiderManagerModel->getDetailGuide($id);

    renderLayoutAdmin(
        "admin/GuideManager/editGuide.php",
        [
            "guide" => $guide,
            "errors" => []
        ],
        "Sửa thông tin hướng dẫn viên"
    );
}

}
