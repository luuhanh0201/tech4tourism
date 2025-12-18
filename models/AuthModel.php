<?php
class AuthModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function getUserByEmail($email)
    {
        $sql = "  SELECT users.*, roles.role 
    FROM users
    JOIN roles ON users.id = roles.user_id
    WHERE users.email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createDefaultProfile($id)
    {
        $sql = "INSERT INTO guide_profiles (user_id)
            VALUES (:user_id)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['user_id' => $id]);
    }
    public function setRoleGuide($id)
    {
        $sql = "INSERT INTO roles (user_id)
            VALUES (:user_id)";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['user_id' => $id]);
    }
    public function signUp($password, $email, $fullName)
    {
        if ($this->getUserByEmail($email)) {
            return false;
        }
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (password, email, full_name) 
                VALUES (:password, :email,:full_name)";
        $stmt = $this->conn->prepare($sql);

        $success = $stmt->execute([
            'password' => $hashedPassword,
            'email' => $email,
            'full_name' => $fullName
        ]);
        if ($success) {
            $userId = $this->conn->lastInsertId();
            $this->createDefaultProfile($userId);
            $this->setRoleGuide($userId);
            return $userId;
        }
        $userId = (int) $this->conn->lastInsertId();
        return $userId;

    }


    public function signIn($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if (!$user) {
            return null;
        }
        if (password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    public function checkRoleUser($id)
    {
        $sql = "SELECT * FROM roles WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}