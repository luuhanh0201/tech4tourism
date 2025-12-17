<?php
class BookingModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();

    }


    function getAllBookingModel()
    {
        $sql = "SELECT
                bookings.*,
                tours.tour_name,
                tours.price,
                users.full_name AS guide_full_name,
                guide_profiles.phone AS guide_phone

            FROM bookings
            JOIN tours
            ON bookings.tour_id = tours.id
            LEFT JOIN guide_assignments
            ON guide_assignments.id = (
            SELECT guide_assignments_inner.id
            FROM guide_assignments AS guide_assignments_inner
            WHERE guide_assignments_inner.booking_id = bookings.id
            ORDER BY
                (guide_assignments_inner.status = 'progress') DESC,
                guide_assignments_inner.id DESC
            LIMIT 1
        )
            LEFT JOIN users
            ON users.id = guide_assignments.guide_id

    LEFT JOIN guide_profiles
        ON guide_profiles.user_id = users.id
";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getDetailBooking($id)
    {
        $sql = "SELECT
        bookings.*,
        tours.tour_name,
        tours.price,
        guide_assignments.guide_id AS guide_id,
        users.full_name AS guide_full_name,
        guide_profiles.phone AS guide_phone
    FROM bookings
    JOIN tours
        ON bookings.tour_id = tours.id
    LEFT JOIN guide_assignments
        ON guide_assignments.id = (
            SELECT guide_assignments_inner.id
            FROM guide_assignments AS guide_assignments_inner
            WHERE guide_assignments_inner.booking_id = bookings.id
            ORDER BY
                (guide_assignments_inner.status = 'progress') DESC,
                guide_assignments_inner.id DESC
            LIMIT 1
        )
    LEFT JOIN users
        ON users.id = guide_assignments.guide_id
    LEFT JOIN guide_profiles
        ON guide_profiles.user_id = users.id
    WHERE bookings.id = :id
    LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getGuideByDetailBookingModel($bookingId)
    {
        $sql = "SELECT
                users.full_name AS guide_full_name,
                guide_profiles.phone AS guide_phone
            FROM guide_assignments
            LEFT JOIN users
            ON users.id = guide_assignments.guide_id
            LEFT JOIN guide_profiles
            ON guide_profiles.user_id = users.id

            WHERE guide_assignments.id = (
            SELECT guide_assignments_inner.id
            FROM guide_assignments AS guide_assignments_inner
            WHERE guide_assignments_inner.booking_id = :booking_id
            ORDER BY
                (guide_assignments_inner.status = 'progress') DESC,
                guide_assignments_inner.id DESC
            LIMIT 1
                )
            LIMIT 1
            ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':booking_id' => $bookingId
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function createBookingModel(
        $tourId,
        $bookingCode,
        $contactName,
        $contactPhone,
        $contactEmail,
        $createdBy,
        $status,
        $paymentStatus,
        $totalPrice,
        $notes,
        $maxPerson,
        $departureDate,
        $serviceIds,
        $customers = []
    ) {
        $sqlBooking = "INSERT INTO bookings (tour_id,booking_code,contact_name,contact_phone,contact_email,created_by,status,payment_status,total_price,notes,max_person,departure_date
        ) VALUES (:tour_id,:booking_code,:contact_name,:contact_phone,:contact_email,:created_by,:status,:payment_status,:total_price,:notes,:max_person,:departure_date)";

        $sqlCustomer = "INSERT INTO customers(booking_id,full_name,gender,date_of_birth,phone,note_type,note_detail
        ) VALUES (:booking_id,:full_name,:gender,:date_of_birth,:phone,:note_type,:note_detail)
        ";

        try {
            $this->conn->beginTransaction();
            $stmtBooking = $this->conn->prepare($sqlBooking);
            $stmtBooking->execute([
                ':tour_id' => $tourId,
                ':booking_code' => $bookingCode,
                ':contact_name' => $contactName,
                ':contact_phone' => $contactPhone,
                ':contact_email' => $contactEmail,
                ':created_by' => $createdBy,
                ':status' => $status,
                ':payment_status' => $paymentStatus,
                ':total_price' => $totalPrice,
                ':notes' => $notes,
                ':max_person' => $maxPerson,
                ':departure_date' => $departureDate,
            ]);
            $bookingId = $this->conn->lastInsertId();

            $stmtCustomer = $this->conn->prepare($sqlCustomer);
            foreach ($customers as $customer) {
                $stmtCustomer->execute([
                    ':booking_id' => $bookingId,
                    ':full_name' => $customer['customer_name'],
                    ':gender' => $customer['gender'],
                    ':date_of_birth' => $customer['date_of_birth'],
                    ':phone' => $customer['customer_phone'],
                    ':note_type' => $customer['customer_note_type'],
                    ':note_detail' => $customer['customer_note_detail'],
                ]);

            }
            $this->addServicesToBookingDetailModel($bookingId, $serviceIds);
            $this->conn->commit();
            return true;
        } catch (\Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
                echo "Lỗi: " . $e->getMessage();
            }
        }
    }

    public function updateBookingModel(
        $bookingId,
        $contactName,
        $contactPhone,
        $contactEmail,
        $status,
        $paymentStatus,
        $bookingNote,
        $maxPerson,
        $totalPrice,
        $departureDate,
        $updatedBy,
        $endedAt,
        $guideId,
        $guideNote,
        $isPayment,
        $serviceIds,
        $customers = [],
    ): bool {
        echo $contactPhone;
        $sqlBooking = "
        UPDATE bookings
        SET
            contact_name   = :contact_name,
            contact_phone  = :contact_phone,
            contact_email  = :contact_email,
            status         = :status,
            payment_status = :payment_status,
            notes          = :notes,
            max_person     = :max_person,
            total_price    = :total_price,
            departure_date = :departure_date,
            is_payment = :is_payment,
            updated_by     = :updated_by
        WHERE id = :id
    ";

        $oldIdCustomer = "SELECT id FROM customers WHERE booking_id = :booking_id";

        $sqlInsertCustomer = "
        INSERT INTO customers
            (booking_id, full_name, gender, date_of_birth, phone, note_type, note_detail)
        VALUES
            (:booking_id, :full_name, :gender, :date_of_birth, :phone, :note_type, :note_detail)
    ";

        $sqlUpdateCustomer = "
        UPDATE customers
        SET
            full_name     = :full_name,
            gender        = :gender,
            date_of_birth = :date_of_birth,
            phone         = :phone,
            note_type     = :note_type,
            note_detail   = :note_detail
        WHERE id = :id AND booking_id = :booking_id
    ";

        $sqlDeleteCustomer = "
        DELETE FROM customers
        WHERE id = :id AND booking_id = :booking_id
    ";
        $sqlSelectGuide = "
        SELECT id FROM guide_assignments WHERE booking_id = :booking_id LIMIT 1
    ";
        $sqlInsertGuide = "
        INSERT INTO guide_assignments
            (guide_id, created_by, booking_id, started_at, ended_at, notes)
        VALUES
            (:guide_id, :created_by, :booking_id, :started_at, :ended_at, :notes)
    ";

        $sqlUpdateGuide = "
        UPDATE guide_assignments
        SET
            guide_id = :guide_id,
            started_at = :started_at,
            ended_at = :ended_at,
            notes    = :notes
        WHERE booking_id = :booking_id
    ";
        $sqlDeleteGuide = "DELETE FROM guide_assignments WHERE booking_id = :booking_id";
        try {
            $this->conn->beginTransaction();

            $stmtBooking = $this->conn->prepare($sqlBooking);
            $stmtBooking->execute([
                ':contact_name' => $contactName,
                ':contact_phone' => $contactPhone,
                ':contact_email' => $contactEmail,
                ':status' => $status,
                ':payment_status' => $paymentStatus,
                ':notes' => $bookingNote,
                ':max_person' => $maxPerson,
                ':total_price' => $totalPrice,
                ':departure_date' => $departureDate,
                ':is_payment' => $isPayment,
                ':updated_by' => $updatedBy,
                ':id' => $bookingId,
            ]);

            $stmtOld = $this->conn->prepare($oldIdCustomer);
            $stmtOld->execute([':booking_id' => $bookingId]);
            $oldIds = $stmtOld->fetchAll(PDO::FETCH_COLUMN);

            $keepIds = [];

            $stmtInsert = $this->conn->prepare($sqlInsertCustomer);
            $stmtUpdate = $this->conn->prepare($sqlUpdateCustomer);
            $stmtDelete = $this->conn->prepare($sqlDeleteCustomer);

            foreach ($customers as $customer) {
                $id = $customer['id'] ?? null;
                $fullName = $customer['customer_name'] ?? '';
                $phone = $customer['customer_phone'] ?? '';
                $dateOfBirth = $customer['date_of_birth'] ?? null;
                $gender = $customer['gender'] ?? 'male';
                $noteDetail = $customer['customer_note_detail'] ?? '';
                $noteType = $customer['customer_note_type'] ?? null;

                if (strlen($phone) > 30) {
                    echo "<pre>";
                    echo "PHONE QUÁ DÀI\n";
                    var_dump($customer);
                    echo "len(phone) = " . strlen($phone) . "\n";
                    echo "</pre>";
                    die;
                }
                if (is_array($noteType)) {
                    $noteType = implode(',', $noteType);  // vd: "allergy,wheelchair"
                }

                if ($id) {
                    $stmtUpdate->execute([
                        ':id' => $id,
                        ':booking_id' => $bookingId,
                        ':full_name' => $fullName,
                        ':gender' => $gender,
                        ':date_of_birth' => $dateOfBirth,
                        ':phone' => $phone,
                        ':note_type' => $noteType,
                        ':note_detail' => $noteDetail,
                    ]);
                    $keepIds[] = (int) $id;
                } else {
                    $stmtInsert->execute([
                        ':booking_id' => $bookingId,
                        ':full_name' => $fullName,
                        ':gender' => $gender,
                        ':date_of_birth' => $dateOfBirth,
                        ':phone' => $phone,
                        ':note_type' => $noteType,
                        ':note_detail' => $noteDetail,
                    ]);
                }
            }

            foreach ($oldIds as $oldId) {
                if (!in_array((int) $oldId, $keepIds, true)) {
                    $stmtDelete->execute([
                        ':id' => $oldId,
                        ':booking_id' => $bookingId,
                    ]);
                }
            }


            $guideId = ($guideId === '' || $guideId === null) ? null : (int) $guideId;
            if ($endedAt === '' || $endedAt === null) {
                $endedAt = null;
            }
            if ($guideId !== null && $guideId > 0) {
                $stmtSelectGuide = $this->conn->prepare($sqlSelectGuide);
                $stmtSelectGuide->execute([':booking_id' => $bookingId]);
                $guideAssignmentId = $stmtSelectGuide->fetchColumn();
                if ($endedAt === '') {
                    $endedAt = null;
                }
                if ($guideAssignmentId) {
                    $stmtUpdateGuide = $this->conn->prepare($sqlUpdateGuide);
                    $stmtUpdateGuide->execute([
                        ':guide_id' => $guideId,
                        ':booking_id' => $bookingId,
                        ':started_at' => $departureDate,
                        ':ended_at' => $endedAt,
                        ':notes' => $guideNote,
                    ]);
                } else {
                    $stmtInsertGuide = $this->conn->prepare($sqlInsertGuide);
                    $stmtInsertGuide->execute([
                        ':guide_id' => $guideId,
                        ':created_by' => $updatedBy,
                        ':booking_id' => $bookingId,
                        ':started_at' => $departureDate,
                        ':ended_at' => $endedAt,
                        ':notes' => $guideNote,
                    ]);
                }
            } else {
                $this->conn->prepare($sqlDeleteGuide)
                    ->execute([':booking_id' => $bookingId]);
            }
            $this->updateServicesToBookingModel($bookingId, $serviceIds);
            $this->conn->commit();
            return true;
        } catch (\Throwable $th) {
            $this->conn->rollBack();
            echo "<pre>Lỗi khi update booking: " . $th->getMessage() . "</pre>";
            die;
        }
    }

    function changeStatusBookingModel($bookingId, $userId, $oldValue, $newValue)
    {
        $sqlLog = "INSERT INTO booking_change_logs
                  (booking_id,user_id,old_value,new_value)
                  VALUES
                  (:booking_id,:user_id,:old_value,:new_value)
        ";
        $sqlUpdate = "UPDATE bookings
                    SET
                    status = :status,
                    is_payment = CASE
                    WHEN :status = 'done' THEN 1
                    ELSE is_payment
                    END,
                    updated_by = :updated_by
                    WHERE id = :id";
        try {
            $this->conn->beginTransaction();
            if (!$bookingId) {
                $this->conn->rollBack();
                return $_SESSION['error'] = "Booking không tồn tại. ";
            }
            $allowedStatus = ['pending', 'confirmed', 'canceled', 'done'];
            if (!in_array($newValue, $allowedStatus, true)) {
                $_SESSION['error'] = 'Trạng thái không hợp lệ.';
                return false;
            }
            $stmtLog = $this->conn->prepare($sqlLog);
            $stmtLog->execute([
                ':booking_id' => $bookingId,
                ':user_id' => $userId,
                ':old_value' => $oldValue,
                ':new_value' => $newValue,
            ]);
            $stmtUpdate = $this->conn->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':status' => $newValue,
                ':updated_by' => $userId,
                ':id' => $bookingId,
            ]);
            $this->conn->commit();
        } catch (\Throwable $th) {
            $this->conn->rollBack();
            throw $th;
        }
    }
    function changeStatusProfileGuideModel($guideId, $status)
    {
        $allowedStatuses = ['Trống lịch', 'Đang dẫn', 'Tạm nghỉ'];
        if (!in_array($status, $allowedStatuses, true)) {
            return false;
        }
        $sql = "UPDATE guide_profiles SET status = :status WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':status' => $status,
            ':user_id' => $guideId,
        ]);
    }
    public function addServicesToBookingDetailModel($bookingId, $serviceIds = [])
    {
        $bookingId = (int) $bookingId;

        if ($bookingId <= 0 || !is_array($serviceIds)) {
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
        $placeholders = implode(',', array_fill(0, count($uniqueServiceIds), '?'));
        $sqlGet = "SELECT id, service_name, service_type, base_price
               FROM services
               WHERE id IN ($placeholders)";
        $stmtGet = $this->conn->prepare($sqlGet);
        $stmtGet->execute($uniqueServiceIds);
        $services = $stmtGet->fetchAll(PDO::FETCH_ASSOC);
        $serviceMap = [];
        foreach ($services as $s) {
            $serviceMap[(int) $s['id']] = $s;
        }
        $sqlInsert = "
        INSERT IGNORE INTO booking_details (
            booking_id,
            service_id,
            service_name_current,
            service_type_current,
            unit_price,
            quantity,
            total_price
        ) VALUES (
            :booking_id,
            :service_id,
            :service_name_current,
            :service_type_current,
            :unit_price,
            :quantity,
            :total_price
        )
    ";
        $stmtInsert = $this->conn->prepare($sqlInsert);

        foreach ($uniqueServiceIds as $serviceId) {
            if (empty($serviceMap[$serviceId])) {
                continue;
            }
            $serviceName = $serviceMap[$serviceId]['service_name'] ?? null;
            $serviceType = $serviceMap[$serviceId]['service_type'] ?? null;
            $unitPrice = (int) ($serviceMap[$serviceId]['base_price'] ?? 0);

            $quantity = 1;
            $totalPrice = $unitPrice * $quantity;

            $stmtInsert->execute([
                ':booking_id' => $bookingId,
                ':service_id' => $serviceId,
                ':service_name_current' => $serviceName,
                ':service_type_current' => $serviceType,
                ':unit_price' => $unitPrice,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice
            ]);
        }

        return true;
    }
    public function getAllServiceByBookingModel($bookingId)
    {
        $bookingId = (int) $bookingId;
        if ($bookingId <= 0) {
            return [];
        }

        $sql = "SELECT
            booking_detail.id,
            booking_detail.booking_id,
            booking_detail.service_id,
            booking_detail.service_name_current,
            booking_detail.service_type_current,
            booking_detail.unit_price,
            booking_detail.quantity,
            booking_detail.total_price
        FROM booking_details booking_detail
        WHERE booking_detail.booking_id = :booking_id
        
    ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':booking_id' => $bookingId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateServicesToBookingModel($bookingId, $serviceIds = [])
    {
        $bookingId = (int) $bookingId;

        if ($bookingId <= 0) {
            return false;
        }

        if (!is_array($serviceIds)) {
            $serviceIds = [];
        }

        // unique serviceIds
        $uniqueServiceIds = [];
        foreach ($serviceIds as $serviceId) {
            $serviceId = (int) $serviceId;
            if ($serviceId > 0) {
                $uniqueServiceIds[$serviceId] = true;
            }
        }
        $uniqueServiceIds = array_keys($uniqueServiceIds);

        try {

            $sqlDelete = "DELETE FROM booking_details WHERE booking_id = :booking_id";
            $stmtDelete = $this->conn->prepare($sqlDelete);
            $stmtDelete->execute([':booking_id' => $bookingId]);

            if (empty($uniqueServiceIds)) {
                return true;
            }

            $placeholders = implode(',', array_fill(0, count($uniqueServiceIds), '?'));
            $sqlGet = "SELECT id, service_name, service_type, base_price
                   FROM services
                   WHERE id IN ($placeholders)";
            $stmtGet = $this->conn->prepare($sqlGet);
            $stmtGet->execute($uniqueServiceIds);
            $services = $stmtGet->fetchAll(PDO::FETCH_ASSOC);

            $serviceMap = [];
            foreach ($services as $s) {
                $serviceMap[(int) $s['id']] = $s;
            }

            $sqlInsert = "INSERT INTO booking_details (
                booking_id,
                service_id,
                service_name_current,
                service_type_current,
                unit_price,
                quantity,
                total_price
            ) VALUES (
                :booking_id,
                :service_id,
                :service_name_current,
                :service_type_current,
                :unit_price,
                :quantity,
                :total_price
            )
        ";
            $stmtInsert = $this->conn->prepare($sqlInsert);

            foreach ($uniqueServiceIds as $serviceId) {
                if (empty($serviceMap[$serviceId])) {
                    continue;
                }

                $unitPrice = (int) ($serviceMap[$serviceId]['base_price'] ?? 0);
                $quantity = 1;
                $totalPrice = $unitPrice * $quantity;

                $stmtInsert->execute([
                    ':booking_id' => $bookingId,
                    ':service_id' => $serviceId,
                    ':service_name_current' => $serviceMap[$serviceId]['service_name'] ?? null,
                    ':service_type_current' => $serviceMap[$serviceId]['service_type'] ?? null,
                    ':unit_price' => $unitPrice,
                    ':quantity' => $quantity,
                    ':total_price' => $totalPrice,
                ]);
            }

            return true;

        } catch (Exception $e) {

            return false;
        }
    }
}

?>