<?php

class DashboardController
{
    public $ProductModel;

    public function __construct()
    {

    }
    public function Dashboard()
    {

        renderLayoutAdmin("admin/Dashboard/index.php", [], "Bảng điều khiển");

    }
}
