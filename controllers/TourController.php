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
        $categories = $this->CategoryModel->All();
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $keyword = $_POST['keyword'];
            $status = $_POST['status'];
            $category = $_POST['cate'];
            $tours = $this->TourModel->searchTour($keyword ?? "", $status ?? null, $category ?? null);


        }
        renderLayoutAdmin("admin/Tour/index.php", ["tours" => $tours, 'categories' => $categories], "Quản lý tour");
    }
    function addNewTour()
    {
        $services = $this->TourModel->getAllServicesModel();
        try {
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
                $tourItineraries = $_POST['tour_itinerary'];
                $serviceIds = $_POST['service_ids'];

                if (!empty($imageUrl)) {
                    $imageUrl = uploadFile($_FILES['image']);
                }
                $this->TourModel->addNewTourModel(
                    $tourName,
                    $category,
                    $price,
                    $durationDay,
                    $durationNight,
                    $startLocation,
                    $endLocation,
                    $description,
                    $cancellationPolicy,
                    $imageUrl,
                    $serviceIds,
                    $tourItineraries
                );

                $_SESSION["success"] = "Tạo tour thành công";
                header("Location: /dashboard/tours-manager");
                exit;
            }
            $categories = $this->CategoryModel->All();
        } catch (\Throwable $th) {
            throw $th;
        }




        renderLayoutAdmin("admin/Tour/addTour.php", [
            "categories" => $categories,
            'services' => $services
        ], "Thêm tour mới");

    }
    function getDetailTour()
    {
        if (!isset($_GET['id'])) {
            exit;
        }

        $tour = $this->TourModel->getDetailTourModel($_GET['id']);
        $tourItineraries = $this->TourModel->getTourItineraryByDay($tour['id']);
        $services = $this->TourModel->getAllServicesWithTourModel($tour['id']);
        // var_dump($tour)
        // echo "<pre>";
        // print_r($tourItineraries);
        // echo "</pre>";
        // die;
        renderLayoutAdmin("admin/Tour/detailTour.php", ['tour' => $tour, 'tourItineraries' => $tourItineraries, 'services' => $services], "Chi tiết tour");

    }
    function editTour()
    {
        if (!isset($_GET['id'])) {
            exit;
        }
        $categories = $this->CategoryModel->All();
        $services = $this->TourModel->getAllServicesModel();
        $tour = $this->TourModel->getDetailTourModel($_GET['id']);
        $serviceWithTour = $this->TourModel->getAllServicesWithTourModel($tour['id']);
        $tourItinerariesData = $this->TourModel->getTourItineraryByDay($tour['id']);

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
            $services = $_POST['service_ids'] ?? [];
            $tourItineraries = $_POST['tour_itinerary'] ?? [];

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
                    $imageUrl,
                    $services,
                    $tourItineraries
                )
            ) {
                $_SESSION["success"] = "Sửa tour thành công";
                header("Location: /dashboard/tours-manager");
            } else {
                echo "FALSE";
            }
        }
        renderLayoutAdmin("admin/Tour/editTour.php", [
            'tour' => $tour,
            'categories' => $categories,
            'tourItineraries' => $tourItinerariesData,
            'services' => $services,
            'serviceWithTour' => $serviceWithTour
        ], "Sửa tour");

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