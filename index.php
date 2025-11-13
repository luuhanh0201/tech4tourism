<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
  integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="./app.css">
<?php
// session_start();


require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

require_once './controllers/DashboardController.php';


// Auth
require_once './controllers/AuthController.php';

// Route
$route = '/' . ($_GET['route'] ?? '');

match ($route) {

  '/sign-in' => (new AuthController())->SignIn(),
  '/sign-up' => (new AuthController())->SignUP(),





  '/' => (new DashboardController())->Dashboard(),

  default => include './views/errorPage.php',
};

