<?php

class TourController
{
    protected $TourModel;
    protected $CategoryModel;
    public function __construct()
    {
        $this->TourModel = new TourModel();
        $this->CategoryModel = new CategoryModel();
    }

    function index()
    {
        $tours = $this->TourModel->getAllToursModel();
        renderLayoutAdmin("admin/Tour/index.php", ["tours" => $tours], "Quản lý tour");



    }
    function addNewTour()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tourName = $_POST['tour_name'];
            $category = $_POST['category_id'];
            $price = $_POST['price'];
            $durationDay = $_POST['duration_day'];
            $durationNight = $_POST['duration_night'];
            $startLocation = $_POST['start_location'];
            $endLocation = $_POST['end_location'];
            $description = $_POST['description'];
            $cancellationPolicy = $_POST['cancellation_policy'];
            $imageUrl = $_FILES['image']['name'];
            if (!empty($imageUrl)) {
                $imageUrl = uploadFile($_FILES['image']);
            }
            if (
                !$tourName ||
                !$category ||
                !$price ||
                !$durationDay ||
                !$durationNight ||
                !$startLocation ||
                !$endLocation ||
                !$description ||
                !$cancellationPolicy
            ) {
                // $_SESSION["error"] = "Vui lòng điền đủ các trường";

                header("Location: /dashboard/tours-manager/new-tour");

                exit;
            } else {
                $this->TourModel->addNewTourModel(
                    $category,
                    $tourName,
                    $price,
                    $durationDay,
                    $durationNight,
                    $startLocation,
                    $endLocation,
                    $description,
                    $cancellationPolicy,
                    $imageUrl
                );

                $_SESSION["success"] = "Tạo tour thành công";
                header("Location: /dashboard/tours-manager");

            }


        }
        $categories = $this->CategoryModel->All();




        // include "./views/admin/Tour/addTour.php";
        renderLayoutAdmin("admin/Tour/addTour.php", [
            "categories" => $categories,
        ], "Thêm tour mới");

    }
    function getDetailTour()
    {
        if (!isset($_GET['id'])) {
            exit;
        }

        $tour = $this->TourModel->getDetailTourModel($_GET['id']);
        // var_dump($tour);
        renderLayoutAdmin("admin/Tour/detailTour.php", ['tour' => $tour], "Chi tiết tour");

    }
    function editTour()
    {
        if (!isset($_GET['id'])) {
            exit;
        }
        $categories = $this->CategoryModel->All();

        $tour = $this->TourModel->getDetailTourModel($_GET['id']);
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $tourName = $_POST['tour_name'];
            $category = $_POST['category_id'];
            $price = $_POST['price'];
            $durationDay = $_POST['duration_day'];
            $durationNight = $_POST['duration_night'];
            $startLocation = $_POST['start_location'];
            $endLocation = $_POST['end_location'];
            $description = $_POST['description'];
            $cancellationPolicy = $_POST['cancellation_policy'];
            $id = $_GET['id'];
            $imageUrl = $tour['image_url'] ?? null;
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadPath = uploadFile($_FILES['image']);   // dùng hàm bạn đã có
                if ($uploadPath) {
                    $imageUrl = $uploadPath;

            
                }
            }

            if (
                $this->TourModel->editTourModel(
                    $category,
                    $tourName,
                    $price,
                    $durationDay,
                    $durationNight,
                    $startLocation,
                    $endLocation,
                    $description,
                    $cancellationPolicy,
                    $id,
                    $imageUrl
                )
            ) {
                $_SESSION["success"] = "Sửa tour thành công";
                header("Location: /dashboard/tours-manager");
            } else {
                echo "FALSE";
            }
        }
        renderLayoutAdmin("admin/Tour/editTour.php", ['tour' => $tour, 'categories' => $categories], "Sửa tour");

    }
    function deleteTour()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if ($this->TourModel->deleteTourModel($id)) {
                $_SESSION['success'] = "Xoá tour thành công";
                header("Location: /dashboard/tours-manager");

            } else {
                $_SESSION['error'] = "Xoá tour thất bại";
            }
            exit;
        } else {
            echo "Không có ID tour để xoá";
        }
    }
}
?>