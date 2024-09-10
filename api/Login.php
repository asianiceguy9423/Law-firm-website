<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$username = $_POST['username'];
$password = $_POST['password'];

if (!empty($username) && !empty($password)) {
    // 防止 SQL 注入攻擊，使用預準備語句（Prepared Statement）
    $sql = "SELECT * FROM tbl_users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);

        // 驗證密碼是否正確
        if ($password ==$user['password']) {
            $sessionId = bin2hex(random_bytes(16));
            // 設置cookie並將其儲存7天
            setcookie('sessionId', $sessionId, time() + (86400 * 7), "/");

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
