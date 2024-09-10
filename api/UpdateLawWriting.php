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
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        //得到資料庫檔案，並將檔案交給前端
        $sql = "SELECT * FROM tbl_law_writing_page WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            $count = mysqli_num_rows($res);

            //如果資料庫資料，執行以下代碼
            if ($count > 0) {
                $row = mysqli_fetch_assoc($res);
                echo json_encode([$row]);
            } 
            else {
                echo json_encode(['success' => false, 'message' => '讀取資料庫失敗']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => '執行查詢失敗']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '缺少 ID 參數']);
    }
    mysqli_close($conn);
}

//如果前端要求POST，執行以下代碼
if ($method === 'POST') {
    // 獲取前端数据
    $id = $_POST['id'];
    $LawTitle = $_POST['LawTitle'];
    $LawClass = $_POST['LawClass'];
    $LawText = $_POST['LawText'];
    $LawTextPoint = $_POST['LawTextPoint'];
    $current_banner = $_POST['current_banner'];
    $current_big_image = $_POST['current_big_image'];
    $image_banner_name = $current_banner;
    $image_big_name = $current_big_image;

    // 上傳banner圖片
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

        // 删除舊的 banner 图片
        if ($current_banner && file_exists("../src/assets/law/" . $current_banner)) {
            unlink("../src/assets/law/" . $current_banner);
        }
    }

    // 上傳文章圖片
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

        // 删除旧的文章图片
        if ($current_big_image && file_exists("../src/assets/law/" . $current_big_image)) {
            unlink("../src/assets/law/" . $current_big_image);
        }
    }

    // 更新資料庫
    $stmt = $conn->prepare("UPDATE tbl_law_writing_page SET title=?, class=?, text=?, text_point=?,banner_image=?, big_image=? WHERE id=?");
    $stmt->bind_param("ssssssi", $LawTitle, $LawClass, $LawText, $LawTextPoint, $image_banner_name, $image_big_name, $id);
    $res = $stmt->execute();

    // 成功或失敗更新資料庫，都回報message
    if ($res) {
        $response = ['success' => true, 'message' => '文章更新成功'];
    } else {
        $response = ['success' => false, 'message' => '文章更新失敗', 'sql_error' => $stmt->error];
    }

    // 關閉資料庫連結
    $stmt->close();
    $conn->close();

    echo json_encode($response);
}
?>
