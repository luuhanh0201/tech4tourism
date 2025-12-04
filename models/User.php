<?php

// Model User đại diện cho thực thể người dùng trong hệ thống
class User
{
    // Các thuộc tính của User (theo session login)
    public $id;
    public $fullName;
    public $email;
    public $avatar;
    public $role;

    // Constructor để khởi tạo thực thể User
    public function __construct($data = [])
    {
        if (is_array($data)) {
            $this->id = $data['id'] ?? null;
            $this->fullName = $data['fullName'] ?? '';
            $this->email = $data['email'] ?? '';
            $this->avatar = $data['avatar'] ?? '';
            $this->role = $data['role'] ?? 'guide';
        }
    }

    // Trả về tên người dùng để hiển thị
    public function getName()
    {
        return $this->fullName;
    }

    // Kiểm tra xem user có phải là admin không
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Kiểm tra xem user có phải là hướng dẫn viên không
    public function isGuide()
    {
        return $this->role === 'guide';
    }
}
