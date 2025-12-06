<?php if ($_SESSION['user']['role'] === 'admin'): ?>
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
          <div class="user-name">
            <?= isset($_SESSION['user']['fullName']) ? $_SESSION['user']['fullName'] : 'Admin' ?>
          </div>
          <div class="user-role"><?= isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : '' ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php elseif ($_SESSION['user']['role'] === 'guide'): ?>
  <div class="header">
    <div class="logo">
      <div class="logo-icon">
        <i class="fa-solid fa-plane"></i>
      </div>
      <h2>HDV - Quản lí Tour du lịch</h2>
    </div>
    <div class="header-right">
      <div class="user-info">
        <div class="user-avatar"><?= strtoupper(substr($_SESSION['user']['fullName'], 0, 1)); ?></div>
        <div class="user-details">
          <div class="user-name">
            <?= isset($_SESSION['user']['fullName']) ? $_SESSION['user']['fullName'] : 'Nguyễn Văn A' ?>
          </div>
          <div class="user-role">Hướng dẫn viên</div>
        </div>
      </div>
      <a href="/sign-out" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
    </div>
  </div>

<?php endif; ?>


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
</style>