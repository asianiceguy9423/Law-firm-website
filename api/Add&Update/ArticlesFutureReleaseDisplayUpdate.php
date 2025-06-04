<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('../../api/constants.php');

if (!$conn) {
    echo json_encode(['success' => false, 'message' => '資料庫連結錯誤: ' . mysqli_connect_error()]);
    exit;
}

try {
    $input = json_decode(file_get_contents("php://input"), true);
    $newDisplay = isset($input['newDisplay']) && in_array($input['newDisplay'], [0, 1], false)
    ? (int)$input['newDisplay']
    : null;


    $sql = "SELECT * FROM tbl_articles_future_release LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    $row = $count > 0 ? mysqli_fetch_assoc($res) : null;

    if ($count > 0) {
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_articles_future_release SET articles_future_release_display = ? WHERE id = ?");
        $stmt->bind_param("ii", $newDisplay, $id);

        $stmt->execute();
        echo json_encode([
            'success' => $stmt->affected_rows >= 0,
            'message' => $stmt->affected_rows > 0 ? '資料更新成功' : '資料無變更',
            'debug' => [
                'newDisplay' => $newDisplay,
                'id' => $id,
                'affected_rows' => $stmt->affected_rows
            ]
        ]);
        $stmt->close();
    } else {
        $stmt = $conn->prepare("INSERT INTO tbl_articles_future_release (articles_future_release_display) VALUES (?)");
        $stmt->bind_param("i", $newDisplay);
        $stmt->execute();

        echo json_encode([
            'success' => $stmt->affected_rows > 0,
            'message' => $stmt->affected_rows > 0 ? '資料上傳成功' : '資料上傳失敗',
            'debug' => [
                'newDisplay' => $newDisplay,
                'affected_rows' => $stmt->affected_rows
            ]
        ]);
        $stmt->close();
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>
