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

    function addNewCategory(
        $name,
        $description,
        $created_at,
        $updated_at
    ) {
        try {
            $sql = "INSERT INTO
             `categories`(`name`, `description`, `created_at`, `updated_at`)
             VALUES (
             :name,
             :description,
             :created_at,
             :updated_at)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ":name" => $name,
                ":description" => $description,
                ":created_at" => $created_at,
                ":updated_at" => $updated_at,
            ]);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
    function deleteCategory($id)
    {
        try {
            $sql = "DELETE FROM `categories` WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::FETCH_ASSOC);
            return $stmt->execute();
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
    function DetailCategory($id)
    {
        try {
            $sql = "SELECT * FROM `categories` WHERE id=:id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([":id" => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }

    function UpdateCategory(
        $id,
        $name,
        $description,
        $created_at,
        $updated_at
    ) {
        try {
            $sql = "UPDATE `categories` 
                SET 
                    `name` = :name,
                    `description` = :description,
                    `created_at` = :created_at,
                    `updated_at` = :updated_at
                WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ":id"          => $id,
                ":name"        => $name,
                ":description" => $description,
                ":created_at"  => $created_at,
                ":updated_at"  => $updated_at
            ]);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
}
