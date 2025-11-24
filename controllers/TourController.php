<?php
require './models/TourModel.php';
class TourController
{
    protected $TourModel;
    public function __construct()
    {
        $this->TourModel = new TourModel();
    }

    function index()
    {
        $tours = $this->TourModel->getAllToursModel();
        renderLayoutAdmin("admin/Tour/index.php", ["tours" => $tours], "Quản lý tour");



    }
    function addNewTour()
    {

        include "./views/admin/Tour/addTour.php";
    }
}
?>