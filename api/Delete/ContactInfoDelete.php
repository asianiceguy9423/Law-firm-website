<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];
$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['id'])){
  $id = $data['id'];

  $sql = "DELETE FROM tbl_contact_page_information WHERE id=$id";
  $res = mysqli_query($conn, $sql);
  if($res == true){
    $response = ['success' => true, 'message' => '刪除成功'];
  }else{
    $response = ['success' => false, 'message' => '刪除失敗'];
  }
}else{
  $response = ['success' => false, 'message' => 'ID不存在'];
}

// 關閉資料庫連結
mysqli_close($conn);
// response回傳給前端
echo json_encode($response);
?>
