<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

$LawTitle = isset($_POST['LawTitle']) ? $_POST['LawTitle'] : null;
$LawClass = isset($_POST['LawClass']) ? $_POST['LawClass'] : null;
$LawText = isset($_POST['LawText']) ? $_POST['LawText'] : null;
$LawTextPoint = isset($_POST['LawTextPoint']) ? $_POST['LawTextPoint'] : null;

$image_banner_name = "";
$image_big_name = "";

// 上傳bannerinage
if (isset($_FILES['LawBannerImage']) && $_FILES['LawBannerImage']['name'] != "") {
    $image_banner_name = $_FILES['LawBannerImage']['name'];
    $ext = pathinfo($image_banner_name, PATHINFO_EXTENSION);
    $image_banner_name = "LawBannerImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['LawBannerImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $image_banner_name;

    // 如果上傳失敗，就回報message，並不要繼續讀下面代碼
    if (!move_uploaded_file($src_path, $des_path)) {
        $response = ['success' => false, 'message' => '上傳banner圖片失敗'];
        echo json_encode($response);
        exit;
    }
}

// 上傳biginage
if (isset($_FILES['LawBigImage']) && $_FILES['LawBigImage']['name'] != "") {
    $image_big_name = $_FILES['LawBigImage']['name'];
    $ext = pathinfo($image_big_name, PATHINFO_EXTENSION);
    $image_big_name = "LawBigImage" . rand(000, 999) . '.' . $ext;
    $src_path = $_FILES['LawBigImage']['tmp_name'];
    $des_path = "../src/assets/law/" . $image_big_name;

    // 如果上傳失敗，就回報message，並不要繼續讀下面代碼
    if (!move_uploaded_file($src_path, $des_path)) {
        $response = ['success' => false, 'message' => '上傳文章圖片失敗'];
        echo json_encode($response);
        exit;
    }
} 

$stmt = $conn ->prepare("INSERT INTO tbl_law_writing_page 
    (title, class, text, text_point, banner_image, big_image) 
    VALUES (?,?,?,?,?,?)"
);
$stmt->bind_param("ssssss", $LawTitle, $LawClass, $LawText, $LawTextPoint, $image_banner_name, $image_big_name);
$res = $stmt -> execute();

// 成功或失敗更新資料庫，都回報message
if ($res) {
    $response = ['success' => true, 'message' => '個人介紹增加成功'];
} else {
    $response = ['success' => false, 'message' => '個人介紹增加失敗', 'sql_error' => $stmt->error];
}

// 關閉資料庫連結
$stmt->close();
$conn->close();

// response回傳給前端
echo json_encode($response);
?>
