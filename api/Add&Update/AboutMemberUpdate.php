<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');
include('../../api/handleImageUpload.php');

$response = [];
$method = $_SERVER['REQUEST_METHOD'];

if(!$conn){
  $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
  echo json_encode($response);
  exit;
}

//如果前端要求POST，執行以下代碼
if ($method ==='POST') {
  try{
    // 獲取前端數據
    $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
    if ($id === false || $id === null) {
        echo json_encode(['success' => false, 'message' => 'ID 格式錯誤']);
        exit;
    }

    $person_name = isset($_POST['person_name']) ? htmlspecialchars($_POST['person_name'], ENT_QUOTES, 'UTF-8') : null;
    $position = isset($_POST['position']) ? htmlspecialchars($_POST['position'], ENT_QUOTES, 'UTF-8') : null;
    $skill = isset($_POST['skill']) ? htmlspecialchars($_POST['skill'], ENT_QUOTES, 'UTF-8') : null;
    $introduction = isset($_POST['introduction']) ? htmlspecialchars($_POST['introduction'], ENT_QUOTES, 'UTF-8') : null;

    // 先查詢資料庫是否有記錄
    $stmt = $conn->prepare("SELECT * FROM tbl_about_member WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result(); // ✅ 使用 get_result() 取得結果
    $row = $res->fetch_assoc(); // ✅ 直接取出資料

    // 處理圖片
    $uploadImageResult = handleImageUpload('image',  $row['image_name'] ?? null, 'about');

    // 檢查圖片上傳結果
    if (isset($uploadImageResult['error'])) {
      $response = ['success' => false, 'message' => $uploadImageResult['error']];
      echo json_encode($response);
      exit;
    }

    // 只有當新圖片成功上傳時才更新圖片名稱
    $image_name = $row['image_name']; // 預設為原始圖片名稱
    if (!empty($uploadImageResult['newImageName'])) { 
        $image_name = $uploadImageResult['newImageName']; // 只有上傳新圖片才變更
    }

    //更新資料庫
    $stmt = $conn->prepare("UPDATE tbl_about_member SET
      person_name = ?,
      position = ?,
      skill = ?,
      introduction = ?,
      image_name = ?
      WHERE id = ?
    ");
     $stmt->bind_param("sssssi", 
     $person_name, 
     $position, 
     $skill, 
     $introduction, 
     $image_name, 
     $id);

    if($stmt->execute()) {
      if ($stmt->affected_rows > 0) {
          $response = ['success' => true, 'message' => '人員更新成功'];
      } else {
          $response = ['success' => false, 'message' => '沒做任何更改'];
      }
    }else{
        $response = ['success' => false, 'message' => '人員更新失敗'];
    }       
    $stmt->close();
  } catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(), 'data' => null];
    echo json_encode($response);
    exit;
  }  

  mysqli_close($conn); 
  echo json_encode($response);
}
?>