<?php
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

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
  if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])) {
    return true;
  } else return false;
}

function return_msg( $data ) {
  session_write_close();
  header('Content-type: application/json;charset=utf-8');
  header("Connection: Keep-Alive");
  echo json_encode(array('request'=>$data));
  return json_encode(array('request'=>$data));
//  exit;
}


?>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body></body></html>