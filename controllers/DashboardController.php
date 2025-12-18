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
        // echo "<pre>";
        // print_r($bookings);
        // echo "</pre>";
        // die;
        $tours = $this->TourModel->getAllToursModel();
        $guides = $this->GuiderManagerModel->getAllGuider();
        renderLayoutAdmin("admin/Dashboard/index.php", [
            'bookings' => $bookings,
            'tours' => $tours,
            'guides' => $guides
        ], "Bảng điều khiển");

    }
}
