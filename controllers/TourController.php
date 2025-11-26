<?php
require './models/TourModel.php';
require './models/CategoryModel.php';
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
                $_SESSION["error"] = "Vui lòng điền đủ các trường";

                header("Location: /dashboard/tours-manager/new-tour");

                exit;
            } else {
                $tour = $this->TourModel->addNewTourModel(
                    $category,
                    $tourName,
                    $price,
                    $durationDay,
                    $durationNight,
                    $startLocation,
                    $endLocation,
                    $description,
                    $cancellationPolicy
                );

                $_SESSION["success"] = "Tạo tour thành công";
                header("Location: /dashboard/tours-manager");

            }


        }
        $categories = $this->CategoryModel->getAllCategory();




        include "./views/admin/Tour/addTour.php";
        // renderLayoutAdmin("admin/Tour/addTour.php", ["categories" => $categories], "Thêm tour mới");

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
}
?>