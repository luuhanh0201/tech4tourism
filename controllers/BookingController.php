<?php
// require './models/CategoryModel.php';
class BookingController
{
    protected $TourModel;
    protected $CategoryModel;
    protected $BookingModel;
    protected $CustomerModel;
    protected $GuiderManagerModel;
    public function __construct()
    {
        $this->TourModel = new TourModel();
        $this->CategoryModel = new CategoryModel();
        $this->BookingModel = new BookingModel();
        $this->CustomerModel = new CustomerModel();
        $this->GuiderManagerModel = new GuiderManagerModel();
    }

    function index()
    {
        $keyword = trim($_GET['keyword'] ?? '');
        $status = $_GET['status'] ?? '';
        $sortPrice = $_GET['sort_price'] ?? ''; 
        $sortDate = $_GET['sort_date'] ?? '';  

        $bookings = $this->BookingModel->getAllBookingModel($keyword, $status, $sortPrice, $sortDate);
        renderLayoutAdmin("admin/Booking/index.php", [
            'bookings' => $bookings,
            'filters' => [
                'keyword' => $keyword,
                'status' => $status,
                'sort_price' => $sortPrice,
                'sort_date' => $sortDate,
            ]
        ], "Danh sách booking");
    }
    function createBooking()
    {
        try {
            $services = $this->TourModel->getAllServicesModel();

            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                // tour
                $tourId = $_POST['tour_id'] ?? "";
                $bookingCode = generateBookingCode() ?? "";
                $departureDate = $_POST['departure_date'] ?? null;
                $contactName = $_POST['contact_name'] ?? "";
                $contactPhone = $_POST['contact_phone'] ?? "";
                $contactEmail = $_POST['contact_email'] ?? "";
                $customers = $_POST['customer'] ?? [];
                $status = $_POST['status'] ?? "pending";
                $price = (int) ($_POST['price'] ?? 0);
                $paymentStatus = $_POST['payment_status'] ?? "cash";
                $bookingNote = $_POST['booking_note'] ?? "";
                $maxPerson = (count($customers) + 1);
                $totalPrice = $price * (count($customers) + 1);
                $serviceIds = $_POST['service_ids'];
                // echo '<pre>';
                // print_r($serviceIds);
                // echo '</pre>';
                // die;
                if (!$tourId) {
                    $_SESSION['error_tour'] = '<span style="color: red;">Vui lòng chọn tour</span>';
                    exit;
                }
                if (
                    $this->BookingModel->createBookingModel(
                        $tourId,
                        $bookingCode,
                        $contactName,
                        $contactPhone,
                        $contactEmail,
                        $_SESSION['user']['id'],
                        $status,
                        $paymentStatus,
                        $totalPrice,
                        $bookingNote,
                        $maxPerson,
                        $departureDate,
                        $serviceIds,
                        $customers,
                    )
                ) {
                    header("Location: /dashboard/booking-manager");
                    exit;
                } else {
                    echo "Lỗi";
                    die;
                }


            }
        } catch (\Throwable $th) {
            echo $th;
            die;
        }
        $tours = $this->TourModel->getAllToursModel();
        // include "views/admin/Booking/createBooking.php";
        renderLayoutAdmin("admin/Booking/createBooking.php", ['tours' => $tours, "services" => $services], "Tạo booking");

    }

    function editBooking()
    {
        $booking = $this->BookingModel->getDetailBooking($_GET['id']);
        $tour = $this->TourModel->getDetailTourModel($booking['tour_id']);
        $customers = $this->CustomerModel->getAllCustomerByBookingId($_GET['id']);
        $guides = $this->GuiderManagerModel->getAllGuider('');
        $oldGuideId = $booking['guide_id'] ?? null;
        $services = $this->TourModel->getAllServicesWithTourModel($booking['tour_id']);
        $serviceCurrent = $this->BookingModel->getAllServiceByBookingModel($booking['id']);
        // echo "<pre>";
        // print_r( $oldGuideId);
        // echo "</pre>";
        // die;
        try {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $bookingId = (int) $_GET['id'];
                $contactName = $_POST['contact_name'] ?? '';
                $contactPhone = $_POST['contact_phone'] ?? '';
                $contactEmail = $_POST['contact_email'] ?? '';
                $listCustomer = $_POST['customer'] ?? [];
                $status = $_POST['status'] ?? 'pending';
                $paymentStatus = $_POST['payment_status'] ?? 'cash';
                $bookingNote = $_POST['booking_note'] ?? '';
                $maxPerson = count($listCustomer) + 1;
                $totalPrice = (int) ($_POST['total_price'] ?? 0);
                $departureDate = $_POST['departure_date'] ?? null;
                $endedAt = $_POST['ended_at'] ?? null;
                $updatedBy = $_SESSION['user']['id'];
                $newGuideId = $_POST['guide_id'];
                $guideNote = $_POST['guide_note'];
                $isPayment = $_POST['is_payment'] ?? 0;
                $serviceIds = $_POST['service_ids'];
                if ($isPayment) {
                    $status = "confirmed";
                }
                if (
                    $this->BookingModel->updateBookingModel(
                        $bookingId,
                        $contactName,
                        $contactPhone,
                        $contactEmail,
                        $status,
                        $paymentStatus,
                        $bookingNote,
                        $maxPerson,
                        $totalPrice,
                        $departureDate,
                        $updatedBy,
                        $endedAt,
                        $newGuideId,
                        $guideNote,
                        $isPayment,
                        $serviceIds,
                        $listCustomer
                    )
                ) {
                    if ($newGuideId === "") {
                        $this->BookingModel->changeStatusProfileGuideModel($oldGuideId, "Trống lịch");
                    }
                    if ($newGuideId && $newGuideId !== $oldGuideId) {
                        if ($oldGuideId) {
                            $this->BookingModel->changeStatusProfileGuideModel($oldGuideId, "Trống lịch");
                        }
                        $this->BookingModel->changeStatusProfileGuideModel($newGuideId, "Đang dẫn");
                    }
                    header("Location: /dashboard/booking-manager");
                } else {
                    echo "Lỗi";
                    die;
                }


            }
        } catch (\Throwable $th) {
            echo $th;

            die;
        }
        renderLayoutAdmin("admin/Booking/editBooking.php", [
            'booking' => $booking,
            'tour' => $tour,
            'customers' => $customers,
            'guides' => $guides,
            'services' => $services,
            'serviceCurrent' => $serviceCurrent
        ], "Sửa booking");

    }

    function detailBooking()
    {
        $booking = $this->BookingModel->getDetailBooking($_GET['id']);
        $tour = $this->TourModel->getDetailTourModel($booking['tour_id']);
        $customers = $this->CustomerModel->getAllCustomerByBookingId($_GET['id']);
        $guide = $this->BookingModel->getGuideByDetailBookingModel($booking['id']);
        $idBooking = $_GET['id'];
        $idUser = $_SESSION['user']['id'];
        // var_dump($guide);
        // die;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            if ($action === 'cancel') {
                $ok = $this->BookingModel->changeStatusBookingModel(
                    bookingId: $idBooking,
                    userId: $idUser,
                    oldValue: $booking['status'],
                    newValue: 'canceled'
                );

                $_SESSION[$ok ? 'success' : 'error'] = $ok
                    ? 'Đã hủy booking thành công.'
                    : 'Hủy booking thất bại.';

                header('Location: /dashboard/booking-manager/detail?id=' . $idBooking);
                exit;
            }

            $logBooking = $this->BookingModel->changeStatusBookingModel($idBooking, $idUser, $booking['status'], $_POST['canceled']);

        }

        renderLayoutAdmin("admin/Booking/detailBooking.php", [
            'tour' => $tour,
            'booking' => $booking,
            'customers' => $customers,
            'logBooking' => $logBooking,
            'guide' => $guide
        ], "Chi tiết booking");

    }


}
?>