<script>
    document.title = "Không tìm thấy trang";
</script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<?php
$url = "/";
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "admin") {
    $url = "/dashboard";
} else if (isset($_SESSION['user']) && $_SESSION['user']['role'] === "guide") {
    $url = "/guide";
}
?>
<div class="container error-page d-flex align-items-center justify-content-center">
    <div class="error-card text-center">
        <div class="error-icon mb-3">
            <i class="fa-solid fa-location-dot"></i>
        </div>
        <h1 class="error-code">404</h1>
        <h2 class="error-title mb-2">Ôi! Không tìm thấy trang</h2>
        <p class="error-text mb-4">
            Có vẻ như bạn đã đi lạc khỏi hành trình. <br>
            Đường dẫn bạn truy cập không tồn tại hoặc đã bị thay đổi.
        </p>

        <a href="<?= $url ?>" class="btn btn-back-home">
            <i class="fa-solid fa-house me-2"></i>Về trang chủ
        </a>
    </div>
</div>

<style>
    .error-page {
        min-height: calc(100vh - 90px);
    }

    .error-card {
        max-width: 520px;
        width: 100%;
        background: #ffffff;
        border-radius: 20px;
        padding: 32px 28px 30px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.15);
    }

    .error-icon {
        width: 70px;
        height: 70px;
        border-radius: 999px;
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 30px;
        margin: 0 auto 12px;
        box-shadow: 0 12px 30px rgba(148, 64, 0, 0.5);
    }

    .error-code {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 4px;
        color: #ff8c00;
    }

    .error-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .error-text {
        font-size: 14px;
        color: #6b7280;
    }

    .btn-back-home {
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        border: none;
        color: #ffffff;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 999px;
        box-shadow: 0 10px 26px rgba(148, 64, 0, 0.45);
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back-home:hover {
        color: #ffffff;
        opacity: 0.96;
        transform: translateY(-1px);
        box-shadow: 0 14px 32px rgba(148, 64, 0, 0.55);
    }
</style>
