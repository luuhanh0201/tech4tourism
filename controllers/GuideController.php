<?php

class GuideController
{
    public $GuideModel;
    public function index()
    {
        renderLayoutAdmin("guideViews/index.php", [], title: "Sửa thông tin hướng dẫn viên");
    }
}
