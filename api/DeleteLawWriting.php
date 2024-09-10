<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

if (isset($_GET['id']) && isset($_GET['big_image']) && isset($_GET['banner_image'])) {
  $id = $_GET['id'];
  $big_image = $_GET['big_image'];
  $banner_image = $_GET['banner_image'];

  if ($big_image != "") {
    $path = "../src/assets/law/" . $big_image; 
    if(file_exists($path)){
      $remove = unlink($path);
      if ($remove == false) {
        $response = ['success' => false, 'message' => '刪除文章圖片失敗'];
        echo json_encode($response);
        exit;
      }
    }
  }

  if ($banner_image != "") {
    $path2 = "../src/assets/law/" . $banner_image;
    if(file_exists($path2)){
      $remove2 = unlink($path2);
      if ($remove2 == false) {
        $response = ['success' => false, 'message' => '刪除文章圖片失敗'];
        echo json_encode($response);
        exit;
      }
    }
  }

  $sql = "DELETE FROM tbl_law_writing_page WHERE id=$id";
  $res = mysqli_query($conn, $sql);
  if ($res == true) {
    $response = ['success' => true, 'message' => '刪除成功'];
  } else {
    $response = ['success' => false, 'message' => '刪除失敗'];
  }
} else {
  $response = ['success' => false, 'message' => 'ID和圖片不存在'];
}

// 關閉資料庫連結
mysqli_close($conn);

// response回傳給前端
echo json_encode($response);
?>
