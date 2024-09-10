<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

if(isset($_GET['id']) AND isset($_GET['home_two_image'])){
  $id = $_GET['id'];
  $home_two_image = $_GET['home_two_image'];

  if($home_two_image != ""){
    $path = "../src/assets/home/" . $home_two_image;
    $remove = unlink($path);

    if($remove == false){
      $response = array("error" => "刪除圖片失敗");
      echo json_encode($response);
      exit;
    }
  }

  $sql = "DELETE FROM tbl_home_page_two WHERE id=$id";
  $res = mysqli_query($conn, $sql);
  if($res == true){
    $response = ['success' => true, 'message' => '刪除成功'];
  }else{
    $response = ['success' => false, 'message' => '刪除失敗'];
  }
}else{
  $response = ['success' => false, 'message' => 'ID和圖片不存在'];
}

// 關閉資料庫連結
mysqli_close($conn);

// response回傳給前端
echo json_encode($response);
?>
