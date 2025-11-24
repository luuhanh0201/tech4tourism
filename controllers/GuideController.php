<?php

class GuideController
{
    public $GuideModel;
    public function index()
    {
        renderLayoutGuide("guideViews/index.php", [], "Sửa thông tin hướng dẫn viên");
    }
}
