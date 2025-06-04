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

if (!isset($_POST['oldPassword'])) {
    echo json_encode(['success' => false, 'message' => '密碼未提供']);
    exit;
}

try {
    $oldPassword = isset($_POST['oldPassword']) ? $_POST['oldPassword'] : null;

    $sql = "SELECT * FROM tbl_users LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (!$res) {
        $response = ['success' => false, 'message' => 'SQL 錯誤:' . mysqli_error($conn)];
        echo json_encode($response);
        exit;
    }

    if (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);
        $storedHashedPassword = $user['password'];

        // 驗證密碼是否正確
        if (password_verify($oldPassword, $storedHashedPassword)) {
            echo json_encode(["success" => true, 'message' => '密碼正確']);
        } else {
            echo json_encode(['success' => false, 'message' => '密碼錯誤']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '未找到用戶']);
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(), 'data' => null];
    echo json_encode($response);
    exit;
}

mysqli_close($conn);
?>