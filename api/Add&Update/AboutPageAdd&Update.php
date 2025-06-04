<?php
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

// 檢查是否有接收到圖片
if (isset($_FILES['bannerFileName'])) {
    error_log(print_r($_FILES['bannerFileName'], true)); // ✅ 記錄圖片資訊到 error_log
}
if (isset($_FILES['PersonFileName'])) {
    error_log(print_r($_FILES['PersonFileName'], true)); // ✅ 記錄圖片資訊到 error_log
    }
if (isset($_FILES['ThreeBKFileName'])) {
    error_log(print_r($_FILES['ThreeBKFileName'], true)); // ✅ 記錄圖片資訊到 error_log
    }

try {
    $bannerTitle = $_POST['bannerTitle'] ?? null;
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8') : null;
    $contnet = isset($_POST['contnet']) ? htmlspecialchars($_POST['contnet'], ENT_QUOTES, 'UTF-8') : null;

    // 先查詢資料庫是否有記錄
    $sql = "SELECT * FROM tbl_about_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // 處理圖片
    $uploadBannerResult = handleImageUpload('bannerFileName', $row ? $row['about_one_image'] : null, 'about');
    $uploadPersonResult = handleImageUpload('PersonFileName', $row ? $row['about_two_image'] : null, 'about');
    $uploadBKResult = handleImageUpload('ThreeBKFileName', $row ? $row['about_three_BK'] : null, 'about');

    // 檢查圖片上傳結果
    if (isset($uploadBannerResult['error'])) {
        $response = ['success' => false, 'message' => $uploadBannerResult['error']];
        echo json_encode($response);
        exit;
    }
    if (isset($uploadPersonResult['error'])) {
        $response = ['success' => false, 'message' => $uploadPersonResult['error']];
        echo json_encode($response);
        exit;
    }
    if (isset($uploadBKResult['error'])) {
        $response = ['success' => false, 'message' => $uploadBKResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當新圖片成功上傳時才更新圖片名稱
    $BannerImageName = $uploadBannerResult['newImageName'] !== null ? $uploadBannerResult['newImageName'] : ($row ? $row['about_one_image'] : null);
    $PersonImageName = $uploadPersonResult['newImageName'] !== null ? $uploadPersonResult['newImageName'] : ($row ? $row['about_two_image'] : null);
    $BKImageName = $uploadBKResult['newImageName'] !== null ? $uploadBKResult['newImageName'] : ($row ? $row['about_three_BK'] : null);
    // error_log("上傳成功，圖片名稱：" . $BannerImageName); // ✅ 紀錄成功上傳
    // error_log("上傳成功，圖片名稱：" . $PersonImageName); // ✅ 紀錄成功上傳
    // error_log("上傳成功，圖片名稱：" . $BKImageName); // ✅ 紀錄成功上傳

    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_about_page SET
          about_one_title = ?,
          about_one_image = ?,
          about_two_title = ?,
          about_two_writings = ?,
          about_two_image = ?,
          about_three_BK = ?
          WHERE id =?
        ");
        $stmt->bind_param("ssssssi",
          $bannerTitle,
          $BannerImageName,
          $title,
          $contnet,
          $PersonImageName,
          $BKImageName,
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
        $stmt = $conn->prepare("INSERT INTO tbl_about_page(
          about_one_title,
          about_one_image,
          about_two_title,
          about_two_writings,
          about_two_image,
          about_three_BK)
        VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssss",
            $bannerTitle,
            $BannerImageName,
            $title,
            $contnet,
            $PersonImageName,
            $BKImageName
        );

        $stmt->execute();
        if($stmt->affected_rows > 0) {
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