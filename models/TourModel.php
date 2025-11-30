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
        $sql = "SELECT tours.*, categories.name as category_name FROM tours JOIN categories on categories.id = tours.category_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getDetailTourModel($id)
    {
        $sql = "SELECT tours.*, categories.name as category_name FROM tours JOIN categories on categories.id = tours.category_id WHERE tours.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function addNewTourModel(
        $tourName,
        $category,
        $price,
        $durationDay,
        $durationNight,
        $startLocation,
        $endLocation,
        $description,
        $cancellationPolicy
    ) {
        $sql = "INSERT INTO tours (
                        category_id,
                        tour_name,
                        price,
                        duration_day,
                        duration_night,
                        start_location,
                        end_location,
                        description,
                        cancellation_policy)
                                    VALUES (:tour_name,
                        :category_id,
                        :price,
                        :duration_day,
                        :duration_night,
                        :start_location,
                        :end_location,
                        :description,
                        :cancellation_policy)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            "category_id" => $category,
            "tour_name" => $tourName,
            "price" => $price,
            "duration_day" => $durationDay,
            "duration_night" => $durationNight,
            "start_location" => $startLocation,
            "end_location" => $endLocation,
            "description" => $description,
            "cancellation_policy" => $cancellationPolicy
        ]);
    }

    function editTourModel(
        $id,
        $tourName,
        $category,
        $price,
        $durationDay,
        $durationNight,
        $startLocation,
        $endLocation,
        $description,
        $cancellationPolicy
    ) {
        $sql = "";
    }

}

?>