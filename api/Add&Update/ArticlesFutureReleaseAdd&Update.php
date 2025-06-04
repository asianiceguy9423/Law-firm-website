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
    $ArticlesName = isset($_POST['ArticlesName']) ? htmlspecialchars($_POST['ArticlesName'], ENT_QUOTES, 'UTF-8') : null;
    $ArticlesContent = isset($_POST['ArticlesContent']) ? htmlspecialchars($_POST['ArticlesContent'], ENT_QUOTES, 'UTF-8') : null;
    $ArticlesDisplay = isset($_POST['ArticlesDisplay']) ? htmlspecialchars($_POST['ArticlesDisplay'], ENT_QUOTES, 'UTF-8') : null;

    // 先查詢資料庫是否有記錄
    $sql = "SELECT * FROM tbl_articles_future_release LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // 處理圖片
    $uploadArticlesIMGResult = handleImageUpload('ArticlesIMG', $row ? $row['articles_future_release_image'] : null, 'article');

    // 檢查圖片上傳結果
    if (isset($uploadArticlesIMGResult['error']) ) {
        $response = ['success' => false, 'message' => $uploadArticlesIMGResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當新圖片成功上傳時才更新圖片名稱
    $ArticlesImageName = $uploadArticlesIMGResult['newImageName'] !== null ? $uploadArticlesIMGResult['newImageName'] : ($row ? $row['articles_future_release_image'] : null);
    // error_log("上傳成功，圖片名稱：" . $HomeBannerImageName); // ✅ 紀錄成功上傳

    // 更新資料
    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_articles_future_release SET
          articles_future_release_name = ?,
          articles_future_release_content = ?,
          articles_future_release_image = ?,
          articles_future_release_display = ?
          WHERE id = ?
        ");
        
        $stmt->bind_param("ssssi", 
          $ArticlesName, 
          $ArticlesContent, 
          $ArticlesImageName, 
          $ArticlesDisplay, 
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
        $stmt = $conn->prepare("INSERT INTO tbl_articles_future_release(
          articles_future_release_name,
          articles_future_release_content ,
          articles_future_release_image,
          articles_future_release_display
          )
        VALUES (?, ?, ?, ?)");

        $stmt->bind_param("ssss", 
            $ArticlesName, 
            $ArticlesContent, 
            $ArticlesImageName, 
            $ArticlesDisplay
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