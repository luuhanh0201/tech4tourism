<?php
class TourModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }


    function getAllToursModel()
    {
        $sql = "SELECT * FROM tours";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>