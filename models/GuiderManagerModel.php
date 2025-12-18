<?php
class GuiderManagerModel
{
    public $conn;
    public $BookingModel;
    public function __construct()
    {
        $this->conn = connectDB();
        $this->BookingModel = new BookingModel();
    }

    public function getAllGuider($status = null)
    {
        $sql = "SELECT
        users.id,
        users.full_name,
        users.avatar,
        users.email,
        roles.role,
        guide_profiles.status,
        guide_profiles.date_of_birth,
        guide_profiles.gender,
        guide_profiles.phone,
        guide_profiles.address,
        guide_profiles.avatar_url,
        guide_profiles.certifications,
        guide_profiles.language,
        guide_profiles.rate,
        guide_profiles.bio
    FROM users
    JOIN roles ON roles.user_id = users.id
    JOIN guide_profiles ON guide_profiles.user_id = users.id
    WHERE roles.role = 'guide'";

        if ($status !== null && $status !== '') {
            $sql .= " AND guide_profiles.status = :status";
        }

        $stmt = $this->conn->prepare($sql);

        if ($status !== null && $status !== '') {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailGuide($id)
    {
        $sql = "SELECT
        users.id,
        users.full_name,
        users.avatar,
        users.email,
        roles.role,
        guide_profiles.status,
        guide_profiles.date_of_birth,
        guide_profiles.gender,
        guide_profiles.phone,
        guide_profiles.address,
        guide_profiles.avatar_url,
        guide_profiles.certifications,
        guide_profiles.language,
        guide_profiles.rate,
        guide_profiles.bio FROM users JOIN roles ON roles.user_id = users.id JOIN guide_profiles ON guide_profiles.user_id = users.id WHERE users.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function searchGuide($keyword)
    {
        $keyword = "%$keyword%";
        $sql = "
SELECT 
            users.*, 
            roles.role, 
            guide_profiles.*
        FROM users
        JOIN roles ON roles.user_id = users.id
        JOIN guide_profiles ON guide_profiles.user_id = users.id
        WHERE roles.role = 'guide'
        AND (
            users.full_name LIKE :keyword
            OR guide_profiles.phone LIKE :keyword
            OR users.email LIKE :keyword
        )
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => $keyword]);
        $result = $stmt->fetchAll((PDO::FETCH_ASSOC));
        return $result;
    }
    public function updateProfileGuide($id, $dateOfBirth, $gender, $phone, $address, $certifications, $language, $bio)
    {
        try {
            $sql = "UPDATE guide_profiles 
                SET 
                    date_of_birth = :date_of_birth,
                    gender = :gender,
                    phone = :phone,
                    address=:address,
                    certifications = :certifications,
                    language = :language,
                    bio = :bio
                WHERE user_id = :user_id;";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ":user_id" => $id,
                ":date_of_birth" => $dateOfBirth,
                ":gender" => $gender,
                ":phone" => $phone,
                ":address" => $address,
                ":certifications" => $certifications,
                ":language" => $language,
                ":bio" => $bio,

            ]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }

    public function deleteGuide($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function guideAssignmentBookingDetail($guideId, $status)
    {
        $sql = "SELECT 
    guide_assignments.id AS assignment_id,
    guide_assignments.guide_id AS guide_id,
    guide_assignments.booking_id AS booking_id,
    guide_assignments.started_at AS assignment_started_at,
    guide_assignments.ended_at AS assignment_ended_at,
    guide_assignments.status AS assignment_status,
    guide_assignments.notes AS assignment_notes,

    bookings.booking_code AS booking_code,
    bookings.booking_date AS booking_date,
    bookings.departure_date AS departure_date,
    bookings.status AS booking_status,
    bookings.payment_status AS payment_status,
    bookings.total_price AS booking_total_price,
    bookings.notes AS booking_notes,

    tours.id AS tour_id,
    tours.rate AS tour_rate,
    tours.tour_name AS tour_name,
    tours.duration_day AS tour_duration_day,
    tours.duration_night AS tour_duration_night,

    users.id AS created_by_id,
    users.full_name AS created_by_name,
    users.email AS created_by_email,
    users.avatar AS created_by_avatar
FROM guide_assignments
INNER JOIN bookings 
    ON guide_assignments.booking_id = bookings.id
INNER JOIN tours
    ON bookings.tour_id = tours.id
INNER JOIN users 
    ON guide_assignments.created_by = users.id
WHERE guide_assignments.guide_id = :guide_id
          AND guide_assignments.status = :assignment_status
        ";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ":guide_id" => $guideId,
                ":assignment_status" => $status
            ]);
            if ($status === "done") {
                $a = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $a = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return $a;
        } catch (\Throwable $th) {
            echo "ERROR: " . $th;
            return null;
        }
    }
    public function changeStatusAssignmentBookingModel($assignmentId, $guideId, $status)
    {
        $sql = "UPDATE guide_assignments SET status=:status WHERE id=:id AND guide_id=:guide_id";
        try {
            // echo '<pre>';
            // print_r($assignmentId);
            // print_r($guideId);
            // print_r($status);
            // echo '</pre>';
            // die('--- DEBUG DETAIL ASSIGNMENTS ---');
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':status' => $status,
                ':id' => $assignmentId,
                ':guide_id' => $guideId
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }

    }
    public function getTourItinerariesByTourIdModel($tourId)
    {
        $sql = "SELECT *
        FROM tour_itineraries
        WHERE tour_id = :tour_id
        ORDER BY day_number ASC, sort_order ASC, start_time ASC, id ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tour_id' => $tourId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        $grouped = [];
        foreach ($rows as $row) {
            $day = (int) $row['day_number'];
            $grouped[$day][] = $row;
        }
        return $grouped;
    }
    public function changeStatusCheckInCustomer($bookingId, $checkIn = [])
    {
        $bookingId = (int) $bookingId;
        $checkedIds = [];
        foreach ((array) $checkIn as $customerId => $val) {
            if ((int) $val === 1) {
                $checkedIds[] = (int) $customerId;
            }
        }
        $checkedIds = array_values(array_unique($checkedIds));
        try {
            $this->conn->beginTransaction();
            $sqlReset = "UPDATE customers SET is_checkin = 0 WHERE booking_id = :booking_id";
            $stmt = $this->conn->prepare($sqlReset);
            $stmt->execute([':booking_id' => $bookingId]);
            if (!empty($checkedIds)) {
                $placeholders = implode(',', array_fill(0, count($checkedIds), '?'));
                $sqlSet = "UPDATE customers
                       SET is_checkin = 1
                       WHERE booking_id = ?
                       AND id IN ($placeholders)";
                $stmt2 = $this->conn->prepare($sqlSet);
                $stmt2->execute(array_merge([$bookingId], $checkedIds));
            }
            $this->conn->commit();
            return true;

        } catch (\Throwable $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function successBookingModel($bookingId, $guideId, $assignmentId)
    {
        try {
            $this->conn->beginTransaction();

            // 1) DONE assignment hiện tại
            $this->changeStatusAssignmentBookingModel($assignmentId, $guideId, "done");

            // 2) DONE booking
            $sqlUpdateBooking = "
            UPDATE bookings
            SET status = 'done'
            WHERE id = :id
        ";
            $stmt = $this->conn->prepare($sqlUpdateBooking);
            $stmt->execute([
                ':id' => $bookingId
            ]);

            // 3) CHECK guide còn assignment active không
            $sqlCheck = "
            SELECT COUNT(*) 
            FROM guide_assignments
            WHERE guide_id = :guide_id
              AND status IN ('pending', 'progress')
        ";
            $stmt = $this->conn->prepare($sqlCheck);
            $stmt->execute([
                ':guide_id' => $guideId
            ]);
            $activeCount = (int) $stmt->fetchColumn();

            // 4) UPDATE guide_profiles theo kết quả check
            $newStatus = ($activeCount > 0) ? 'Đang dẫn' : 'Trống lịch';

            $sqlUpdateProfile = "
            UPDATE guide_profiles
            SET status = :status
            WHERE user_id = :user_id
        ";
            $stmt = $this->conn->prepare($sqlUpdateProfile);
            $stmt->execute([
                ':status' => $newStatus,
                ':user_id' => $guideId
            ]);

            $this->conn->commit();
            return true;

        } catch (\Throwable $e) {
            $this->conn->rollBack();

        }
    }

}

?>