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

include('constants.php'); // Ensure this file includes the database connection as $conn

$response = [];

try {
    // 假設這是頁面1的數據
    $HomeOneTitle = isset($_POST['HomeOneTitle']) ? $_POST['HomeOneTitle'] : null;
    $HomeOneBtn = isset($_POST['HomeOneBtn']) ? $_POST['HomeOneBtn'] : null;
    $currentHomeOne_image = isset($_POST['currentHomeOne_image']) ? $_POST['currentHomeOne_image'] : null;
    $HomeBannerImageName = $currentHomeOne_image;

    // 如果有上傳圖片
    if (isset($_FILES['HomeBannerimage']) && $_FILES['HomeBannerimage']['name'] != "") {
        $homeOneImage_name = $_FILES['HomeBannerimage']['name'];
        $ext = pathinfo($homeOneImage_name, PATHINFO_EXTENSION);
        $homeOneImage_name = "HomeBannerimage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['HomeBannerimage']['tmp_name'];
        $des_path = "../src/assets/home/" . $homeOneImage_name;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳banner圖片失敗');
        }

        if ($currentHomeOne_image && file_exists("../src/assets/home/" . $currentHomeOne_image)) {
            $remove_path = "../src/assets/home/" . $currentHomeOne_image;
            if (!unlink($remove_path)) {
                throw new Exception('刪除原圖片失敗');
            }
        }
        $HomeBannerImageName = $homeOneImage_name; // 更新圖片名
    }

    // 假設這是頁面2和頁面3的數據
    $HomeTwoTitle = isset($_POST['HomeTwoTitle']) ? $_POST['HomeTwoTitle'] : null;
    $HomeThreeTitle = isset($_POST['HomeThreeTitle']) ? $_POST['HomeThreeTitle'] : null;
    $HomeThreeContent = isset($_POST['HomeThreeContent']) ? $_POST['HomeThreeContent'] : null;
    $HomeThreeBtn = isset($_POST['HomeThreeBtn']) ? $_POST['HomeThreeBtn'] : null;
    $currentHomeThree_image = isset($_POST['currentHomeThree_image']) ? $_POST['currentHomeThree_image'] : null;
    $HomeThreeImageName = $currentHomeThree_image;

    if (isset($_FILES['HomeThreeIimage']) && $_FILES['HomeThreeIimage']['name'] != "") {
        $HomeThreeImageName = $_FILES['HomeThreeIimage']['name'];
        $ext = pathinfo($HomeThreeImageName, PATHINFO_EXTENSION);
        $HomeThreeImageName = "HomeThreeIimage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['HomeThreeIimage']['tmp_name'];
        $des_path = "../src/assets/home/" . $HomeThreeImageName;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳第三頁圖片失敗');
        }

        if ($currentHomeThree_image && file_exists("../src/assets/home/" . $currentHomeThree_image)) {
            $remove_path = "../src/assets/home/" . $currentHomeThree_image;
            if (!unlink($remove_path)) {
                throw new Exception('刪除第三頁圖片失敗');
            }
        }
    }

    // 連結資料庫
    $sql = "SELECT * FROM tbl_home_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        throw new Exception('SQL 錯誤: ' . mysqli_error($conn));
    }

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];

        $sql2 = "UPDATE tbl_home_page SET
          home_one_title = '$HomeOneTitle',
          home_one_btn = '$HomeOneBtn',
          home_one_image = '$HomeBannerImageName',
          home_two_title = '$HomeTwoTitle',
          home_three_title = '$HomeThreeTitle',
          home_three_content = '$HomeThreeContent',
          home_three_btn = '$HomeThreeBtn',
          home_three_image = '$HomeThreeImageName'
          WHERE id = '$id'
        ";
        $res2 = mysqli_query($conn, $sql2);
        if (!$res2) {
            throw new Exception('資料更新失敗: ' . mysqli_error($conn));
        }
        $response = ['success' => true, 'message' => '資料更新成功'];
    } else {
        $sql3 = "INSERT INTO tbl_home_page SET
          home_one_title = '$HomeOneTitle',
          home_one_btn = '$HomeOneBtn',
          home_one_image = '$HomeBannerImageName',
          home_two_title = '$HomeTwoTitle',
          home_three_title = '$HomeThreeTitle',
          home_three_content = '$HomeThreeContent',
          home_three_btn = '$HomeThreeBtn',
          home_three_image = '$HomeThreeImageName'
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
