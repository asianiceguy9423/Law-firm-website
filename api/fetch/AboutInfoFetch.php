<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];

$sql = "SELECT * FROM tbl_about_page LIMIT 1";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count > 0) {
    $row = mysqli_fetch_assoc($res);

    // Decode JSON strings into arrays
    $row['about_one_title']                 = json_decode($row['about_one_title'], true);

    echo json_encode(['success' => true, 'about' => $row]);
    } else {
    echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
}
?>
