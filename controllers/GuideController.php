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
        if ($this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, "progress")) {
            header("Location: " . $_SERVER['REQUEST_URI'] . "/current-tour");
            exit;
        }
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
            ],
            "Hướng dẫn viên: " . $_SESSION['user']['fullName']
        );
    }
    public function CurrentTour()
    {
        $guideId = $_SESSION['user']['id'];
        $currentTour = $this->GuiderManagerModel->guideAssignmentBookingDetail($guideId, 'progress');
        $customers = $this->CustomerModel->getAllCustomerByBookingId($currentTour['booking_id']);
        // echo "<pre>";
        // print_r($currentTour);
        // die("DEBUG");
        // echo "</pre>";
        renderLayoutAdmin("guideViews/working.php", [
            'currentTour' => $currentTour,

            'customers' => $customers
        ], "Tour đang làm việc");
    }
}
