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
    // 這是頁面1的數據
    $AboutOneTitle = isset($_POST['AboutOneTitle']) ? $_POST['AboutOneTitle'] : null;
    $AboutOneSubTitle = isset($_POST['AboutOneSubTitle']) ? $_POST['AboutOneSubTitle'] : null;
    $currentImageOne = isset($_POST['currentImageOne']) ? $_POST['currentImageOne'] : null;
    $AboutOneBannerImageName = $currentImageOne;

    // 如果有上傳圖片
    if (isset($_FILES['AboutOneBannerImage']) && $_FILES['AboutOneBannerImage']['name'] != "") {
        $aboutOneImage_name = $_FILES['AboutOneBannerImage']['name'];
        $ext = pathinfo($aboutOneImage_name, PATHINFO_EXTENSION);
        $aboutOneImage_name = "AboutOneBannerImage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['AboutOneBannerImage']['tmp_name'];
        $des_path = "../src/assets/about/" . $aboutOneImage_name;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳banner圖片失敗');
        }

        if ($currentImageOne && file_exists("../src/assets/home/" . $currentImageOne)) {
            $remove_path = "../src/assets/about/" . $currentImageOne;
            if (!unlink($remove_path)) {
                throw new Exception('刪除原圖片失敗');
            }
        }
        $AboutOneBannerImageName = $aboutOneImage_name;
    }

    // 這是頁面2的數據
    $AboutTwoTitle = isset($_POST['AboutTwoTitle']) ? $_POST['AboutTwoTitle'] : null;
    $AboutTwoWritings = isset($_POST['AboutTwoWritings']) ? $_POST['AboutTwoWritings'] : null;
    $currentImageTwo = isset($_POST['currentImageTwo']) ? $_POST['currentImageTwo'] : null;
    $AboutTwoImageName = $currentImageTwo;

    if (isset($_FILES['AboutTwoPersonrImage']) && $_FILES['AboutTwoPersonrImage']['name'] != "") {
        $AboutTwoImageName = $_FILES['AboutTwoPersonrImage']['name'];
        $ext = pathinfo($AboutTwoImageName, PATHINFO_EXTENSION);
        $AboutTwoImageName = "AboutTwoPersonrImage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['AboutTwoPersonrImage']['tmp_name'];
        $des_path = "../src/assets/about/" . $AboutTwoImageName;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳第二頁圖片失敗');
        }

        if ($currentImageTwo && file_exists("../src/assets/home/" . $currentImageTwo)) {
            $remove_path = "../src/assets/about/" . $currentImageTwo;
            if (!unlink($remove_path)) {
                throw new Exception('刪除第二頁圖片失敗');
            }
        }
    }

    // 這是頁面3的數據
    $currentImageThreeBK = isset($_POST['currentImageThreeBK']) ? $_POST['currentImageThreeBK'] : null;
    $AboutThreeBKImageName = $currentImageThreeBK;

    if (isset($_FILES['AboutThreeBKImage']) && $_FILES['AboutThreeBKImage']['name'] != "") {
        $AboutThreeBKImageName = $_FILES['AboutThreeBKImage']['name'];
        $ext = pathinfo($AboutThreeBKImageName, PATHINFO_EXTENSION);
        $AboutThreeBKImageName = "AboutThreeBKImage" . rand(000, 999) . '.' . $ext;
        $src_path = $_FILES['AboutThreeBKImage']['tmp_name'];
        $des_path = "../src/assets/about/" . $AboutThreeBKImageName;

        if (!move_uploaded_file($src_path, $des_path)) {
            throw new Exception('上傳第二頁圖片失敗');
        }

        if ($currentImageThreeBK && file_exists("../src/assets/home/" . $currentImageThreeBK)) {
            $remove_path = "../src/assets/about/" . $currentImageThreeBK;
            if (!unlink($remove_path)) {
                throw new Exception('刪除第二頁圖片失敗');
            }
        }
    }

    // 連結資料庫
    $sql = "SELECT * FROM tbl_about_page LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        throw new Exception('SQL 錯誤: ' . mysqli_error($conn));
    }

    $count = mysqli_num_rows($res);

    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];

        $sql2 = "UPDATE tbl_about_page SET
          about_one_title = '$AboutOneTitle',
          about_one_subtitle = '$AboutOneSubTitle',
          about_one_image = '$AboutOneBannerImageName',
          about_two_title = '$AboutTwoTitle',
          about_two_writings = '$AboutTwoWritings',
          about_two_image = '$AboutTwoImageName',
          about_three_BK  = '$AboutThreeBKImageName'
          WHERE id = '$id'
        ";
        $res2 = mysqli_query($conn, $sql2);
        if (!$res2) {
            throw new Exception('資料更新失敗: ' . mysqli_error($conn));
        }
        $response = ['success' => true, 'message' => '資料更新成功'];
    } else {
        $sql3 = "INSERT INTO tbl_about_page SET
          about_one_title = '$AboutOneTitle',
          about_one_subtitle = '$AboutOneSubTitle',
          about_one_image = '$AboutOneBannerImageName',
          about_two_title = '$AboutTwoTitle',
          about_two_writings = '$AboutTwoWritings',
          about_two_image = '$AboutTwoImageName',
          about_three_BK  = '$AboutThreeBKImageName'
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
