<?php

class GuideController
{
    protected $TourModel;
    protected $BookingModel;
    protected $CustomerModel;
    protected $GuiderManagerModel;
    public function __construct()
    {
        $this->TourModel = new TourModel();
        $this->BookingModel = new BookingModel();
        $this->CustomerModel = new CustomerModel();
        $this->GuiderManagerModel = new GuiderManagerModel();
    }
    public function index()
    {
        $guideId = $_SESSION['user']['id'];
        $guide = $this->GuiderManagerModel->getDetailGuide($guideId);
        $detailAssignment = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, "pending");
        $currentTour = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, "progress");
        $tourSuccess = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, "done");
        //     echo "<pre>";
        //    print_r($tourSuccess);
        //     echo "</pre>";
        // die;
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($this->GuiderManagerModel->changeStatusAssignmentBookingModel($detailAssignment['assignment_id'], $guideId, 'progress')) {
                header("Location: " . $_SERVER['REQUEST_URI'] . "/current-tour");
                exit;
            }
        }
        renderLayoutAdmin(
            "guideViews/index.php",
            [
                'guide' => $guide,
                "detailAssignment" => $detailAssignment,
                "tourSuccess" => $tourSuccess,
                'currentTour' => $currentTour
            ],
            "Hướng dẫn viên: " . $_SESSION['user']['fullName']
        );
    }
    public function CurrentTour()
    {
        $guideId = $_SESSION['user']['id'];
        $currentTour = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, 'progress');
        $customers = $this->CustomerModel->getAllCustomerByBookingId($currentTour['booking_id']);
        $itinerariesByDay = $this->GuiderManagerModel->getTourItinerariesByTourIdModel($currentTour['tour_id']);

        if (!$currentTour) {
            header("Location: /guide");
        }

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $assignmentId = $currentTour['assignment_id'];
            $guideId = $currentTour['guide_id'];
            $bookingId = $currentTour['booking_id'];

            $this->GuiderManagerModel->successBookingModel($bookingId, $guideId, $assignmentId);
            header("location: /guide");
        }
        renderLayoutAdmin("guideViews/working.php", [
            'currentTour' => $currentTour,

            'customers' => $customers,
            'itinerariesByDay' => $itinerariesByDay

        ], "Tour đang làm việc");
    }

    public function ListAndCheckInCustomer()
    {
        $guideId = $_SESSION['user']['id'];
        $currentTour = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, 'progress');
        $customers = $this->CustomerModel->getAllCustomerByBookingId($currentTour['booking_id']);
        // $itinerariesByDay = $this->GuiderManagerModel->getTourItinerariesByTourIdModel($currentTour['tour_id']);
        // echo "<pre>";
        // print_r($itinerariesByDay);
        // die("DEBUG");
        // echo "</pre>";
        if (!$currentTour) {
            header("Location: /guide");
        }
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $checkIn = $_POST['checkin'] ?? [];
            // echo "<pre>";
            // print_r($checkIn);
            // echo "</pre>";
            // die("DEBUG");
            if ($this->GuiderManagerModel->changeStatusCheckInCustomer($currentTour['booking_id'], $checkIn)) {
                header("Location: /guide/current-tour");
                exit;
            }
        }
        renderLayoutAdmin("guideViews/list-checkin.php", [
            'currentTour' => $currentTour,
            'customers' => $customers,
        ], "Danh sách khách hàng");
    }


}
