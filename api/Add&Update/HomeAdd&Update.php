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
// if (isset($_FILES['HomeThreeImage'])) {
//     error_log(print_r($_FILES['HomeThreeImage'], true)); // ✅ 記錄圖片資訊到 error_log
//     }

try {  
    // 頁面1數據
    $HomeOneTitle = isset($_POST['HomeOneTitle']) ? htmlspecialchars($_POST['HomeOneTitle'], ENT_QUOTES, 'UTF-8') : null;
    $HomeOneBtn = isset($_POST['HomeOneBtn']) ? htmlspecialchars($_POST['HomeOneBtn'], ENT_QUOTES, 'UTF-8') : null;
    $currentHomeOne_image = isset($_POST['currentHomeOne_image']) ? htmlspecialchars($_POST['currentHomeOne_image'], ENT_QUOTES, 'UTF-8') : null;

    // 頁面2 3的數據
    $HomeTwoTitle = isset($_POST['HomeTwoTitle']) ? htmlspecialchars($_POST['HomeTwoTitle'], ENT_QUOTES, 'UTF-8') : null;
    $HomeThreeTitle = isset($_POST['HomeThreeTitle']) ? htmlspecialchars($_POST['HomeThreeTitle'], ENT_QUOTES, 'UTF-8') : null;
    $HomeThreeContent = isset($_POST['HomeThreeContent']) ? htmlspecialchars($_POST['HomeThreeContent'], ENT_QUOTES, 'UTF-8') : null;
    $HomeThreeBtn = isset($_POST['HomeThreeBtn']) ? htmlspecialchars($_POST['HomeThreeBtn'], ENT_QUOTES, 'UTF-8') : null;
    $currentHomeThree_image = isset($_POST['currentHomeThree_image']) ? $_POST['currentHomeThree_image'] : null;

    // 先查詢資料庫是否有記錄
    $sql = "SELECT * FROM tbl_home_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // 處理圖片
    $uploadHomeOneResult = handleImageUpload('HomeBannerimage', $row ? $row['home_one_image'] : null, 'home');
    $uploadHomeThreeResult = handleImageUpload('HomeThreeImage', $row ? $row['home_three_image'] : null, 'home');

    // 檢查圖片上傳結果
    if (isset($uploadHomeOneResult['error']) || isset($uploadHomeThreeResult['error'])) {
        $response = ['success' => false, 'message' => $uploadHomeOneResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當新圖片成功上傳時才更新圖片名稱
    $HomeBannerImageName = $uploadHomeOneResult['newImageName'] !== null ? $uploadHomeOneResult['newImageName'] : ($row ? $row['home_one_image'] : null);
    $HomeThreeImageName = $uploadHomeThreeResult['newImageName'] !== null ? $uploadHomeThreeResult['newImageName'] : ($row ? $row['home_three_image'] : null);
    // error_log("上傳成功，圖片名稱：" . $HomeBannerImageName); // ✅ 紀錄成功上傳
    // error_log("上傳成功，圖片名稱：" . $HomeThreeImageName); // ✅ 紀錄成功上傳

    // 更新資料
    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_home_page SET
          home_one_title = ?,
          home_one_btn = ?,
          home_one_image = ?,
          home_two_title = ?,
          home_three_title = ?,
          home_three_content = ?,
          home_three_btn = ?,
          home_three_image = ?
          WHERE id = ?
        ");
        
        $stmt->bind_param("ssssssssi", 
          $HomeOneTitle, 
          $HomeOneBtn, 
          $HomeBannerImageName, 
          $HomeTwoTitle, 
          $HomeThreeTitle, 
          $HomeThreeContent, 
          $HomeThreeBtn, 
          $HomeThreeImageName, 
          $id
        );

        if($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => '資料更新成功'];
            } else {
                $response = ['success' => false, 'message' => '沒做任何沒有更改'];
            }
        }else{
            $response = ['success' => false, 'message' => '資料更新失敗'];
        }       
        $stmt->close();
    } else {
        // 新增資料
        $stmt = $conn->prepare("INSERT INTO tbl_home_page(
          home_one_title,
          home_one_btn ,
          home_one_image,
          home_two_title,
          home_three_title,
          home_three_content,
          home_three_btn,
          home_three_image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssss", 
            $HomeOneTitle, 
            $HomeOneBtn, 
            $HomeBannerImageName, 
            $HomeTwoTitle, 
            $HomeThreeTitle, 
            $HomeThreeContent, 
            $HomeThreeBtn, 
            $HomeThreeImageName
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