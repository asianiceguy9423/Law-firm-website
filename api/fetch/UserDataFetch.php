<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];

$sql = "SELECT * FROM tbl_users LIMIT 1";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

// 如果資料庫有檔案，執行以下代碼
if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    echo json_encode(['success' => true, 'userdata' => $row]);
// 如果資料庫是空的，執行以下代碼
} else {
    echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
}
mysqli_close($conn);
?>