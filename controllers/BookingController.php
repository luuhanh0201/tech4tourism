<?php
// require './models/TourModel.php';
// require './models/CategoryModel.php';
require './models/BookingModel.php';
class BookingController
{
    // protected $TourModel;
    // protected $CategoryModel;
    protected $BookingModel;
    public function __construct()
    {
        // $this->TourModel = new TourModel();
        // $this->CategoryModel = new CategoryModel();
        $this->BookingModel = new BookingModel();
    }

    function index()
    {
        $bookings = $this->BookingModel->getAllBooking();
        // $tours = $this->TourModel->getAllToursModel();
        renderLayoutAdmin("admin/Booking/index.php", ['bookings' => $bookings], "Danh sách booking");



    }

}
?>