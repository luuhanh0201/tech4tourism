<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLTDL-ADMIN</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #d4660dff 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
            
        }

        .admin-select {
            padding: 8px 35px 8px 15px;
            border: 1px solid #d4660dff;
            border-radius: 6px;
            background-color: white;
            font-size: 14px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%23666' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #d4660dff 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .user-role {
            font-size: 12px;
            color: #888;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            width: 220px;
            background-color: white;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 30px;
            color: #666;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .menu-item:hover {
            background-color: #f8f9fa;
            color: #333;
        }

        .menu-item.active {
            background-color: #d4660dff;
            color: white;
            border-radius: 0;
            margin: 0 13px;
            padding-left: 17px;
            border-radius: 8px;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }       
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-map-pin"></i>
            </div>
           <h1>Admin - Quản lí Tour du lịch</h1>
        </div>
        <div class="header-right">
            <select class="admin-select">
                <option>Admin</option>
                 <option>HDV</option>
            </select>
            <div class="user-info">
                <div class="user-avatar">A</div>
                <div class="user-details">
                    <div class="user-name">Admin User</div>
                    <div class="user-role">Admin</div>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar">
        <a href="#" class="menu-item active">
            <div class="menu-icon">
                <i class="fa-regular fa-rectangle-list"></i>
            </div>
            <span>Quản lí danh mục Tour</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 7h-9M14 17H5M15 11l-1.5 6M8.5 11L7 17M5.5 5L7 11h10l1.5-6"></path>
                </svg>
            </div>
            <span>Quản lý Tour</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon">
                <i class="fa-regular fa-calendar"></i>
            </div>
            <span>Quản lí Booking</span>
        </a>

        <a href="#" class="menu-item">
            <div class="menu-icon">
                <i class="fa-regular fa-circle-user"></i>
            </div>
            <span>Quản lí tài khoản</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <span>Báo cáo - Thống kê</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon">
                <i class="fa-regular fa-user"></i>
            </div>
            <span>Hướng dẫn viên</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </div>
            <span>Đăng Xuất</span>
        </a>
    </div>
</body>
</html>