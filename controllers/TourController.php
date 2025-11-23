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
        include "./views/admin/Tour/index.php";

    }
    function addNewTour()
    {

        include "./views/admin/Tour/addTour.php";
    }
}
?>