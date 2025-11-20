<?php
require_once "Category.php";

class CategoryModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    function All()
    {
        try {
            $sql = "SELECT * FROM `categories` ";
            $data = $this->conn->query($sql)->fetchAll();
            $danhsach = [];

            foreach ($data as $cate) {
                $pro = new Category;
                $pro->id = $cate["id"];
                $pro->name = $cate["name"];
                $pro->description = $cate["description"];
                $pro->created_at = $cate["created_at"];
                $pro->updated_at = $cate["updated_at"];

                $danhsach[] = $pro;
            }

            return $danhsach;
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

    public function delete($id){
        try{
            $sql = "DELETE FROM `categories` WHERE `id`= $id";
         $data = $this->conn->exec($sql);
        return $data;
        }
        catch (Exception $r) {
            echo $r->getMessage();
        }
    }
}
