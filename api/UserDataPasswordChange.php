<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

$response = [];

if (!$conn) {
    echo json_encode(['success' => false, 'message' => '資料庫連結錯誤' . mysqli_connect_error()]);
    exit;
}

try {
    $newPassword = isset($_POST['newPassword']) ? htmlspecialchars($_POST['newPassword'], ENT_QUOTES, 'UTF-8') : null;

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM tbl_users LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $response = ['success' => false, 'message' => 'SQL 錯誤:' . mysqli_error($conn)];
        echo json_encode($response);
        exit;
    }
    $count = mysqli_num_rows($res);

    if ($count > 0){
        $row = mysqli_fetch_assoc($res);
        $id = $row['id'];
        $stmt = $conn->prepare("UPDATE tbl_users SET
        password = ?
        WHERE id = ?
        ");
        $stmt->bind_param("si", 
        $hashedPassword, 
        $id
        );

        if($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response = ['success' => true, 'message' => '密碼變更成功'];
            }
        }else{
            $response = ['success' => false, 'message' => '密碼變更失敗'];
        }       
        $stmt->close();
    }else{
        $stmt = $conn->prepare("INSERT INTO tbl_users(
        password)
        VALUES (?)");
        $stmt->bind_param("s", 
        $hashedPassword);

        $stmt->execute();
        if($stmt->affected_rows > 0){
            $response = ['success' => true, 'message' => '密碼變更成功', 'data' => ['id' => $stmt->insert_id]];
        }else{
            $response = ['success' => false, 'message' => '密碼變更失敗'];
            echo json_encode($response);
            exit;
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage(), 'data' => null];
    echo json_encode($response);
    exit;
}

mysqli_close($conn);
echo json_encode($response);
?>