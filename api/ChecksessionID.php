<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

// ✅ 從前端 `POST` 取得 `sessionId`
$sessionId = isset($_POST['sessionId']) ? $_POST['sessionId'] : null;

if (!$sessionId) {
    echo json_encode(['success' => false, 'message' => '未提供 sessionId']);
    exit;
}

// ✅ 確保 SQL 內的 `SESSIONID` 欄位名稱正確 (與資料庫一致)
$sql = "SELECT * FROM tbl_users WHERE session_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $sessionId);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) > 0) {
    echo json_encode(['success' => true, 'message' => 'Session 驗證成功']);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Session 過期或無效']);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
