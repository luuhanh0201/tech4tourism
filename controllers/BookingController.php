<?php
// require './models/CategoryModel.php';
require './models/BookingModel.php';
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
        $bookings = $this->BookingModel->getAllBookingModel();

        // $tours = $this->TourModel->getAllToursModel();
        renderLayoutAdmin("admin/Booking/index.php", ['bookings' => $bookings], "Danh sách booking");
    }
    function createBooking()
    {
        try {
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
                // echo '<pre>';
                // print_r($_POST);
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
                        $customers
                    )
                ) {
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
        $tours = $this->TourModel->getAllToursModel();
        // include "views/admin/Booking/createBooking.php";
        renderLayoutAdmin("admin/Booking/createBooking.php", ['tours' => $tours], "Tạo booking");

    }

    function editBooking()
    {
        $booking = $this->BookingModel->getDetailBooking($_GET['id']);
        $tour = $this->TourModel->getDetailTourModel($booking['tour_id']);
        $customers = $this->CustomerModel->getAllCustomerByBookingId($_GET['id']);
        $guides = $this->GuiderManagerModel->getAllGuider('Trống lịch');

        try {
            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                $bookingId = (int) $_GET['id']; // hoặc lấy từ route
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
                $guideId = $_POST['guide_id'];
                $guideNote = $_POST['guide_note'];
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
                        $guideId,
                        $guideNote,
                        $listCustomer,
                    )
                ) {
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
            'guides' => $guides
        ], "Sửa booking");

    }

    function detailBooking()
    {
        $booking = $this->BookingModel->getDetailBooking($_GET['id']);
        $tour = $this->TourModel->getDetailTourModel($booking['tour_id']);
        $customers = $this->CustomerModel->getAllCustomerByBookingId($_GET['id']);

        $idBooking = $_GET['id'];
        $idUser = $_SESSION['user']['id'];

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
            'logBooking' => $logBooking
        ], "Chi tiết booking");

    }


}
?>