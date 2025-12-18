<?php
class DashboardController
{
    protected $BookingModel;
    protected $TourModel;
    protected $GuiderManagerModel;


    public function __construct()
    {
        $this->BookingModel = new BookingModel();
        $this->GuiderManagerModel = new GuiderManagerModel();
        $this->TourModel = new TourModel();
    }
    public function Dashboard()
    {
        $bookings = $this->BookingModel->getAllBookingModel("", "", "", "desc");
        $totalAmount = $this->BookingModel->totalAmount();
        // echo "<pre>";
        // print_r($totalAmount);
        // echo "</pre>";
        // die;
        $tours = $this->TourModel->getAllToursModel();
        $guides = $this->GuiderManagerModel->getAllGuider();
        renderLayoutAdmin("admin/Dashboard/index.php", [
            'bookings' => $bookings,
            'tours' => $tours,
            'guides' => $guides,
            'totalAmount' => $totalAmount
        ], "Bảng điều khiển");

    }
}
