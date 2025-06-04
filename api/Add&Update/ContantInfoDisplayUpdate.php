<?php
  // 設置 CORS 頭部以允許跨域請求
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  header('Content-Type: application/json');

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
      http_response_code(200);
      exit();
  }

  include('../../api/constants.php');

  $response = [];

  if(!$conn){
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
  }

  try {
    // ✅ 解析 JSON 資料
    $data = json_decode(file_get_contents("php://input"), true);
    
    // ✅ 檢查 JSON 是否正確解析
    if (!$data) {
      echo json_encode(['success' => false, 'message' => '無效的 JSON 格式']);
      exit;
    }

    $id = isset($data['id']) ? filter_var($data['id'], FILTER_VALIDATE_INT) : null;
    $display = isset($data['display']) ? intval($data['display']) : null; // ✅ 確保 `0/1`


    if ($id === null || $display === null) {
      echo json_encode(['success' => false, 'message' => '缺少 ID 或 Display 值']);
      exit;
    }

    // ✅ 更新 `display` 狀態
    $stmt = $conn->prepare("UPDATE tbl_contact_page_information SET display = ? WHERE id = ?");
    $stmt->bind_param("ii", $display, $id);

    if ($stmt->execute()) {
      echo json_encode([
        'success' => true,
        'message' => '顯示狀態已更新',
        'debug' => "UPDATE tbl_contact_page_information SET display = $display WHERE id = $id"
      ]);
    } else {
      echo json_encode([
        'success' => false,
        'message' => '更新失敗',
        'debug' => $stmt->error // ✅ 顯示 SQL 錯誤訊息
      ]);
    } 

    $stmt->close();
  } catch (Exception $e) {
    echo json_encode([
      'success' => false,
      'message' => '錯誤: ' . $e->getMessage()
    ]);
  }

  mysqli_close($conn);
?>