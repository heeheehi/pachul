<?php
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

function get_parameter($key){
  if(isset($_GET[$key])){return $_GET[$key];}
  else return 'default';
}

function isUser()
{
  if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])) {
    return true;
  } else return false;
}

function return_msg($state, $data=Null) {
  header('Content-type: application/json;charset=utf-8');
  header("Connection: Keep-Alive");
  echo json_encode(array('msg'=>$state,'request'=>$data));
  return json_encode(array('msg'=>$state,'request'=>$data));
//  exit;
}

function alert($message){
  echo "<script>alert('".$message."');history.back();</script>";
}
function console_log($message){
  echo "<script>console.log('".$message."');</script>";
}

?>
