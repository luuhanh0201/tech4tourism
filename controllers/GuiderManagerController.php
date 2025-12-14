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

        if (empty($dateOfBirth)) {
            $errors['date_of_birth'] = "Vui lòng nhập ngày sinh";
        } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dateOfBirth)) {
            $errors['date_of_birth'] = "Định dạng ngày sinh không hợp lệ (YYYY-MM-DD)";
        }

        $validGender = ['Nam', 'Nữ'];
        if (!in_array($gender, $validGender)) {
            $errors['gender'] = "Giới tính không hợp lệ";
        }

        if (empty($phone)) {
            $errors['phone'] = "Vui lòng nhập số điện thoại";
        } elseif (!preg_match("/^[0-9]{10,11}$/", $phone)) {
            $errors['phone'] = "Số điện thoại không hợp lệ (10–11 số)";
        }

        if (empty($address)) {
            $errors['address'] = "Vui lòng nhập địa chỉ";
        }

        if (strlen($certifications) > 255) {
            $errors['certifications'] = "Chứng chỉ quá dài (tối đa 255 ký tự)";
        }

        if (empty($language)) {
            $errors['language'] = "Vui lòng nhập ngôn ngữ";
        }

        if (empty($bio)) {
            $errors['bio'] = "Vui lòng nhập mô tả";
        } elseif (strlen($bio) < 20) {
            $errors['bio'] = "Mô tả quá ngắn (tối thiểu 20 ký tự)";
        }

        if (!empty($errors)) {
            $guide = $this->GuiderManagerModel->getDetailGuide($id);

            return renderLayoutAdmin(
                "admin/GuideManager/editGuide.php",
                [
                    "guide" => $guide,
                    "errors" => $errors
                ],
                "Sửa thông tin hướng dẫn viên"
            );
        }

        if ($this->GuiderManagerModel->updateProfileGuide($id, $dateOfBirth, $gender, $phone, $address, $certifications, $language, $bio)) {
            $_SESSION['success'] = "Cập nhật hướng dẫn viên thành công";
            header('location:/dashboard/guide-manager/profile-guide?id=' . $id);
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
