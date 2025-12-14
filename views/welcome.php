<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Hệ thống quản lý tour</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap (optional nếu bạn cần) -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome free -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ff8c00 0%, #ff6b00 50%, #ffd27f 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }

        .shape1 {
            top: 10%;
            left: 10%;
            font-size: 80px;
            animation-delay: 0s;
        }

        .shape2 {
            top: 60%;
            right: 10%;
            font-size: 100px;
            animation-delay: 3s;
        }

        .shape3 {
            bottom: 10%;
            left: 50%;
            font-size: 120px;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-30px) rotate(5deg); }
            50% { transform: translateY(-60px) rotate(-5deg); }
            75% { transform: translateY(-30px) rotate(3deg); }
        }

        .main-container {
            position: relative;
            z-index: 1;
            padding: 40px 15px;
        }

        /* Header with Animation */
        .header-section {
            text-align: center;
            color: white;
            margin-bottom: 60px;
            animation: fadeInDown 1s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .plane-icon {
            font-size: 80px;
            margin-bottom: 20px;
            display: inline-block;
            animation: bounce 2s infinite;
            filter: drop-shadow(0 5px 15px rgba(255,255,255,0.3));
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .header-section h1 {
            font-weight: 800;
            font-size: 3rem;
            margin-bottom: 15px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-section p {
            font-size: 1.3rem;
            opacity: 0.95;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        /* Glass Morphism Welcome Card */
        .welcome-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 45px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 60px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: fadeInUp 1s ease-out 0.3s both;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-card h2 {
            color: white;
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .info-icon {
            background: linear-gradient(135deg, #ff8c00, #ff6b00);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 5px 15px rgba(255, 140, 0, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .welcome-card p {
            color: white;
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 35px;
            position: relative;
        }

        .login-btn {
            background: linear-gradient(135deg, #ff8c00, #ff6b00);
            color: white;
            border: none;
            padding: 18px 45px;
            font-size: 1.2rem;
            font-weight: 700;
            border-radius: 50px;
            display: inline-block;
            text-decoration: none;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.4);
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 12px 35px rgba(255, 140, 0, 0.6);
        }

        /* Features Section */
        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 1s ease-out both;
        }

        .feature-card:nth-child(1) { animation-delay: 0.5s; }
        .feature-card:nth-child(2) { animation-delay: 0.7s; }
        .feature-card:nth-child(3) { animation-delay: 0.9s; }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #ff8c00, #ff6b00, #ffd27f);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .feature-card:hover::after {
            transform: translateX(0);
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 20px 50px rgba(255, 140, 0, 0.3);
        }

        .feature-icon {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #ff8c00, #ff6b00);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: white;
            box-shadow: 0 8px 25px rgba(255, 140, 0, 0.4);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotateY(360deg);
            box-shadow: 0 12px 35px rgba(255, 140, 0, 0.6);
        }

        .feature-card h3 {
            color: #333;
            font-weight: 800;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: var(--color-text-sub);
            font-size: 1rem;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 60px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeInUp 1s ease-out both;
        }

        .stat-card:nth-child(1) { animation-delay: 1.1s; }
        .stat-card:nth-child(2) { animation-delay: 1.3s; }
        .stat-card:nth-child(3) { animation-delay: 1.5s; }
        .stat-card:nth-child(4) { animation-delay: 1.7s; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-section h1 {
                font-size: 2rem;
            }

            .header-section p {
                font-size: 1rem;
            }

            .welcome-card {
                padding: 30px 20px;
            }

            .welcome-card h2 {
                font-size: 1.5rem;
            }

            .features-section {
                grid-template-columns: 1fr;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

<div class="bg-animation">
    <div class="floating-shape shape1">
        <i class="fa-solid fa-location-dot"></i>
    </div>
    <div class="floating-shape shape2">
        <i class="fa-solid fa-compass"></i>
    </div>
    <div class="floating-shape shape3">
        <i class="fa-solid fa-map"></i>
    </div>
</div>

<div class="main-container">
    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <div class="plane-icon">
                <i style="font-size: 55px;" class="fa-solid fa-plane-departure"></i>
            </div>
            <h1>Hệ Thống Quản Lý Tour Du Lịch</h1>
            <p>Giải pháp quản lý tour chuyên nghiệp cho FPOLY HN</p>
        </div>

        <!-- Stats -->
      

        <!-- Welcome Card -->
        <div class="welcome-card">
            <h2>
                <span class="info-icon">
                    <i class="fa-solid fa-star"></i>
                </span>
                Chào mừng đến với hệ thống!
            </h2>
            <p>
                🌏 Khám phá thế giới với hệ thống quản lý tour du lịch hiện đại và chuyên nghiệp.
                Chúng tôi cung cấp giải pháp toàn diện để quản lý tour, khách hàng và doanh thu một cách hiệu quả.
                Hãy đăng nhập để trải nghiệm đầy đủ các chức năng!
            </p>
            <a href="/sign-in" class="login-btn">
                <i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i>Đăng nhập ngay
            </a>
        </div>

        <!-- Features -->
        <div class="features-section">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-plane-departure"></i>
                </div>
                <h3>Quản lý Tour</h3>
                <p>Tạo, chỉnh sửa và quản lý các tour du lịch với giao diện trực quan. Theo dõi lịch trình, giá cả và
                    tình trạng tour một cách dễ dàng.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <h3>Quản lý Khách hàng</h3>
                <p>Lưu trữ thông tin khách hàng chi tiết, lịch sử đặt tour và tương tác. Cung cấp dịch vụ chăm sóc khách
                    hàng tốt nhất.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <h3>Báo cáo & Thống kê</h3>
                <p>Xem báo cáo doanh thu chi tiết với biểu đồ trực quan. Phân tích xu hướng và đưa ra quyết định kinh
                    doanh thông minh.</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
