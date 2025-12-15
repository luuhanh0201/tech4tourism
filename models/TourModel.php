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
        $imageUrl,
        $tourItineraries = []
    ) {

        $sqlTour = "INSERT INTO tours (
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
                                    VALUES (
                        :category_id,
                        :tour_name,
                        :price,
                        :duration_day,
                        :duration_night,
                        :image_url,
                        :start_location,
                        :end_location,
                        :description,
                        :cancellation_policy)";
        $sqlTourItinerary = "INSERT INTO tour_itineraries (
                        tour_id,
                        day_number,
                        sort_order,
                        title,
                        description,
                        start_time,
                        end_time    
        ) VALUES (
                        :tour_id,
                        :day_number,
                        :sort_order,
                        :title,
                        :description,
                        :start_time,
                        :end_time    
        )";
        try {
            $this->conn->beginTransaction();
            $stmtTour = $this->conn->prepare($sqlTour);
            $stmtTour->execute([
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
            $tourId = $this->conn->lastInsertId();


            $stmtTourItinerary = $this->conn->prepare($sqlTourItinerary);
            foreach ($tourItineraries as $tourItinerary) {
                if (!isset($tourItinerary['day_number']))
                    continue;
                $dayDetail = $tourItinerary['day_number'];
                foreach ($tourItinerary as $index => $row) {
                    if (!is_int($day) || !is_array($row))
                        continue;

                    $stmtTourItinerary->execute([
                        "tour_id" => $tourId,
                        "day_number" => $dayDetail,
                        "sort_order" => $index + 1,
                        "title" => $row['title'] ?? null,
                        "description" => $row['description'] ?? null,
                        "start_time" => $row['start_time'] ?? null,
                        "end_time" => $row['end_time'] ?? null,
                    ]);
                }
            }
            $this->conn->commit();
            return true;
        } catch (\Throwable $th) {
            $this->conn->rollBack();
            throw $th;
        }
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
    public function searchTour($keyword = '', $status = '', $categoryId = '')
    {
        $params = [];
        $where = [];

        if ($keyword !== '') {
            $params['keyword'] = "%{$keyword}%";
            $where[] = "tours.tour_name LIKE :keyword";
        }

        if ($status !== '') {
            $params['status'] = $status;
            $where[] = "tours.status = :status";
        }

        if ($categoryId !== '') {
            $params['category_id'] = (int) $categoryId;
            $where[] = "tours.category_id = :category_id";
        }

        $sql = "SELECT tours.*, categories.name as category_name FROM tours JOIN categories on categories.id = tours.category_id";

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY CASE WHEN tours.status = 'active' THEN 0 ELSE 1 END ASC,
                      tours.category_id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>