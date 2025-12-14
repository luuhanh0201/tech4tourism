<?php
class GuiderManagerModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
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
        $stmt->execute([
            ":user_id" => $id,
            ":date_of_birth" => $dateOfBirth,
            ":gender" => $gender,
            ":phone" => $phone,
            ":address" => $address,
            ":certifications" => $certifications,
            ":language" => $language,
            ":bio" => $bio,

        ]);
        return $stmt->rowCount();

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

    tours.id AS tour_id,
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

            return $stmt->fetch(PDO::FETCH_ASSOC);
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
            return      $stmt->execute([
                ':status' => $status,
                ':id' => $assignmentId,
                ':guide_id' => $guideId
            ]);
           
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}

?>