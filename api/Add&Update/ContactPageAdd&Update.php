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

// 檢查是否有接收到圖片
// if (isset($_FILES['HomeBannerimage'])) {
//     error_log(print_r($_FILES['HomeBannerimage'], true)); // ✅ 記錄圖片資訊到 error_log
// }

try {  
    // 頁面1數據
    $BannerTitle = isset($_POST['BannerTitle']) ? htmlspecialchars($_POST['BannerTitle'], ENT_QUOTES, 'UTF-8') : null;
    $Title = isset($_POST['Title']) ? htmlspecialchars($_POST['Title'], ENT_QUOTES, 'UTF-8') : null;

    // 先查詢資料庫是否有記錄
    $sql = "SELECT * FROM tbl_contact_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // 處理圖片
    $uploadBannerResult = handleImageUpload('BannerING', $row ? $row['image_name'] : null, 'contact');

    // 檢查圖片上傳結果
    if (isset($uploadBannerResult['error'])) {
        $response = ['success' => false, 'message' => $uploadBannerResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當新圖片成功上傳時才更新圖片名稱
    $BannerImageName = $uploadBannerResult['newImageName'] !== null ? $uploadBannerResult['newImageName'] : ($row ? $row['image_name'] : null);
    // error_log("上傳成功，圖片名稱：" . $BannerImageName); // ✅ 紀錄成功上傳

    // 更新資料
    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_contact_page SET
          banner_title = ?,
          title = ?,
          image_name = ?
          WHERE id = ?
        ");
        
        $stmt->bind_param("sssi", 
          $BannerTitle, 
          $Title, 
          $BannerImageName, 
          $id
        );

        if($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => '資料更新成功'];
            } else {
                $response = ['success' => false, 'message' => '沒做任何更改'];
            }
        }else{
            $response = ['success' => false, 'message' => '資料更新失敗'];
        }       
        $stmt->close();
    } else {
        // 新增資料
        $stmt = $conn->prepare("INSERT INTO tbl_contact_page(
          banner_title,
          title ,
          image_name
          )
        VALUES (?, ?, ?)");

        $stmt->bind_param("sss", 
            $BannerTitle, 
            $Title, 
            $BannerImageName
        );

        $stmt->execute();
        if($stmt->affected_rows > 0){
            $response = ['success' => true, 'message' => '資料上傳成功', 'data' => ['id' => $stmt->insert_id]];
        }else{
            $response = ['success' => false, 'message' => '資料上傳失敗'];
            echo json_encode($response);
            exit;
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(), 'data' => null];
    echo json_encode($response);
    exit;
}
mysqli_close($conn);
echo json_encode($response);
?>