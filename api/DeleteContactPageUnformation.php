<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

if(isset($_GET['id'])){
  $id = $_GET['id'];

  $sql = "DELETE FROM tbl_contact_page_information WHERE id=$id";
  $res = mysqli_query($conn, $sql);
  if($res == true){
    // $response = array("success" => "刪除成功");
    $response = ['success' => true, 'message' => '刪除成功'];
  }else{
    // $response = array("error" => "刪除失敗");
    $response = ['success' => false, 'message' => '刪除失敗'];
  }
}else{
  // $response = array("error" => "ID不存在");
  $response = ['success' => false, 'message' => 'ID不存在'];
}

// 關閉資料庫連結
mysqli_close($conn);

// response回傳給前端
echo json_encode($response);
?>
