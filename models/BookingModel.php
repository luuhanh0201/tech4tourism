<?php
class BookingModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();

    }


    function getAllBookingModel()
    {
        $sql = "SELECT bookings.*,
        tours.tour_name,
        tours.price
        FROM bookings
        JOIN tours ON bookings.tour_id = tours.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDetailBooking($id)
    {
        $sql = "SELECT bookings.*,
        tours.tour_name,
        tours.price
        FROM bookings
        JOIN tours ON bookings.tour_id = tours.id WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function createBookingModel(
        $tourId,
        $bookingCode,
        $contactName,
        $contactPhone,
        $contactEmail,
        $status,
        $paymentStatus,
        $totalPrice,
        $notes,
        $maxPerson,
        $departureDate,
        $customers = []
    ) {
        $sqlBooking = "INSERT INTO bookings (tour_id,booking_code,contact_name,contact_phone,contact_email,status,payment_status,total_price,notes,max_person,departure_date
        ) VALUES (:tour_id,:booking_code,:contact_name,:contact_phone,:contact_email,:status,:payment_status,:total_price,:notes,:max_person,:departure_date)";

        $sqlCustomer = "INSERT INTO customers(booking_id,full_name,gender,date_of_birth,phone,note_type,note_detail
        ) VALUES (:booking_id,:full_name,:gender,:date_of_birth,:phone,:note_type,:note_detail)
        ";

        try {
            $this->conn->beginTransaction();
            $stmtBooking = $this->conn->prepare($sqlBooking);
            $stmtBooking->execute([
                ':tour_id' => $tourId,
                ':booking_code' => $bookingCode,
                ':contact_name' => $contactName,
                ':contact_phone' => $contactPhone,
                ':contact_email' => $contactEmail,
                ':status' => $status,
                ':payment_status' => $paymentStatus,
                ':total_price' => $totalPrice,
                ':notes' => $notes,
                ':max_person' => $maxPerson,
                ':departure_date' => $departureDate,
            ]);
            $bookingId = $this->conn->lastInsertId();

            $stmtCustomer = $this->conn->prepare($sqlCustomer);
            foreach ($customers as $customer) {
                $stmtCustomer->execute([
                    ':booking_id' => $bookingId,
                    ':full_name' => $customer['customer_name'],
                    ':gender' => $customer['gender'],
                    ':date_of_birth' => $customer['date_of_birth'],
                    ':phone' => $customer['customer_phone'],
                    ':note_type' => $customer['customer_note_type'],
                    ':note_detail' => $customer['customer_note_detail'],
                ]);

            }
            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }
}

?>