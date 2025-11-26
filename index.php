<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
  integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<?php
// session_start();


require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

require_once './controllers/DashboardController.php';
require_once './controllers/CategoryController.php';
require_once './controllers/CategoryController.php';

// Auth
require_once './models/CategoryModel.php';

// Route
$route = '/' . trim($_GET['route'] ?? '', '/');
$route = $route === '/' ? '/' : $route;

$id = "";
if(isset($_GET['id'])){
    $id = $_GET['id']?? '/';
}
match ($route) {

  // HDV
  // Auth
  '/sign-in' => (new AuthController())->SignIn(),
  '/sign-up' => (new AuthController())->SignUP(),

  // Categories
  '/categories' => (new AuthController())->SignUP(),
  //CategoryCotroller
  '/All_category' =>(new CategoryController())->All_category(),
  '/Created_category' => (new CategoryController())->Created_category(),
  '/Delete_category'=>(new CategoryController())->Delete_category($id),
  '/Update_category'=>(new CategoryController())->Update_category($id),

  '/' => (new DashboardController())->Dashboard(),

  default => include './views/errorPage.php',
};


// Comment test branch mới để gộp vào main