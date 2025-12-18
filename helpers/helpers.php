<?php

// Hàm xác định đường dẫn tuyệt đối tới file view tương ứng
function view_path(string $view): string
{
    $normalized = str_replace('.', DIRECTORY_SEPARATOR, $view);
    return BASE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $normalized . '.php';
}

// Hàm xác định đường dẫn tuyệt đối tới file block tương ứng(thành phần layouts)
function block_path(string $block): string
{
    return BASE_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . $block . '.php';
}

// Hàm view: nạp dữ liệu và hiển thị giao diện
function view(string $view, array $data = []): void
{
    $file = view_path($view);

    if (!file_exists($file)) {
        throw new RuntimeException("View '{$view}' not found at {$file}");
    }

    extract($data, EXTR_OVERWRITE); // biến hóa mảng $data thành biến riêng lẻ
    include $file;
}

// Hàm include block: nạp một block từ thư mục blocks(thành phần layouts)
function block(string $block, array $data = []): void
{
    $file = block_path($block);

    if (!file_exists($file)) {
        throw new RuntimeException("Block '{$block}' not found at {$file}");
    }

    extract($data, EXTR_OVERWRITE); // biến hóa mảng $data thành biến riêng lẻ
    include $file;
}

// Tạo đường dẫn tới asset (css/js/images) trong thư mục public(tài nguyên)
function asset(string $path): string
{
    $trimmed = ltrim($path, '/');
    return rtrim(BASE_URL, '/') . '/public/' . $trimmed;
}

// Khởi động session nếu chưa khởi động(session là một cơ chế để lưu trữ dữ liệu trên server)
function startSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Lưu thông tin user vào session sau khi đăng nhập thành công
// @param User $user Đối tượng User cần lưu vào session
function loginUser($user)
{
    startSession();
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_fullName'] = $user->fullName;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_role'] = $user->role;
    $_SESSION['user_avatar'] = $user->avatar;
}

// Đăng xuất: xóa toàn bộ thông tin user khỏi session
function logoutUser()
{
    startSession();
    unset($_SESSION['user']);

    session_destroy();
}

// Kiểm tra xem user đã đăng nhập chưa
// @return bool true nếu đã đăng nhập, false nếu chưa
function isLoggedIn()
{
    startSession();
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

// Lấy thông tin user hiệ
// @return User|null Trả về đối tượng User nếu đã đăng nhập, null nếu chưa
function getCurrentUser()
{
    if (!isLoggedIn()) {
        return null;
    }

    startSession();
    return new User([
        'id' => $_SESSION['user_id'],
        'name' => $_SESSION['user_fullName'],
        'email' => $_SESSION['user_email'],
        'role' => $_SESSION['user_role'],
        'avatar' => $_SESSION['user_avatar']
    ]);
}

// Kiểm tra xem user hiện tại có phải là admin không
// @return bool true nếu là admin, false nếu không
function isAdmin()
{
    $user = getCurrentUser();
    return $user && $user->isAdmin();
}

// Kiểm tra xem user hiện tại có phải là hướng dẫn viên không
// @return bool true nếu là hướng dẫn viên, false nếu không
function isGuide()
{
    $user = getCurrentUser();
    return $user && $user->isGuide();
}

// Yêu cầu đăng nhập: nếu chưa đăng nhập thì chuyển hướng về trang login
// @param string $redirectUrl URL chuyển hướng sau khi đăng nhập (mặc định là trang hiện tại)
function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: /");
        exit;
    }
}


// Yêu cầu quyền admin: nếu không phải admin thì chuyển hướng về trang chủ
function requireAdmin()
{
    requireLogin();

    if ($_SESSION['user']['role'] !== 'admin') {
        header("Location: /guide"); // ép về giao diện guide
        exit;
    }
}

// Yêu cầu quyền hướng dẫn viên hoặc admin

function requireGuide()
{
    requireLogin();

    if (!in_array($_SESSION['user']['role'], ['guide', 'admin'])) {
        header("Location: /guide");
        exit;
    }
}

function generateBookingCode(): string
{
    $numberPart = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $charPart = chr(random_int(65, 90)); // 65-90 = A-Z

    return 'BK' . $numberPart . $charPart;
}
