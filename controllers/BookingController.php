<?php
// require './models/CategoryModel.php';
require './models/BookingModel.php';
class BookingController
{
    protected $TourModel;
    protected $CategoryModel;
    protected $BookingModel;
    public function __construct()
    {
        $this->TourModel = new TourModel();
        $this->CategoryModel = new CategoryModel();
        $this->BookingModel = new BookingModel();
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
                // var_dump($_POST);
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
                }

            }
        } catch (\Throwable $th) {
            throw $th;
        }
        $tours = $this->TourModel->getAllToursModel();
        // include "views/admin/Booking/createBooking.php";
        renderLayoutAdmin("admin/Booking/createBooking.php", ['tours' => $tours], "Tạo booking");

    }

}
?>