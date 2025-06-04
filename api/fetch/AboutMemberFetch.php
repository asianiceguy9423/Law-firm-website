<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));


// 得到資料庫檔案，並將檔案交給前端
$sql = "SELECT * FROM tbl_about_member";
$res = mysqli_query($conn, $sql);

// 如果資料庫有檔案，執行以下代碼
if ($res) {
    $abouts = [];
    while($row = mysqli_fetch_assoc($res)){
        $abouts[] = $row;
    }
    echo json_encode(['success' => true, 'abouts' => $abouts]);
    } else {
        echo json_encode(['success' => false,'error' => 'Failed to fetch admins', 'sql_error' => mysqli_error($conn)]);
    }

    // 關閉資料庫連結
    mysqli_close($conn);
?>
