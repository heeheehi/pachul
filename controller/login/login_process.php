<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
include $_SERVER['DOCUMENT_ROOT']."/controller/functions/mysql_function.php";
include $_SERVER['DOCUMENT_ROOT']."/controller/functions/api.php";

$mysqlFunction = new mysqlFunction();
$error = new Errors();

if(!isset($_POST['user_id']) || !isset($_POST['user_pw'])) exit;
$userID = $_POST['user_id'];
$userPW = $_POST['user_pw'];

$query = "select * from user where id = ".$userID." AND pw = ".$userPW."";
$result= mysqli_query($connect, $query) or die(mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
$count=mysqli_num_rows($result);

print_r($row);

//입력 제대로 안했을 때
if(!isset($userID)||!isset($userPW)){
  $error->alert("invalid");
}
//아이디 또는 패스워드가 일치하지 않음
if ($count==0){
  $error->alert("no matching");
}
if ($count>1){
  $error->alert("db error");
}

session_start();
$_SESSION['user_id'] = $userID;
$_SESSION['user_name'] = $row['name'];
?>
<meta http-equiv='refresh' content='0;url=main.php'>