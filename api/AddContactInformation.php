<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

$project = isset($_POST['project']) ? $_POST['project'] : null;
$explain = isset($_POST['explain']) ? $_POST['explain'] : null; 
    
$sql = "INSERT INTO tbl_contact_page_information SET
    project            = '$project',
    explain_project    = '$explain'
";
    
$res = mysqli_query($conn, $sql);

// 成功或失敗更新資料庫，都回報message
if ($res) {
    $response = ['success' => true, 'message' => '資訊增加成功'];
} else {
    $response = ['success' => false, 'message' => '資訊增加失敗', 'sql_error' => mysqli_error($conn)];
 }

    // 關閉資料庫連結
    mysqli_close($conn);

    // response回傳給前端
    echo json_encode($response);
?>
