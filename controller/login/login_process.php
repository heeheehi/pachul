<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";
//LogIn

$userName = $_GET['userName'];
$userPW = $_GET['userPW'];

$query = "SELECT * FROM `user` where `userName` = '" . $userName . "' AND `userPW` = '" . $userPW . "'";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
$count = mysqli_num_rows($result);

//입력 제대로 안했을 때
if (!isset($userName) || !isset($userPW)) {
  return_msg($error000);
  exit();
}
//아이디 또는 패스워드가 일치하지 않음
if ($count == 0) {
  return_msg($error100);
  exit();
}
//중복된 ID, PW
if ($count > 1) {
  return_msg($error200);
  exit();
}

//위 에러에 걸리지 않으면 쿠키 생성
setcookie("userName", $userName, time() + 86300, '/');
setcookie("token", md5($userPW), time() + 86300, '/');

return_msg('OK', $row);
exit();


?>