<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

$response = [];

if (!$conn) {
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

try{
    //從前端取得代碼
    $id = isset($_POST['id']) ? filter_var($_POST['id'], FILTER_VALIDATE_INT) : null;
    if ($id === false || $id === null) {
        echo json_encode(['success' => false, 'message' => 'ID 格式錯誤']);
        exit;
    }
    $project = isset($_POST['project']) ? htmlspecialchars($_POST['project'], ENT_QUOTES, 'UTF-8') : null;
    $explain = isset($_POST['explain']) ? htmlspecialchars($_POST['explain'], ENT_QUOTES, 'UTF-8') : null; 

    //更新資料庫
    $stmt = $conn->prepare("UPDATE tbl_contact_page_information SET
        project = ?,
        explain_project = ?
        WHERE id = ?
    ");

    $stmt->bind_param("ssi",
        $project,
        $explain,
        $id
    );

    if($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = ['success' => true, 'message' => '資訊更新成功'];
        } else {
            $response = ['success' => false, 'message' => '沒做任何沒有更改'];
        }
      }else{
          $response = ['success' => false, 'message' => '資訊更新失敗'];
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