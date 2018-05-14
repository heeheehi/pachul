<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
include $_SERVER['DOCUMENT_ROOT']."/controller/functions/mysql_function.php";
include $_SERVER['DOCUMENT_ROOT']."/controller/functions/api.php";

if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
$userID = $_POST['user_id'];
$userPW = $_POST['user_pw'];

$query = "select * from `user` where id = ".$userID." AND pw = ".$userPW."";
$result= mysqli_query($connect, $query) or die(mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
$userName = $row['name'];
$count=mysqli_num_rows($result);

//입력 제대로 안했을 때
if(!isset($userID)||!isset($userPW)){
  alert("invalid");
  exit;
}
//아이디 또는 패스워드가 일치하지 않음
if ($count==0){
  alert("no matching");
  exit;
}
if ($count>1){
  alert("duplicated users");
  exit;
}
setcookie('user_id',$userID,time()+(86400*30),'/');
setcookie('user_name',$userName,time()+(86400*30),'/');
?>
<meta http-equiv='refresh' content='0;url=main.php'>