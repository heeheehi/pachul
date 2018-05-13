<!DOCTYPE html>
<meta charset="utf-8" />
<?php
if(!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_name'])) {
  echo "<meta http-equiv='refresh' content='0;url=login.php'>";
  exit;
}
$user_id = $_COOKIE['user_id'];
$user_name = $_COOKIE['user_name'];
echo "<p>안녕하세요. $user_name($user_id)님</p>";
echo "<p><a href='logout.php'>로그아웃</a></p>";