<!DOCTYPE html>
<meta charset="utf-8" />
<?php
include $_SERVER['DOCUMENT_ROOT']."/controller/functions/api.php";
session_start();
//로그인되지 않은 상태
if(isUser()) {
  //login.php로 보낸다
  echo "<meta http-equiv='refresh' content='0;url=login.php'>";
  exit;
}
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
echo "<p>안녕하세요. $user_name($user_id)님</p>";
echo "<p><a href='logout.php'>로그아웃</a></p>";
?>