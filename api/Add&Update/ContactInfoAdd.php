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
    $project = isset($_POST['project']) ? htmlspecialchars($_POST['project'], ENT_QUOTES, 'UTF-8') : null;
    $explain = isset($_POST['explain']) ? htmlspecialchars($_POST['explain'], ENT_QUOTES, 'UTF-8') : null; 

    $stmt = $conn->prepare("INSERT INTO tbl_contact_page_information(
    project,
    explain_project)
    VALUE(?, ?)");

    $stmt->bind_param("ss",
    $project,
    $explain);

    $stmt->execute();
    if($stmt->affected_rows > 0){
        $response = ['success' => true, 'message' => '新增資訊成功',];
    }else{
        $response = ['success' => false, 'message' => '新增資訊失敗'];
        echo json_encode($response);
        exit;
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