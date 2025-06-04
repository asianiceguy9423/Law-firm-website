<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];

$sql = "SELECT * FROM tbl_basic LIMIT 1";
$res = mysqli_query($conn, $sql);
$count = mysqli_num_rows($res);

if ($count > 0) {
    $row = mysqli_fetch_assoc($res);

    // Decode JSON strings into arrays
    $row['basic_color']                 = json_decode($row['basic_color'], true);
    $row['basic_link_Info']             = json_decode($row['basic_link_Info'], true);
    $row['basic_navbar_main_option']    = json_decode($row['basic_navbar_main_option'], true);
    $row['basic_navbarOptions']         = json_decode($row['basic_navbarOptions'], true);
    $row['basic_store_Info']            = json_decode($row['basic_store_Info'], true);

    echo json_encode(['success' => true, 'basic' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
}
?>
