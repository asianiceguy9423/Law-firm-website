<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];


$HomeTeoTitle = isset($_POST['HomeTeoTitle']) ? $_POST['HomeTeoTitle'] : null;
$HomeTeoExp = isset($_POST['HomeTeoExp']) ? $_POST['HomeTeoExp'] : null;
$image = isset($_POST['image']) ? $_POST['image'] : null;
$image_name = '';

// 如果有上傳圖片
if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
    $image_name = $_FILES['image']['name'];
    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $image_name = "HomeTwoPic" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['image']['tmp_name'];
    $des_path = "../src/assets/home/" . $image_name;

    //如果上傳失敗，就回報message，並不要繼續讀下面代碼
    if(!move_uploaded_file($src_path, $des_path)){
        $response = ['success' => false, 'message' => '上傳圖片失敗'];
        echo json_encode($response);
        exit;
    }
}
    
$sql = "INSERT INTO tbl_home_page_two SET
    home_two_title = '$HomeTeoTitle',
    home_two_exp = '$HomeTeoExp',
    home_two_image = '$image_name'
";

$res = mysqli_query($conn, $sql);

if ($res) {
    $response = ['success' => true, 'message' => '資料上傳成功'];
} else {
    $response = ['success' => false, 'message' => '資料上傳失敗', 'sql_error' => mysqli_error($conn)];
}

    // 關閉資料庫連結
    mysqli_close($conn);

    // response回傳給前端
    echo json_encode($response);
?>
