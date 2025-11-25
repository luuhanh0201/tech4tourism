<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="./app.css">

</head>

<body>

  <?php
  session_start();


  require_once './commons/env.php'; // Khai báo biến môi trường
  require_once './commons/function.php'; // Hàm hỗ trợ
  
  require_once './controllers/AuthController.php';
  require_once './controllers/DashboardController.php';
  require_once './controllers/GuiderManagerController.php';
  require_once './controllers/GuideController.php';
  require "./helpers/View.php";
  require_once './controllers/TourController.php';

  // Route
  $route = '/' . ($_GET['route'] ?? '');

  match ($route) {

    // Auth
    '/sign-in' => (new AuthController())->SignIn(),
    '/sign-up' => (new AuthController())->SignUP(),
    '/sign-out' => (new AuthController())->SignOut(),
    '/' => include './views/welcome.php',


    // Admin route
    // '/dashboard/categories' => (new AuthController())->SignUP(),
    '/dashboard/guide-manager' => (new GuiderManagerController())->index(),
    '/dashboard/guide-manager/profile-guide' => (new GuiderManagerController())->detailGuide(),
    '/dashboard/guide-manager/profile-guide/edit' => (new GuiderManagerController())->editGuide(),
    '/dashboard/tours-manager' => (new TourController())->index(),
    '/dashboard/tours-manager/new-tour' => (new TourController())->addNewTour(),



    '/dashboard' => (new DashboardController())->Dashboard(),


    "/guide" => (new GuideController())->index(),
    default => include './views/errorPage.php',
  };
  ?>
</body>
</html>