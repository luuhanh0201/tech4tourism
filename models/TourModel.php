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
    public function getTourItineraryByDay($tourId)
    {
        $sql = "SELECT * FROM tour_itineraries
            WHERE tour_id = :tour_id
            ORDER BY day_number ASC, sort_order ASC, start_time ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":tour_id" => $tourId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $serviceIds = [],
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
                if (!isset($tourItinerary['day_number'])) {
                    continue;
                }

                $dayNumber = (int) $tourItinerary['day_number'];
                $sortOrder = 1;

                foreach ($tourItinerary as $key => $row) {
                    if ($key === 'day_number') {
                        continue;
                    }
                    if (!is_array($row)) {
                        continue;
                    }
                    $stmtTourItinerary->execute([
                        "tour_id" => $tourId,
                        "day_number" => $dayNumber,
                        "sort_order" => $sortOrder,
                        "title" => $row['title'] ?? null,
                        "description" => $row['description'] ?? null,
                        "start_time" => $row['start_time'] ?? null,
                        "end_time" => $row['end_time'] ?? null,
                    ]);

                    $sortOrder++;
                }
            }
            $this->addServicesToTourModel($tourId, $serviceIds);
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
        $imageUrl,
        $services = [],
        $tourItineraries = []
    ) {
        $sqlTour = "UPDATE tours SET
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

        $sqlDeleteIt = "DELETE FROM tour_itineraries WHERE tour_id = :tour_id";
        $sqlInsertIt = "INSERT INTO tour_itineraries (
        tour_id, day_number, sort_order, title, description, start_time, end_time
    ) VALUES (
        :tour_id, :day_number, :sort_order, :title, :description, :start_time, :end_time
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
                "start_location" => $startLocation,
                "end_location" => $endLocation,
                "description" => $description,
                "cancellation_policy" => $cancellationPolicy,
                "image_url" => $imageUrl,
                "id" => $id
            ]);

            $stmtDel = $this->conn->prepare($sqlDeleteIt);
            $stmtDel->execute(["tour_id" => $id]);

            $stmtIt = $this->conn->prepare($sqlInsertIt);

            foreach ($tourItineraries as $dayBlock) {
                if (!isset($dayBlock['day_number']))
                    continue;
                $dayNumber = (int) $dayBlock['day_number'];

                $sort = 0;
                foreach ($dayBlock as $idx => $row) {
                    if (!is_int($idx) || !is_array($row))
                        continue;
                    $sort++;
                    $title = trim($row['title'] ?? '');
                    $start = $row['start_time'] ?? null;
                    $end = $row['end_time'] ?? null;
                    $desc = $row['description'] ?? null;
                    if ($title === '' && empty($start) && empty($end) && trim((string) $desc) === '') {
                        continue;
                    }
                    $stmtIt->execute([
                        "tour_id" => $id,
                        "day_number" => $dayNumber,
                        "sort_order" => $sort,
                        "title" => $title ?: null,
                        "description" => $desc,
                        "start_time" => $start,
                        "end_time" => $end
                    ]);
                }
            }
            $this->updateServicesToTourModel($id, $services);
            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conn->rollBack();
            throw $e;
        }

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

    public function getAllServicesModel()
    {
        $sql = "SELECT * FROM services ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function addServicesToTourModel($tourId, $serviceIds = [])
    {
        $tourId = (int) $tourId;

        $sql = "INSERT IGNORE INTO tour_services (tour_id, service_id)
            VALUES (:tour_id, :service_id)";

        if (!is_array($serviceIds) || $tourId <= 0) {
            return false;
        }

        $uniqueServiceIds = [];
        foreach ($serviceIds as $serviceId) {
            $serviceId = (int) $serviceId;
            if ($serviceId > 0) {
                $uniqueServiceIds[$serviceId] = true;
            }
        }
        $uniqueServiceIds = array_keys($uniqueServiceIds);

        if (empty($uniqueServiceIds)) {
            return true;
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($uniqueServiceIds as $serviceId) {
            $stmt->execute([
                ':tour_id' => $tourId,
                ':service_id' => (int) $serviceId
            ]);
        }

        return true;
    }
    public function updateServicesToTourModel($tourId, $serviceIds = [])
    {
        $tourId = (int) $tourId;

        if ($tourId <= 0) {
            return false;
        }

        if (!is_array($serviceIds)) {
            $serviceIds = [];
        }

        $uniqueServiceIds = [];
        foreach ($serviceIds as $serviceId) {
            $serviceId = (int) $serviceId;
            if ($serviceId > 0) {
                $uniqueServiceIds[$serviceId] = true;
            }
        }
        $uniqueServiceIds = array_keys($uniqueServiceIds);

        $sqlDelete = "DELETE FROM tour_services WHERE tour_id = :tour_id";
        $stmtDelete = $this->conn->prepare($sqlDelete);
        $stmtDelete->execute([':tour_id' => $tourId]);

        if (empty($uniqueServiceIds)) {
            return true;
        }

        $sqlInsert = "INSERT INTO tour_services (tour_id, service_id)
                  VALUES (:tour_id, :service_id)";
        $stmtInsert = $this->conn->prepare($sqlInsert);

        foreach ($uniqueServiceIds as $serviceId) {
            $stmtInsert->execute([
                ':tour_id' => $tourId,
                ':service_id' => (int) $serviceId
            ]);
        }

        return true;
    }
    public function getAllServicesWithTourModel($tourId)
    {
        $tourId = (int) $tourId;

        $sql = "SELECT
                services.id,
                services.service_name,
                services.service_type,
                services.capacity,
                services.base_price
            FROM services
            INNER JOIN tour_services
                ON tour_services.service_id = services.id
            WHERE tour_services.tour_id = :tour_id
            ORDER BY services.created_at DESC;

    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':tour_id' => $tourId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>