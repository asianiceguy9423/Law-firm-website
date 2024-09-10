<?php
// 啟用錯誤報告
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php'); 

$response = [];

try {
// 這是智慧財產部分的數據
$PatentTitle = isset($_POST['PatentTitle']) ? $_POST['PatentTitle'] : null;
$currentPatentImage = isset($_POST['currentPatentImage']) ? $_POST['currentPatentImage'] : null;
$PatentImageName = $currentPatentImage;

// 如果有上傳圖片
if (isset($_FILES['PatentImage']) && $_FILES['PatentImage']['name'] != "") {
    $law_patent_Image_name = $_FILES['PatentImage']['name'];
    $ext = pathinfo($law_patent_Image_name, PATHINFO_EXTENSION);
    $law_patent_Image_name = "PatentImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['PatentImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_patent_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentPatentImage && file_exists("../src/assets/law/" . $currentPatentImage)) {
        $remove_path = "../src/assets/law/" . $currentPatentImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $PatentImageName = $law_patent_Image_name; // 更新圖片名
}

// 這是交通部分的數據
$TrafficTitle = isset($_POST['TrafficTitle']) ? $_POST['TrafficTitle'] : null;
$currentTrafficImage = isset($_POST['currentTrafficImage']) ? $_POST['currentTrafficImage'] : null;
$TrafficImageName = $currentTrafficImage;

if (isset($_FILES['TrafficImage']) && $_FILES['TrafficImage']['name'] != "") {
    $law_traffic_Image_name = $_FILES['TrafficImage']['name'];
    $ext = pathinfo($law_traffic_Image_name, PATHINFO_EXTENSION);
    $law_traffic_Image_name = "TrafficImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['TrafficImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_traffic_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentTrafficImage && file_exists("../src/assets/law/" . $currentTrafficImage)) {
        $remove_path = "../src/assets/law/" . $currentTrafficImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $TrafficImageName = $law_traffic_Image_name; 
}

// 這是勞資糾紛部分的數據
$LaborTitle = isset($_POST['LaborTitle']) ? $_POST['LaborTitle'] : null;
$currentLaborImage = isset($_POST['currentLaborImage']) ? $_POST['currentLaborImage'] : null;
$LaborImageName = $currentLaborImage;

if (isset($_FILES['LaborImage']) && $_FILES['LaborImage']['name'] != "") {
    $law_labor_Image_name = $_FILES['LaborImage']['name'];
    $ext = pathinfo($law_labor_Image_name, PATHINFO_EXTENSION);
    $law_labor_Image_name = "LaborImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['LaborImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_labor_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentLaborImage && file_exists("../src/assets/law/" . $currentLaborImage)) {
        $remove_path = "../src/assets/law/" . $currentLaborImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $LaborImageName = $law_labor_Image_name; 
}

// 這是民事部分的數據
$CivilTitle = isset($_POST['CivilTitle']) ? $_POST['CivilTitle'] : null;
$currentCivilImage = isset($_POST['currentCivilImage']) ? $_POST['currentCivilImage'] : null;
$CivilImageName = $currentCivilImage;

if (isset($_FILES['CivilImage']) && $_FILES['CivilImage']['name'] != "") {
    $law_civil_Image_name = $_FILES['CivilImage']['name'];
    $ext = pathinfo($law_civil_Image_name, PATHINFO_EXTENSION);
    $law_civil_Image_name = "CivilImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['CivilImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_civil_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentCivilImage && file_exists("../src/assets/law/" . $currentCivilImage)) {
        $remove_path = "../src/assets/law/" . $currentCivilImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $CivilImageName = $law_civil_Image_name; 
}

// 這是刑事部分的數據
$CriminalTitle = isset($_POST['CriminalTitle']) ? $_POST['CriminalTitle'] : null;
$currentCriminalImage = isset($_POST['currentCriminalImage']) ? $_POST['currentCriminalImage'] : null;
$CriminalImageName = $currentCriminalImage;

if (isset($_FILES['CriminalImage']) && $_FILES['CriminalImage']['name'] != "") {
    $law_criminal_Image_name = $_FILES['CriminalImage']['name'];
    $ext = pathinfo($law_criminal_Image_name, PATHINFO_EXTENSION);
    $law_criminal_Image_name = "CriminalImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['CriminalImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_criminal_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentCriminalImage && file_exists("../src/assets/law/" . $currentCriminalImage)) {
        $remove_path = "../src/assets/law/" . $currentCriminalImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $CriminalImageName = $law_criminal_Image_name; 
}

// 這是未來發布的數據
$FutureTitle = isset($_POST['FutureTitle']) ? $_POST['FutureTitle'] : null;
$FutureText = isset($_POST['FutureText']) ? $_POST['FutureText'] : null;
$currentFutureImage = isset($_POST['currentFutureImage']) ? $_POST['currentFutureImage'] : null;
$displayWritings = isset($_POST['displayWritings']) ? (int)$_POST['displayWritings'] : 0;
$FutureImageName = $currentFutureImage;

if (isset($_FILES['FutureImage']) && $_FILES['FutureImage']['name'] != "") {
    $law_future_Image_name = $_FILES['FutureImage']['name'];
    $ext = pathinfo($law_future_Image_name, PATHINFO_EXTENSION);
    $law_future_Image_name = "FutureImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['FutureImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $law_future_Image_name;

    if (!move_uploaded_file($src_path, $des_path)) {
        throw new Exception('上傳banner圖片失敗');
    }

    if ($currentFutureImage && file_exists("../src/assets/law/" . $currentFutureImage)) {
        $remove_path = "../src/assets/law/" . $currentFutureImage;
        if (!unlink($remove_path)) {
            throw new Exception('刪除原圖片失敗');
        }
    }
    $FutureImageName = $law_future_Image_name; 
}



// 連結資料庫
$sql = "SELECT * FROM tbl_law_banner_page LIMIT 1";
$res = mysqli_query($conn, $sql);
if (!$res) {
    throw new Exception('SQL 錯誤: ' . mysqli_error($conn));
}

$count = mysqli_num_rows($res);

if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    $id = $row['id'];

    $sql2 = "UPDATE tbl_law_banner_page SET
        law_patent_title    = '$PatentTitle',
        law_patent_image    = '$PatentImageName',
        law_traffic_title   = '$TrafficTitle',
        law_traffic_image   = '$TrafficImageName',
        law_labor_title     = '$LaborTitle',
        law_labor_image	    = '$LaborImageName',
        law_civil_title     = '$CivilTitle',
        law_civil_image     = '$CivilImageName',
        law_criminal_title  = '$CriminalTitle',
        law_criminal_image  = '$CriminalImageName',
        law_future_title     = '$FutureTitle',
        law_future_text     = '$FutureText',
        law_future_image  = '$FutureImageName',
        law_future_display  = '$displayWritings'
        WHERE id = '$id'
    ";
    $res2 = mysqli_query($conn, $sql2);
    if (!$res2) {
        throw new Exception('資料更新失敗: ' . mysqli_error($conn));
    }
    $response = ['success' => true, 'message' => '資料更新成功'];
} else {
    $sql3 = "INSERT INTO tbl_law_banner_page SET
        law_patent_title    = '$PatentTitle',
        law_patent_image    = '$PatentImageName',
        law_traffic_title   = '$TrafficTitle',
        law_traffic_image   = '$TrafficImageName',
        law_labor_title     = '$LaborTitle',
        law_labor_image	    = '$LaborImageName',
        law_civil_title     = '$CivilTitle',
        law_civil_image     = '$CivilImageName',
        law_criminal_title  = '$CriminalTitle',
        law_criminal_image  = '$CriminalImageName',
        law_future_title     = '$FutureTitle',
        law_future_text     = '$FutureText',
        law_future_image  = '$FutureImageName',
        law_future_display  = '$displayWritings'
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
