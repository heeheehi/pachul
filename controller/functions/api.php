<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";

class Errors{
  function alert($message){
    echo "<script>alert('".$message."');history.back();</script>";
  }
}

function isUser()
{
  if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    return true;
  } else return false;
}

?>
