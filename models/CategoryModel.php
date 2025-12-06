<?php
require_once "Category.php";

class CategoryModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    function All(): array
    {
        try {
            $sql = "SELECT * FROM `categories`";
            $data = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            // $data lúc này đã là mảng các array ['id' => ..., 'name' => ...]
            return $data;
        } catch (Exception $r) {
            echo $r->getMessage();
        }
    }
    public function create(Category $cate)
    {
        try {
            $sql = "INSERT INTO `categories`(
            `name`,
            `description`,
            `created_at`,
            `updated_at`
        ) VALUES (
            '{$cate->name}',
            '{$cate->description}',
            '{$cate->created_at}',
            '{$cate->updated_at}'
        )";

            $data = $this->conn->exec($sql);
            return $data;
        } catch (Exception $r) {
            echo $r->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $sql = "DELETE FROM `categories` WHERE `id`= $id";
            $data = $this->conn->exec($sql);
            return $data;
        } catch (Exception $r) {
            echo $r->getMessage();
        }
    }
    public function update(Category $cate)
    {
        try {
            $sql = "UPDATE `categories` 
           SET `name`='{$cate->name}'
           ,`description`='{$cate->description}'
           ,`created_at`='{$cate->created_at}'
           ,`updated_at`='{$cate->updated_at}' 
           WHERE `id`=$cate->id";
            $data = $this->conn->exec($sql);
            return $data;
        } catch (Exception $r) {
            echo "" . $r->getMessage();
        }
    }

    public function detail($id)
    {
        try {
            $sql = "SELECT * FROM `categories` WHERE `id`= $id";
            $data = $this->conn->query($sql)->fetch();
            if ($data) {
                $pro = new Category;
                $pro->id = $data["id"];
                $pro->name = $data["name"];
                $pro->description = $data["description"];
                $pro->created_at = $data["created_at"];
                $pro->updated_at = $data["updated_at"];
            }
            return $pro;
        } catch (Exception $r) {
            echo '' . $r->getMessage();
        }
    }
}
