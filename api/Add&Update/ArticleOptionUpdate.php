<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');
include('../../api/handleImageUpload.php');

$response = [];

if (!$conn) {
  echo json_encode(['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()]);
  exit;
}

try {
  // ✅ 接收並解析資料
  $number = $_POST['number'] ?? '';
  $updateOptions = isset($_POST['updateOptions']) ? json_decode($_POST['updateOptions'], true) : null;
  $oldBanner = isset($_POST['oldBanner']) ? htmlspecialchars($_POST['oldBanner'], ENT_QUOTES, 'UTF-8') : null;
  $oldIMG = isset($_POST['oldIMG']) ? htmlspecialchars($_POST['oldIMG'], ENT_QUOTES, 'UTF-8') : null;

  if (!$updateOptions || !is_array($updateOptions) || count($updateOptions) !== 5) {
    echo json_encode(['success' => false, 'message' => 'JSON 格式錯誤']);
    exit;
  }

  // ✅ 處理圖片上傳（如果有）
  $uploadBannerResult = handleImageUpload('bannerIMG', $oldBanner, 'article');
  $uploadIMGResult = handleImageUpload('homeIMG', $oldIMG, 'home');
  if (isset($uploadBannerResult['error'])) {
    echo json_encode(['success' => false, 'message' => $uploadBannerResult['error']]);
    exit;
  }
  if (isset($uploadIMGResult['error'])) {
    echo json_encode(['success' => false, 'message' => $uploadIMGResult['error']]);
    exit;
  }
  $newBannerName = $uploadBannerResult['newImageName']; // 有可能是 null
  $newIMGName = $uploadIMGResult['newImageName']; // 有可能是 null

  // ✅ 找到對應 number 的項目並更新 banner 名稱
  foreach ($updateOptions as &$item) {
    if ($item['number'] === $number && $newBannerName) {
      $item['banner'] = $newBannerName;
    }
    if ($item['number'] === $number && $newIMGName) {
      $item['img'] = $newIMGName;
    }
  }

  // ✅ 最後打包 JSON
  $ArticleOptionJson = json_encode($updateOptions, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

  // ✅ 查詢資料庫是否已有記錄
  $sql = "SELECT * FROM tbl_basic LIMIT 1";
  $res = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($res);
  $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

  if ($count > 0) {
    $id = $row['id'];
    $stmt = $conn->prepare("UPDATE tbl_basic SET basic_navbarOptions = ? WHERE id = ?");
    $stmt->bind_param("si", $ArticleOptionJson, $id);

    if ($stmt->execute()) {
      $response = ['success' => true, 'message' => '資料更新成功'];
    } else {
      $response = ['success' => false, 'message' => '資料更新失敗'];
    }

    $stmt->close();
  } else {
    $stmt = $conn->prepare("INSERT INTO tbl_basic (basic_navbarOptions) VALUES (?)");
    $stmt->bind_param("s", $ArticleOptionJson);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $response = ['success' => true, 'message' => '資料上傳成功', 'data' => ['id' => $stmt->insert_id]];
    } else {
      $response = ['success' => false, 'message' => '資料上傳失敗'];
    }

    $stmt->close();
  }

} catch (Exception $e) {
  $response = ['success' => false, 'message' => $e->getMessage()];
}

mysqli_close($conn);
echo json_encode($response);
?>
