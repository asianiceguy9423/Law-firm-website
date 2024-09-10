<?php
// 啟用錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php'); 

$response = [];

try {
    // 這是LOGO頁面的數據
    $currentLOGO = $_POST['currentLOGO'] ?? null;
    $LOGOImageName = $currentLOGO;

    // 如果有上傳圖片
    if (isset($_FILES['LOGOImage']) && $_FILES['LOGOImage']['name'] != "") {
        $basiclogoImage_name = $_FILES['LOGOImage']['name'];
        $ext = pathinfo($basiclogoImage_name, PATHINFO_EXTENSION);
        $basiclogoImage_name = "LOGOImage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['LOGOImage']['tmp_name'];
        $des_path = "../src/assets/basic/" . $basiclogoImage_name;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳banner圖片失敗');
        }

        if ($currentLOGO && file_exists("../src/assets/basic/" . $currentLOGO)) {
            $remove_path = "../src/assets/basic/" . $currentLOGO;
            if (!unlink($remove_path)) {
                throw new Exception('刪除原圖片失敗');
            }
        }
        $LOGOImageName = $basiclogoImage_name;
    }

    // 這是頁面2 3的數據
    $yourPhonenumber = $_POST['yourPhonenumber'] ?? null;
    $yourMail = $_POST['yourMail'] ?? null;
    $yourAddress = $_POST['yourAddress'] ?? null;
    $yourTime = $_POST['yourTime'] ?? null;
    $selectedOptions = $_POST['selectedOptions'] ?? '[]';
    $yourFacebook = $_POST['yourFacebook'] ?? null;
    $yourInstagram = $_POST['yourInstagram'] ?? null;
    $yourLine = $_POST['yourLine'] ?? null;
    $yourYoutube = $_POST['yourYoutube'] ?? null;
    $selectedLinkOptions = $_POST['selectedLinkOptions'] ?? '[]';

    // 連結資料庫
    $sql = "SELECT * FROM tbl_basic LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        throw new Exception('SQL 錯誤: ' . mysqli_error($conn));
    }

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];

        $sql2 = "UPDATE tbl_basic SET
          basic_logo = '$LOGOImageName',
          basic_phonenumber = '$yourPhonenumber',
          basic_mail = '$yourMail',
          basic_address = '$yourAddress',
          basic_time  = '$yourTime',
          basic_selected_options = '$selectedOptions',
          basic_facebook = '$yourFacebook',
          basic_instagram = '$yourInstagram',
          basic_line  = '$yourLine',
          basic_youtube = '$yourYoutube',
          basic_selected_link_options  = '$selectedLinkOptions'
          WHERE id = '$id'
        ";
        $res2 = mysqli_query($conn, $sql2);
        if (!$res2) {
            throw new Exception('資料更新失敗: ' . mysqli_error($conn));
        }
        $response = ['success' => true, 'message' => '資料更新成功'];
    } else {
        $sql3 = "INSERT INTO tbl_basic SET
          basic_logo = '$LOGOImageName',
          basic_phonenumber = '$yourPhonenumber',
          basic_mail = '$yourMail',
          basic_address = '$yourAddress',
          basic_time  = '$yourTime',
          basic_selected_options = '$selectedOptions',
          basic_facebook = '$yourFacebook',
          basic_instagram = '$yourInstagram',
          basic_line  = '$yourLine',
          basic_youtube = '$yourYoutube',
          basic_selected_link_options  = '$selectedLinkOptions'
        ";
        $res3 = mysqli_query($conn, $sql3);
        if (!$res3) {
            throw new Exception('資料上傳失敗: ' . mysqli_error($conn));
        }
        $response = ['success' => true, 'message' => '資料上傳成功'];
    }

} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

mysqli_close($conn);
echo json_encode($response);
