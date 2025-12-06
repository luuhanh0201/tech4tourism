<?php
class BookingModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }


    function getAllBooking()
    {
        $sql = "SELECT * FROM bookings";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>