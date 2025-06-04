<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

if (!$conn) {
    echo json_encode(['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()]);
    exit;
}

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES ,'UTF-8') : null;
$password = !empty($_POST['password']) ? htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8') : null;

if (!$username || !$password) {
    echo json_encode(['success' => false, 'message' => '請輸入帳號和密碼']);
    exit;
}

if (!empty($username) && !empty($password)) {
    $sql = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        $storedHashedPassword = $user['password'];

        // 驗證密碼
        if (password_verify($password, $storedHashedPassword)) {
            $sessionId = bin2hex(random_bytes(16)); // 生成唯一 session ID
            // 更新 MySQL 的 SESSIONID 欄位
            $updateSession = "UPDATE tbl_users SET session_id = ? WHERE username = ?";
            $stmtUpdate = mysqli_prepare($conn, $updateSession);
            mysqli_stmt_bind_param($stmtUpdate, "ss", $sessionId, $username);
            if (!mysqli_stmt_execute($stmtUpdate)) {
                echo json_encode(['success' => false, 'message' => '更新 session 失敗']);
                exit;
            }
            mysqli_stmt_close($stmtUpdate);
            // 設置cookie並將其儲存7天
            setcookie('sessionId', $sessionId, time() + (86400 * 7), "/", "", false, false);

            echo json_encode(["success" => true, "sessionId" => $sessionId]);
        } else {
            http_response_code(401);
        }
    } else {
        // 沒有找到使用者
        http_response_code(404);
    }
    mysqli_stmt_close($stmt);
} else {
    // 使用者名稱或密碼缺失
    http_response_code(400);
}

mysqli_close($conn);
?>
