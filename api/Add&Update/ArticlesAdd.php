<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');
include('../../api/handleImageUpload.php');

$response = [];

if(!$conn){
    $response = ['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()];
    echo json_encode($response);
    exit;
}

try {
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title'],ENT_QUOTES, 'UTF-8') : null;
    $class = isset($_POST['class']) ? htmlspecialchars($_POST['class'],ENT_QUOTES, 'UTF-8') : null;
    $introduction = isset($_POST['introduction']) ? htmlspecialchars($_POST['introduction'],ENT_QUOTES, 'UTF-8') : null;
    $context = isset($_POST['context']) ? $_POST['context'] : null;
    $comments = [];
    $context = preg_replace_callback('/<!--(.*?)-->/', function($matches) use (&$comments) {
        $comments[] = $matches[0];
        return "<!--COMMENT_PLACEHOLDER-->";
    }, $context);
    $context = strip_tags($context, '<div><h3><h4><li><p><br><span>');
    foreach($comments as $comment) {
        $context = preg_replace('/<!--COMMENT_PLACEHOLDER-->/', $comment, $context, 1);
    }

    // 處理圖片
    $uploadBaanerResult  = handleImageUpload('banner', null, 'article');
    $uploadContextIMGResult  = handleImageUpload('context_image', null, 'article');
    $banner_image_name = '';
    $context_image_name = '';

    // 檢查圖片上傳結果
    if(isset($uploadBaanerResult['error'])) {
        $response = ['success' => false, 'message' => $uploadBaanerResult['error']];
        echo json_encode($response);
        exit;
    }
    if(isset($uploadContextIMGResult['error'])) {
        $response = ['success' => false, 'message' => $uploadContextIMGResult['error']];
        echo json_encode($response);
        exit;
    }

    // ✅ 只有當有新圖片時才設定 `$image_name`
    if ($uploadBaanerResult['newImageName'] !== null) {
        $banner_image_name = $uploadBaanerResult['newImageName'];
    }
    if ($uploadContextIMGResult['newImageName'] !== null) {
        $context_image_name = $uploadContextIMGResult['newImageName'];
    }
    
    // 存入資料庫
    $stmt = $conn ->prepare("INSERT INTO tbl_artiles_page(
    title, 
    introduction, 
    class, 
    context, 
    banner, 
    context_image) 
    VALUES (?,?,?,?,?,?)");

    $stmt->bind_param("ssssss", 
    $title, 
    $introduction, 
    $class, 
    $context, 
    $banner_image_name, 
    $context_image_name);

    $stmt->execute();
    if($stmt->affected_rows > 0){
        $response = ['success' => true, 'message' => '新增文章成功',];
    }else{
        $response = ['success' => false, 'message' => '新增文章失敗'];
        echo json_encode($response);
        exit;
    }
    $stmt->close();
} catch(Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(),];
    echo json_encode($response);
    exit;
}
mysqli_close($conn);
echo json_encode($response);
?>