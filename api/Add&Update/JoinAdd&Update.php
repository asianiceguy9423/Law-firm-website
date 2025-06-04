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

if (!$conn) {
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

if ($method === 'GET') {
    $sql = "SELECT * FROM tbl_join_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    // 如果資料庫有檔案，執行以下代碼
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        echo json_encode(['success' => true, 'join' => $row]);
    } else {
        echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
    }
}

// 如果前端要求POST，執行以下代碼
if ($method === 'POST') {
    header('Content-Type: application/json');

    try {
        // 獲取前端數據
        $Title = isset($_POST['Title']) ? htmlspecialchars($_POST['Title'], ENT_QUOTES, 'UTF-8') : null;
        $Content = isset($_POST['Content']) ? htmlspecialchars($_POST['Content'], ENT_QUOTES, 'UTF-8') : null;
        $btnText = isset($_POST['btnText']) ? htmlspecialchars($_POST['btnText'], ENT_QUOTES, 'UTF-8') : null;
        $current_image = isset($_POST['current_image']) ? htmlspecialchars($_POST['current_image'], ENT_QUOTES, 'UTF-8') : null;

        // ✅先查詢資料庫是否有記錄
        $sql = "SELECT * FROM tbl_join_page LIMIT 1";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

        // ✅處理圖片
        $uploadImageResult = handleImageUpload('image', $row ? $row['image_name'] : null, 'join');
        
        // 檢查圖片上傳結果
        if (isset($uploadImageResult['error'])) {
            // error_log("圖片上傳失敗：" . $uploadImageResult['error']); // ✅ 記錄錯誤
            $response = ['success' => false, 'message' => $uploadImageResult['error']];
            echo json_encode($response);
            exit;
        }

        // ✅ 只有當新圖片成功上傳時才更新圖片名稱
        $image_name = $uploadImageResult['newImageName'] !== null 
        ? $uploadImageResult['newImageName'] 
        : ($row ? $row['image_name'] : null);
        // error_log("上傳成功，圖片名稱：" . $image_name); // ✅ 紀錄成功上傳

        // 更新資料
        if ($count > 0) {
            $id = $row['id'];
            $stmt = $conn->prepare("UPDATE tbl_join_page SET
            title = ?,
            content = ?,
            btn_text = ?,
            image_name = ?
            WHERE id = ?
            ");
            $stmt->bind_param("ssssi", 
            $Title, 
            $Content, 
            $btnText, 
            $image_name, 
            $id
            );

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response = ['success' => true, 'message' => '資料更新成功'];
                } else {
                    $response = ['success' => false, 'message' => '沒做任何沒有更改'];
                }
            } else {
                $response = ['success' => false, 'message' => '資料更新失敗'];
            }       
            $stmt->close();
        } else {
            // 新增資料
            $stmt = $conn->prepare("INSERT INTO tbl_join_page(
            title,
            content,
            btn_text,
            image_name)
            VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", 
            $Title, 
            $Content, 
            $btnText, 
            $image_name);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => '資料上傳成功', 'data' => ['id' => $stmt->insert_id]];
            } else {
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
}
?>