<?php
class CustomerModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    function getAllCustomerByBookingId($id)
    {
        try {
            $sql = "SELECT * FROM customers WHERE booking_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

?>