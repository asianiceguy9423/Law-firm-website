<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

// 得到資料庫檔案，並將檔案交給前端
$sql = "SELECT * FROM tbl_contact_page_information";
$res = mysqli_query($conn, $sql);

// 如果資料庫有檔案，執行以下代碼
if ($res) {
    $information = [];
    while($row = mysqli_fetch_assoc($res)){
        $information[] = $row;
    }
    echo json_encode(['success' => true, 'information' => $information]);
    } else {
        echo json_encode(['success' => false,'error' => 'Failed to fetch admins', 'sql_error' => mysqli_error($conn)]);
    }

    // 關閉資料庫連結
    mysqli_close($conn);
?>
