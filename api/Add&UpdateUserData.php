<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $sql = "SELECT * FROM tbl_users LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    // 如果資料庫有檔案，執行以下代碼
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        echo json_encode(['success' => true, 'userdata' => $row]);
    // 如果資料庫是空的，執行以下代碼
    } else {
        echo json_encode(['success' => false, 'message' => '資料庫沒資料']);
    }
}

// 如果前端要求POST，執行以下代碼
if ($method === 'POST') {

    // 獲取前端数据
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // 連結資料庫
    $sql = "SELECT * FROM tbl_users LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    //如果資料庫優檔案，就執行更新
    if ($count > 0){
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];

        $sql3 = "UPDATE tbl_users SET
        username = '$username',
        password = '$password'
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
        $sql2 = "INSERT INTO tbl_users SET
        username = '$username',
        password = '$password'
        ";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2) {
            $response = ['success' => true, 'message' => '資料上傳成功'];
        } else {
            $response = ['success' => false, 'message' => '資料上傳失敗', 'sql_error' => mysqli_error($conn)];
        }
    }

    mysqli_close($conn);

    echo json_encode($response);
}
?>
