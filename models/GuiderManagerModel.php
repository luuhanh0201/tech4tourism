<?php
class GuiderManagerModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllGuider()
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
        guide_profiles.bio FROM users JOIN roles ON roles.user_id = users.id JOIN guide_profiles ON guide_profiles.user_id = users.id WHERE roles.role = 'guide'";
        $stmt = $this->conn->prepare($sql);
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
}

?>