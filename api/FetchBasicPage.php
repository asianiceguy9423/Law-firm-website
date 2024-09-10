<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

$sql = "SELECT * FROM tbl_basic LIMIT 1";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count > 0) {
    $row = mysqli_fetch_assoc($res);

    // Decode JSON strings into arrays
    $row['basic_selected_options'] = json_decode($row['basic_selected_options'], true);
    $row['basic_selected_link_options'] = json_decode($row['basic_selected_link_options'], true);

    echo json_encode(['success' => true, 'basic' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
}
?>
