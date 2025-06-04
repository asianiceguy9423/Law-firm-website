<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];

// 確保資料庫連接正常
if (!$conn) {
    echo json_encode(['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()]);
    exit;
}

try {  
    // ✅ 解析 JSON (接收純陣列)
    $StoreLink = json_decode(file_get_contents('php://input'), true);

    // ✅ 確保 JSON 是陣列且長度為 4
    if (!$StoreLink || !is_array($StoreLink) || count($StoreLink) !== 4) {
        echo json_encode(['success' => false, 'message' => 'JSON 格式錯誤']);
        exit;
    }

    // ✅ 允許的 name 值
    $allowedStoreLinkName = ["facebook", "line", "instagram", "youtube"];

    // ✅ 驗證每個物件
    foreach ($StoreLink as $index => $StoreLinkItem) {
        if (!isset($StoreLinkItem['name'], $StoreLinkItem['title'], $StoreLinkItem['link'], $StoreLinkItem['display'])) {
            echo json_encode(['success' => false, 'message' => "StoreLink配置第 {$index} 筆格式錯誤"]);
            exit;
        }        

        // ✅ 驗證 `name` 是否在允許列表內
        if (!in_array($StoreLinkItem['name'], $allowedStoreLinkName, true)) {
            echo json_encode(['success' => false, 'message' => "name `{$StoreLinkItem['name']}` 不允許"]);
            exit;
        }

        // ✅ 確保 display 為 `true` 或 `false`
        if (!is_bool($StoreLinkItem['display'])) {
            echo json_encode(['success' => false, 'message' => "display 必須是布林值 (true/false)"]);
            exit;
        }
    }

    // ✅ 確保是 JSON 字串
    $StoreLinkJson = json_encode($StoreLink, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // ✅ 查詢資料庫是否已有記錄
    $sql = "SELECT * FROM tbl_basic LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // **更新資料**
    if ($count > 0) {
        $id = $row['id'];

        $stmt = $conn->prepare("UPDATE tbl_basic SET 
            basic_link_Info = ?
            WHERE id = ?
        ");
        $stmt->bind_param("si", $StoreLinkJson, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => '資料更新成功']);
        } else {
            echo json_encode(['success' => false, 'message' => '資料更新失敗']);
        }
        $stmt->close();
    } else {
        // **新增資料**
        $stmt = $conn->prepare("INSERT INTO tbl_basic (basic_link_Info) VALUES (?)");
        $stmt->bind_param("s", $StoreLinkJson);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => '資料上傳成功', 'data' => ['id' => $stmt->insert_id]]);
        } else {
            echo json_encode(['success' => false, 'message' => '資料上傳失敗']);
        }
        $stmt->close();
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage(), 'data' => null]);
}

mysqli_close($conn);
?>
