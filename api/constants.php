<?php
  // session_start();

  define('SITEURL', 'http://localhost/website1/');
  define('LOCALHOST','localhost');
  define('DB_USERNAME','root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'laucho-website');

  // define('SITEURL', 'http://laucho.atwebpages.com/');
  // define('LOCALHOST','fdb1027.runhosting.com');
  // define('DB_USERNAME','4516423_website1');
  // define('DB_PASSWORD', 'lauchoassass1');
  // define('DB_NAME', '4516423_website1');

  // define('SITEURL', 'http://lauchobackstage.zya.me/');
  // define('LOCALHOST','fdb1027.runhosting.com');
  // define('DB_USERNAME','mseet_37089192');
  // define('DB_PASSWORD', 'lauchoassas');
  // define('DB_NAME', 'mseet_37089192_website1');

  $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
  $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn));
?>