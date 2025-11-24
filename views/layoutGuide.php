<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLTDL-HDV</title>
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

        .logout-btn {
            padding: 8px 14px;
            background-color: #d4660dff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            bottom: 0;
            width: 240px;
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
                <i class="fa-solid fa-user-tie"></i>
            </div>
           <h2>HDV - Quản lí Tour du lịch</h2>
        </div>
        <div class="header-right">
            <div class="user-info">
                <div class="user-avatar">H</div>
                <div class="user-details">
                    <div class="user-name">HDV Nguyễn Văn A</div>
                    <div class="user-role">Hướng dẫn viên</div>
                </div>
            </div>
            <button class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</button>
        </div>
    </div>


    <div class="sidebar">
        <a href="#" class="menu-item active">
            <div class="menu-icon"><i class="fa-regular fa-calendar"></i></div>
            <span>Lịch làm việc</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"><i class="fa-regular fa-user"></i></div>
            <span>Danh sách khách</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"><i class="fa-solid fa-check"></i></div>
            <span>Check-in / điểm danh</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"><i class="fa-regular fa-note-sticky"></i></div>
            <span>Quản lý lịch tour</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"><i class="fa-solid fa-book"></i></div>
            <span>Ghi chú</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"><i class="fa-regular fa-comment-dots"></i></div>
            <span>Báo cáo cuối Tour</span>
        </a>
        <a href="#" class="menu-item">
            <div class="menu-icon"> <i class="fa-regular fa-id-badge"></i></div>
            <span>Hồ sơ cá nhân</span>
        </a>
    </div>


</body>

</html>