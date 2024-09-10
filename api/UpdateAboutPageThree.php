<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];
$method = $_SERVER['REQUEST_METHOD'];


//如果前端要求GET，執行以下代碼
if($method === 'GET'){
  if(isset($_GET['id'])){
    $id = $_GET['id'];

    //得到資料庫檔案，並將檔案交給前端
    $sql = "SELECT * FROM tbl_about_page_three WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    if($res){
      $count = mysqli_num_rows($res);

      //如果資料庫資料，執行以下代碼
      if($count > 0){
        $row = mysqli_fetch_assoc($res);
        echo json_encode([$row]);
      //如果資料庫是空的，執行以下代碼
      }else{
        echo json_encode(['success' => false, 'message' => '讀取資料庫失敗']);
      }
    }else{
      echo json_encode(['success' => false, 'message' => 'Failed to execute query']);
    }
  }else {
    echo json_encode(['success' => false, 'message' => '缺少 ID 參數']);
  } 
}


//如果前端要求POST，執行以下代碼
if ($method ==='POST') {

   // 獲取前端数据
   $id = $_POST['id'];
   $personName = $_POST['personName'];
   $position = $_POST['position'];
   $skill = $_POST['skill'];
   $exp = $_POST['exp'];
   $current_image = $_POST['current_image'];


    //如果有要上傳的圖片
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] !=""){
      $image_name = $_FILES['image']['name'];
      $ext = pathinfo($image_name, PATHINFO_EXTENSION);
      $image_name = "AboutPageThreePersonPic" .rand(000, 999). '.' . $ext;
      $src_path = $_FILES['image']['tmp_name'];
      $des_path = "../src/assets/about/". $image_name;

      //如果上傳失敗，就回報message，並不要繼續讀下面代碼
      if(!move_uploaded_file($src_path, $des_path)){
        $response = ['success' => false, 'message' => '上傳圖片失敗'];
        echo json_encode($response);
        exit;
      }
      if($current_image !=""){
        $remove_path = "../src/assets/about/" . $current_image;
      if(!unlink($remove_path)){
        echo json_encode(['success' => false, 'message' =>'刪除原圖片失敗']);
        exit;
      }
      }
    } else{
      $image_name = $current_image;
    }

  //連接到資料庫並更新image_name
  $sql ="UPDATE tbl_about_page_three SET
  personName = '$personName',
  position = '$position',
  skill = '$skill',
  exp = '$exp',
  image_name = '$image_name'
  WHERE id ='$id'
  ";
  $res = mysqli_query($conn, $sql);

  //成功或失敗更新資料庫，都回報message
  if($res){
  $response = ['success' => true, 'message' => '更新資料成功'];
  }else{
  $response = ['success' =>false, 'message' => '更新資料失敗', 'sql_error' => mysqli_error($conn)];
  }

  
  //關閉資料庫連結
  mysqli_close($conn); 

  //response回傳給前端
  echo json_encode($response);
}




?>