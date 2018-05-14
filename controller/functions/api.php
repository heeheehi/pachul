<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";

function get_parameter($key){
  if(isset($_GET[$key])){
    return $_GET[$key];
  }
  else return 'default';
}

function alert($message){
  echo "<script>alert('".$message."');history.back();</script>";
}
function console_log($message){
  echo "<script>console.log('".$message."');</script>";
}

function isUser()
{
  if (!isset($_COOKIE['user_id']) || !isset($_COOKIE['user_name'])) {
    return true;
  } else return true;
}

function return_msg($result){
  echo $result;
  return $result;
}


?>
