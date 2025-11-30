<title><?= $title ?></title>
<div class="header">
    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-plane"></i>
        </div>
        <h1>FPOLY Quản lý tour</h1>
    </div>

    <div class="header-right">
        <div class="user-info">
            <div class="user-avatar"> <?= strtoupper(substr($_SESSION['user']['fullName'], 0, 1)); ?></div>
            <div class="user-details">
                <div class="user-name"><?= isset($_SESSION['user']['fullName']) ? $_SESSION['user']['fullName'] : 'Admin' ?></div>
                <div class="user-role"><?= isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : 'admin' ?></div>
            </div>
        </div>
    </div>
</div>
<div class="sidebar">
    <a href="/dashboard" class="menu-item <?= $active == 'categories' ? 'active' : '' ?>">
        <i class="fa-solid fa-gauge-high"></i>
        <span>Dashboard</span>
    </a>
    <a href="/dashboard/categories-manager" class="menu-item <?= $active == 'categories' ? 'active' : '' ?>">
        <i class="fa-regular fa-rectangle-list"></i>
        <span>Quản lí danh mục Tour</span>
    </a>

    <a href="/dashboard/tours-manager" class="menu-item <?= $active == 'guides' ? 'active' : '' ?>">
        <i class="fa-solid fa-route"></i>
        <span>Quản lý Tour</span>
    </a>

    <a href="#" class="menu-item <?= $active == 'booking' ? 'active' : '' ?>">
        <i class="fa-regular fa-calendar"></i>
        <span>Quản lí Booking</span>
    </a>

    <a href="/dashboard/guide-manager" class="menu-item <?= $active == 'users' ? 'active' : '' ?>">
        <i class="fa-regular fa-circle-user"></i>
        <span>Quản lí hướng dẫn viên</span>
    </a>

    <a href="#" class="menu-item <?= $active == 'statistic' ? 'active' : '' ?>">
        <i class="fa-solid fa-chart-line"></i>
        <span>Báo cáo - Thống kê</span>
    </a>

    <a href="/sign-out" class="menu-item">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <span>Đăng Xuất</span>
    </a>
</div>

<!-- CONTENT -->
<div class="content-wrapper">
    <?= $content ?>
</div>


<style>
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
        overflow-y: auto;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 30px;
        color: #666;
        text-decoration: none;
        font-size: 15px;
        transition: 0.2s;
    }

    .menu-item:hover {
        background-color: #f8f9fa;
        color: #333;
    }

    .menu-item.active {
        background-color: #d4660dff;
        color: white;
        padding-left: 20px;
        border-radius: 8px;
        margin: 0 12px;
    }

    .content-wrapper {
        margin-top: 50px;
        margin-left: 150px;
        min-height: 100vh;
    }
</style>