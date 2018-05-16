<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/api.php";

mysqli_query($connect, "set names utf8");
$mysqlFunction = new mysqlFunctions();

if(isset($_GET['route'])){$route = $_GET['route'];}
if(isset($_GET['callItem'])){
  $callItem = $_GET['callItem'];
  $callDataArray = json_decode($callItem, true);
  $callID = $callDataArray['id'];
  $employerID = $callDataArray['employerID'];
}

//my information case
if(get_parameter('route') == 'myInfo') {
  return_msg($mysqlFunction->mysql_get_row('employer', $employerID));
}

//call send case
if(get_parameter('route') == 'call') {
  $mysqlFunction->mysql_insert('calls',$callItem);
  $mysqlFunction->mysql_call_count_down('employer',$callItem);
  echo "call";
}

//call cancel case
if(get_parameter('route') == 'callCancel') {
  //이미 배정된 콜은 취소 불가
  $assignCondition = $mysqlFunction->assign_condition($callID);
  if($assignCondition ==="notAssigned"){
    return_msg($mysqlFunction->mysql_delete('call',$callID));
  }
  else if($assignCondition ==="assigned"){
   return_msg("Assigned");
  }
  else if($assignCondition ==="assignConfirmed"){
    return_msg("AssignConfirmed");
  }
}

//error case
if(get_parameter('route') == 'default') {
  //error
  return_msg("Invalid route name or no route");
}

?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body></body></html>