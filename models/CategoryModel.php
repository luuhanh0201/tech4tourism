<?php
class CategoryModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }


    function getAllCategory()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>