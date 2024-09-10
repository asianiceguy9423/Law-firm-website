<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];
$method = $_SERVER['REQUEST_METHOD'];

// 如果前端要求GET，執行以下代碼
if ($method === 'GET') {
    // 得到資料庫檔案，並將檔案交給前端
    $sql = "SELECT * FROM tbl_join_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    // 如果資料庫有檔案，執行以下代碼
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        echo json_encode(['success' => true, 'join' => $row]);
    // 如果資料庫是空的，執行以下代碼
    } else {
        echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
    }
}

// 如果前端要求POST，執行以下代碼
if ($method === 'POST') {

    // 獲取前端数据
    $Title = isset($_POST['Title']) ? $_POST['Title'] : null;
    $Content = isset($_POST['Content']) ? $_POST['Content'] : null;
    $btnText = isset($_POST['btnText']) ? $_POST['btnText'] : null;
    $current_image = isset($_POST['current_image']) ? $_POST['current_image'] : null;
    $image_name = $current_image;

    // 如果有上傳圖片
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
        $image_name = $_FILES['image']['name'];
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "JoinPagePic" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['image']['tmp_name'];
        $des_path = "../src/assets/join/" . $image_name;

        //如果上傳失敗，就回報message，並不要繼續讀下面代碼
        if(!move_uploaded_file($src_path, $des_path)){
            $response = ['success' => false, 'message' => '上傳圖片失敗'];
            echo json_encode($response);
            exit;
        }
        if($current_image !=""){
            $remove_path = "../src/assets/join/" . $current_image;
            if(!unlink($remove_path)){
            echo json_encode(['success' => false, 'message' =>'刪除原圖片失敗']);
            exit;
            }
        }
    }

    // 連結資料庫
    $sql = "SELECT * FROM tbl_join_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    //如果資料庫優檔案，就執行更新
    if ($count > 0){
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];

        $sql3 = "UPDATE tbl_join_page SET
        title = '$Title',
        content = '$Content',
        btn_text = '$btnText',
        image_name      = '$image_name'
        WHERE id ='$id'
        ";

        $res3 = mysqli_query($conn, $sql3);

        if ($res3) {
            $response = ['success' => true, 'message' => '資料更新成功'];
        } else {
            $response = ['success' => false, 'message' => '資料更新失敗', 'sql_error' => mysqli_error($conn)];
        }

    //不然就執行創建
    }else{
        $sql2 = "INSERT INTO tbl_join_page SET
        title = '$Title',
        content = '$Content',
        btn_text = '$btnText',
        image_name      = '$image_name'
        ";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2) {
            $response = ['success' => true, 'message' => '資料上傳成功'];
        } else {
            $response = ['success' => false, 'message' => '資料上傳失敗', 'sql_error' => mysqli_error($conn)];
        }
    }

    // 關閉資料庫連結
    mysqli_close($conn);

    // response回傳給前端
    echo json_encode($response);
}
?>
