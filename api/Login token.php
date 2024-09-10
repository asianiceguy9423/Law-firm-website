<?php
// 設置 CORS 頭部以允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

include('constants.php');

//獲取post
$data = json_decode(file_get_contents('php://input'),true);

$username = $data['username'];
$password = $data['password'];

if(!empty($username) && !empty($password)){
  // 防止 SQL 注入攻擊，使用 mysqli_real_escape_string 函數來處理輸入
  $username = mysqli_real_escape_string($conn, $username);
  $password = mysqli_real_escape_string($conn, $password);

  // 準備查詢檢查使用者是否存在
  $sql = "SELECT * FROM tbl_users WHERE username = '$username'";
  $res = mysqli_query($conn, $sql);

  if(mysqli_num_rows($res) > 0){
    $user = mysqli_fetch_assoc($res);

    // 驗證密碼是否正確
    if(password_verify($password, $user['password'])){
      // 密碼正確，生成 token
      $token = bin2hex(random_bytes(16));
      echo json_encode(['token' => $token]);
    }else{
      http_response_code(401);
      echo json_encode(['error' => 'Invalid credentials']);
    }
  }else{
    // 沒有找到使用者
    http_response_code(401);
    echo json_encode(['error' => 'Invalid credentials']);
  }
}else{
  // 使用者名稱或密碼缺失
  http_response_code(400);
  echo json_encode(['error' => 'Username and password are required']);
}

mysqli_close($conn);
?>
