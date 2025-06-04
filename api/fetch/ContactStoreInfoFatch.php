<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$sql = "SELECT * FROM tbl_contact_page_information";
$res = mysqli_query($conn, $sql);

if ($res) {
    $info = [];
    while($row = mysqli_fetch_assoc($res)){
        $info[] = $row;
    }
    echo json_encode(['success' => true, 'info' => $info]);
    } else {
        echo json_encode(['success' => false,'error' => 'Failed to fetch admins', 'sql_error' => mysqli_error($conn)]);
    }
mysqli_close($conn);
?>
