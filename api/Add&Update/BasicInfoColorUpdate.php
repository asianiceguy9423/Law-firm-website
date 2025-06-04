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
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

try {  
    // 解析 JSON
    $BasicColor = isset($_POST['BasicColor']) ? json_decode($_POST['BasicColor'], true) : null;
    $NavbarMainOption = isset($_POST['NavbarMainOption']) ? json_decode($_POST['NavbarMainOption'], true) : null;

    // 確保 陣列且長度為 4
    if (!$BasicColor || !is_array($BasicColor) || count($BasicColor) !== 4) {
        $response = ['success' => false, 'message' => 'JSON 格式錯誤'];
        echo json_encode($response);
        exit;
    }
    if (!$NavbarMainOption || !is_array($NavbarMainOption) || count($NavbarMainOption) !== 4) {
        $response = ['success' => false, 'message' => 'JSON 格式錯誤'];
        echo json_encode($response);
        exit;
    }

    // ✅ 允許的 name
    $allowedNames = ["mainColor", "secondaryColor", "thirdColor", "fourthColor"];
    $allowedNavbarMainOptionNumber = ["one", "two", "three", "four"];

    // ✅ 驗證每個物件
    foreach ($BasicColor as $index => $colorItem) {
        // 確保物件內只有 `name` 和 `color`
        if (!isset($colorItem['name'], $colorItem['color']) || count($colorItem) !== 2) {
            $response = ['success' => false, 'message' => "顏色配置第 {$index} 筆格式錯誤"];
            echo json_encode($response);
            exit;
        }

        // 驗證 `name` 是否在允許列表內
        if (!in_array($colorItem['name'], $allowedNames, true)) {
            $response = ['success' => false, 'message' => "顏色名稱 `{$colorItem['name']}` 不允許"];
            echo json_encode($response);
            exit;
        }

        // 驗證 `color` 是否符合 "R, G, B" 格式 (0-255, 0-255, 0-255)
        if (!preg_match('/^\d{1,3},\s?\d{1,3},\s?\d{1,3}$/', $colorItem['color'])) {
            $response = ['success' => false, 'message' => "顏色值 `{$colorItem['color']}` 格式錯誤"];
            echo json_encode($response);
            exit;
        }

        // ✅ 確保 R, G, B 在 0-255 範圍內
        $rgbValues = explode(",", str_replace(" ", "", $colorItem['color'])); // 移除空格
        foreach ($rgbValues as $rgb) {
            if ((int)$rgb < 0 || (int)$rgb > 255) {
                $response = ['success' => false, 'message' => "顏色值 `{$colorItem['color']}` 不在 0-255 範圍內"];
                echo json_encode($response);
                exit;
            }
        }
    }
    foreach ($NavbarMainOption as $index => $navbarItem) {
        // 確保物件內只有 `number` 和 `name` 和 `display`
        if (!isset($navbarItem['number'], $navbarItem['name'], $navbarItem['display']) || count($navbarItem) !== 3) {
            $response = ['success' => false, 'message' => "navbar配置第 {$index} 筆格式錯誤"];
            echo json_encode($response);
            exit;
        }

        // 驗證 `number` 是否在允許列表內
        if (!in_array($navbarItem['number'], $allowedNavbarMainOptionNumber, true)) {
            $response = ['success' => false, 'message' => "顏色名稱 `{$navbarItem['number']}` 不允許"];
            echo json_encode($response);
            exit;
        }
    }

    // ✅ 確保是 JSON 字串
    $BasicColorJson = json_encode($BasicColor, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    $NavbarMainOptionJson = json_encode($NavbarMainOption, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

    // 查詢資料庫是否已有記錄
    $sql = "SELECT * FROM tbl_basic LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    // **更新資料**
    if ($count > 0) {
        $id = $row['id'];

        $stmt = $conn->prepare("UPDATE tbl_basic SET 
            basic_navbar_main_option = ?,
            basic_color = ? 
            WHERE id = ?
        ");
        $stmt->bind_param("ssi", $NavbarMainOptionJson, $BasicColorJson, $id);

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
        // **新增資料**
        $stmt = $conn->prepare("INSERT INTO tbl_basic (
            basic_navbar_main_option,
            basic_color
        ) VALUES (?, ?)");
        $stmt->bind_param("ss", 
            $NavbarMainOptionJson,
            $BasicColorJson
        );

        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $response = ['success' => true, 'message' => '資料上傳成功', 'data' => ['id' => $stmt->insert_id]];
        } else {
            $response = ['success' => false, 'message' => '資料上傳失敗'];
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(), 'data' => null];
}

mysqli_close($conn);
echo json_encode($response);
