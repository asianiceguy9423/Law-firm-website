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
      $sql = "SELECT * FROM tbl_contact_page_information WHERE id=$id";
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
    mysqli_close($conn);
  }

//如果前端要求POST，執行以下代碼
if($method ==='POST'){
    $id = $_POST['id'];
    $project = $_POST['project'];
    $explain = $_POST['explain'];

    $sql = "UPDATE tbl_contact_page_information SET
        project            = '$project',
        explain_project    = '$explain'
     WHERE id= '$id'
     ";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $response = ['success' => true, 'message' => '資料更新成功'];
    } else {
         $response = ['success' => false, 'message' => '資料更新失敗', 'sql_error' =>mysqli_error($conn)];
    }

    // 關閉資料庫連結
    mysqli_close($conn);

    // response回傳給前端
    echo json_encode($response);
}
?>
