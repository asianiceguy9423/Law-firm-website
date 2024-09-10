<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

    $personName = isset($_POST['personName']) ? $_POST['personName'] : null;
    $position = isset($_POST['position']) ? $_POST['position'] : null;
    $skill = isset($_POST['skill']) ? $_POST['skill'] : null;
    $exp = isset($_POST['exp']) ? $_POST['exp'] : null;
    $image_name = '';


    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "AboutPageThreePic" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['image']['tmp_name'];
        $des_path = "../src/assets/about/" . $image_name;

        if (!move_uploaded_file($src_path, $des_path)) {
            $response = ['success' => false, 'message' => '上傳圖片失敗'];
            echo json_encode($response);
            exit;
        }
    }    
    
    $sql = "INSERT INTO tbl_about_page_three SET
        personName      = '$personName',
        position        = '$position',
        skill           = '$skill',
        exp             = '$exp',
        image_name      = '$image_name'
    ";
    
    $res = mysqli_query($conn, $sql);

    if ($res) {
        $response = ['success' => true, 'message' => '個人介紹增加成功'];
    } else {
        $response = ['success' => false, 'message' => '個人介紹增加失敗', 'sql_error' => mysqli_error($conn)];
    }

    mysqli_close($conn);

    echo json_encode($response);
?>
