<?php
// 啟用錯誤報告
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');
include('../../api/handleImageUpload.php');

$response = [];

if(!$conn){
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

// 檢查是否有接收到圖片
if (isset($_FILES['BasicLogo_image'])) {
    error_log(print_r($_FILES['BasicLogo_image'], true)); // ✅ 記錄圖片資訊到 error_log
}

try {
    // 解析 JSON
    $StoreInfo = isset($_POST['StoreInfo']) ? json_decode($_POST['StoreInfo'], true) : null;

    // 確保 陣列且長度為 4
    if (!$StoreInfo || !is_array($StoreInfo) || count($StoreInfo) !== 4) {
        $response = ['success' => false, 'message' => 'JSON StoreInfo格式錯誤'];
        echo json_encode($response);
        exit;
    }

    // ✅ 允許的 name
    $allowedStoreInfoName = ["mail", "time", "phone", "address"];

    // ✅ 驗證每個物件
    foreach ($StoreInfo as $index => $InfoItem) {
        // 確保物件內只有 正確項目
        if (!isset($InfoItem['name'], $InfoItem['title'], $InfoItem['detail'], $InfoItem['display']) || count($InfoItem) !== 4) {
            $response = ['success' => false, 'message' => "InfoItem第 {$index} 筆格式錯誤"];
            echo json_encode($response);
            exit;
        }

        // 驗證 `name` 是否在允許列表內
        if (!in_array($InfoItem['name'], $allowedStoreInfoName, true)) {
            $response = ['success' => false, 'message' => "InfoItem名稱 `{$InfoItem['name']}` 不允許"];
            echo json_encode($response);
            exit;
        }
    }

    // ✅ 確保是 JSON 字串
    $StoreInfoJson = json_encode($StoreInfo, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // 先查詢資料庫是否有記錄
    $sql = "SELECT * FROM tbl_basic LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // 處理圖片
    $uploadLogoResult = handleImageUpload('BasicLogo_image', $row ? $row['basic_logo'] : null, 'basic');

    // 檢查圖片上傳結果
    if (isset($uploadLogoResult['error']) ) {
        $response = ['success' => false, 'message' => $uploadLogoResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當新圖片成功上傳時才更新圖片名稱
    $BasicLogoImageName = $uploadLogoResult['newImageName'] !== null ? $uploadLogoResult['newImageName'] : ($row ? $row['basic_logo'] : null);

    // error_log("上傳成功，圖片名稱：" . $BasicLogoImageName); // ✅ 紀錄成功上傳

    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_basic SET
            basic_logo          = ?,
            basic_store_Info    = ?
            WHERE id            = ?
        ");
        $stmt->bind_param("ssi",
        $BasicLogoImageName,
        $StoreInfoJson,
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
        $stmt = $conn->prepare("INSERT INTO tbl_basic(
            basic_logo,
            basic_store_Info
        ) VALUES (?)");
        $stmt->bind_param("ss",
            $BasicLogoImageName,
            $StoreInfoJson     
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