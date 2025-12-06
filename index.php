<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link rel="stylesheet" href="./app.css">

</head>

<body>

  <?php
  session_start();


  require_once './commons/env.php'; // Khai báo biến môi trường
  require_once './commons/function.php'; // Hàm hỗ trợ
  
  require_once './models/User.php';
  require_once __DIR__ . '/controllers/AuthController.php';
  require_once __DIR__ . '/controllers/CategoryController.php';
  require_once __DIR__ . '/controllers/DashboardController.php';
  require_once __DIR__ . '/controllers/GuiderManagerController.php';
  require_once __DIR__ . '/controllers/GuideController.php';
  require_once __DIR__ . '/controllers/TourController.php';
  require_once __DIR__ . '/controllers/BookingController.php';
  require "./helpers/View.php";
  require "./helpers/helpers.php";
  require_once './controllers/TourController.php';

  // Route
  $route = '/' . ($_GET['route'] ?? '');
  $authController = (new AuthController());
  $guiderManagerController = (new GuiderManagerController());
  $guideController = (new GuideController());
  $tourController = (new TourController());
  $dashboardController = (new DashboardController());
  $bookingController = (new BookingController());
  $categoryController = (new CategoryController);
  match ($route) {

    // Auth
    '/sign-in' => $authController->SignIn(),
    '/sign-up' => $authController->SignUP(),
    '/sign-out' => $authController->SignOut(),
    '/' => include './views/welcome.php',


    // Admin route

    //guide
    '/dashboard/guide-manager' => $guiderManagerController->index(),
    '/dashboard/guide-manager/profile-guide' => $guiderManagerController->detailGuide(),
    '/dashboard/guide-manager/profile-guide/edit' => $guiderManagerController->editGuide(),

    //tours
    '/dashboard/tours-manager' => $tourController->index(),
    '/dashboard/tours-manager/new-tour' => $tourController->addNewTour(),
    '/dashboard/tours-manager/detail' => $tourController->getDetailTour(),
    '/dashboard/tours-manager/edit-tour' => $tourController->editTour(),
    '/dashboard/tours-manager/delete-tour' => $tourController->deleteTour(),

    //booking
    '/dashboard/booking-manager' => $bookingController->index(),

    //categoies
    '/dashboard/categories-manager'=>$categoryController->index(),
    '/dashboard/categories-manager/delete-category'=>$categoryController->deleteCategory(),
    '/dashboard/categories-manager/new-category'=>$categoryController->addNewCategory(),
    '/dashboard/categories-manager/update-category'=>$categoryController->updateCategory(),

    '/dashboard' => $dashboardController->Dashboard(),


    "/guide" => $guideController->index(),
    default => include './views/errorPage.php',
  };
  ?>
</body>

</html>