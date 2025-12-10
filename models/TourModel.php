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
        $cancellationPolicy,
        $imageUrl
    ) {

        $sql = "INSERT INTO tours (
                        category_id,
                        tour_name,
                        price,
                        duration_day,
                        duration_night,
                        image_url,
                        start_location,
                        end_location,
                        description,
                        cancellation_policy)
                                    VALUES (:tour_name,
                        :category_id,
                        :price,
                        :duration_day,
                        :duration_night,
                        :image_url,
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
            "image_url" => $imageUrl,
            "start_location" => $startLocation,
            "end_location" => $endLocation,
            "description" => $description,
            "cancellation_policy" => $cancellationPolicy
        ]);
    }

    function editTourModel(
        $category,
        $tourName,
        $price,
        $durationDay,
        $durationNight,
        $startLocation,
        $endLocation,
        $description,
        $cancellationPolicy,
        $id,
        $imageUrl
    ) {
        $sql = "UPDATE tours SET
            category_id = :category_id,
            tour_name = :tour_name,
            price = :price,
            duration_day = :duration_day,
            duration_night = :duration_night,
            start_location = :start_location,
            end_location = :end_location,
            description = :description,
            cancellation_policy = :cancellation_policy,
            image_url = :image_url
        WHERE id = :id";
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
            "cancellation_policy" => $cancellationPolicy,
            "image_url" => $imageUrl,
            "id" => $id
        ]);
    }

    function deleteTourModel($id)
    {
        $sql = "DELETE FROM tours WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}

?>