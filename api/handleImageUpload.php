<?php
function handleImageUpload($imageFieldName, $currentImageName, $uploadType) {
    // 🔹 設定不同的上傳資料夾（根據 `uploadType`）
    $uploadFolders = [
        'join'   => __DIR__ . "/../src/assets/join/",
        'home' => __DIR__ . "/../src/assets/home/",
        'about'  => __DIR__ . "/../src/assets/about/",
        'basic'  => __DIR__ . "/../src/assets/basic/",
        'contact'  => __DIR__ . "/../src/assets/contact/",
        'article'  => __DIR__ . "/../src/assets/article/",
        'default'=> __DIR__ . "/../src/assets/uploads/" // 預設資料夾
    ];

    // 🔹 選擇對應的上傳資料夾
    $destinationFolder = isset($uploadFolders[$uploadType]) ? $uploadFolders[$uploadType] : $uploadFolders['default'];

    // ✅ 確保目標資料夾存在（如果不存在則建立）
    if (!is_dir($destinationFolder)) {
        mkdir($destinationFolder, 0777, true);
    }

    // ✅ 如果沒有上傳新圖片，回傳 `null`，代表不更改圖片
    if (!isset($_FILES[$imageFieldName]) || $_FILES[$imageFieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['newImageName' => null]; // ✅ 確保回傳 null
    }

    // ✅ 檢查圖片大小（限制 15MB）
    if ($_FILES[$imageFieldName]['size'] > 15000000) {
        return ['error' => '圖片文件太大(限制15MB)'];
    }

    // ✅ 檢查副檔名與 MIME 類型
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'svg', 'gif'];
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/svg+xml', 'image/gif'];

    $safeFileName = basename($_FILES[$imageFieldName]['name']);
    $fileExtension = strtolower(pathinfo($safeFileName, PATHINFO_EXTENSION));
    $mime_type = mime_content_type($_FILES[$imageFieldName]['tmp_name']);

    if (!in_array($fileExtension, $allowedExtensions) || !in_array($mime_type, $allowedMimeTypes)) {
        return ['error' => '只能上傳 jpg、png、gif 和 svg'];
    }

    // ✅ 產生新的圖片名稱
    $newImageName = $imageFieldName . time() . '_' . rand(0, 9999) . '.' . $fileExtension;
    $src_path = $_FILES[$imageFieldName]['tmp_name'];
    $des_path = $destinationFolder . $newImageName;

    // ✅ 移動上傳圖片
    if (!move_uploaded_file($src_path, $des_path)) {
        return ['error' => '上傳圖片失敗'];
    }

    // ✅ 刪除舊圖片（如果有）
    if ($currentImageName && file_exists($destinationFolder . $currentImageName)) {
        $remove_path = $destinationFolder . $currentImageName;
        if (!unlink($remove_path)) {
            return ['error' => '刪除舊圖片失敗'];
        }
    }
    error_log("要刪除的檔案：" . $destinationFolder . $currentImageName);

    return ['newImageName' => $newImageName];
}
?>
