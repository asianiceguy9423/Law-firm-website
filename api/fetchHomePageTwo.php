<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

// 得到資料庫檔案，並將檔案交給前端
$sql = "SELECT * FROM tbl_home_page_two";
$res = mysqli_query($conn, $sql);

if($res){
  $happenings = [];
  while($row = mysqli_fetch_assoc($res)){
    $happening[] = $row;
  }
  echo json_encode(['success' => true, 'happening' => $happening]);
} else {
  echo json_encode(['success' => false,'error' => 'Failed to fetch admins', 'sql_error' => mysqli_error($conn)]);
}

// 關閉資料庫連結
mysqli_close($conn);
?>