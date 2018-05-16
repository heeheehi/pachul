<?php
include $_SERVER['DOCUMENT_ROOT']."controller/config/config.php";

$userID = $_POST['user_id'];
$userPW = $_POST['user_pw'];

$loginQuery = "SELECT * FROM `user` where userID = '".$userID."' AND userPW = '".$userPW."' LIMIT 1";
echo $loginQuery;
$loginResult= mysqli_query($connect, $loginQuery) or die(mysqli_error($connect));
$loginRow = mysqli_fetch_assoc($loginResult);
$userName = $loginRow['name'];
$count=mysqli_num_rows($loginResult);

//입력 제대로 안했을 때
if(!isset($userID)||!isset($userPW)){
  echo "invalid";
  alert("invalid");
  exit;
}
//아이디 또는 패스워드가 일치하지 않음
if ($count==0){
  echo "no matching";
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