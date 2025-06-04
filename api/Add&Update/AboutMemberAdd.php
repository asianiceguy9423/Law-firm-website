<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');
include('../../api/handleImageUpload.php');

$response = [];
// 確保資料庫連接正常
if(!$conn){
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

header('Content-Type: application/json');

try {
    $person_name = isset($_POST['person_name']) ? htmlspecialchars($_POST['person_name'], ENT_QUOTES, 'UTF-8') : null;
    $position = isset($_POST['position']) ? htmlspecialchars($_POST['position'], ENT_QUOTES, 'UTF-8') : null;
    $skill = isset($_POST['skill']) ? htmlspecialchars($_POST['skill'], ENT_QUOTES, 'UTF-8') : null;
    $introduction = isset($_POST['introduction']) ? htmlspecialchars($_POST['introduction'], ENT_QUOTES, 'UTF-8') : null;
    $image = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK 
    ? $_FILES['image'] : null;
    $image_name = '';

    // 處理圖片
    $uploadImageResult  = handleImageUpload('image', null, 'about');

    // 檢查圖片上傳結果
    if(isset($uploadImageResult['error'])) {
        $response = ['success' => false, 'message' => $uploadImageResult['error']];
        echo json_encode($response);
        exit;
    }

     // ✅ 只有當有新圖片時才設定 `$image_name`
    if ($uploadImageResult['newImageName'] !== null) {
        $image_name = $uploadImageResult['newImageName'];
    }

    // 存入資料庫
    $stmt =  $conn->prepare("INSERT INTO tbl_about_member(
    person_name,
    position,
    skill,
    introduction,
    image_name)
    VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssss",
    $person_name,
    $position,
    $skill,
    $introduction,
    $image_name);

    $stmt->execute();
    if($stmt->affected_rows > 0){
        $response = ['success' => true, 'message' => '人員增加成功',];
    }else{
        $response = ['success' => false, 'message' => '人員增加失敗'];
        echo json_encode($response);
        exit;
    }
    $stmt->close();
} catch(Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(),];
    echo json_encode($response);
    exit;
}
mysqli_close($conn);
echo json_encode($response);
?>