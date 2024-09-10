<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

if(isset($_GET['id']) AND isset($_GET['image_name'])){
  $id = $_GET['id'];
  $image_name = $_GET['image_name'];

  if($image_name != ""){
    $path = "../src/assets/about/" . $image_name;
    if(file_exists($path)){
      $remove = unlink($path);
      if($remove == false){
        $response = array("error" => "刪除圖片失敗");
        echo json_encode($response);
        exit;
      }
    }
  }

  $sql = "DELETE FROM tbl_about_page_three WHERE id=$id";
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
