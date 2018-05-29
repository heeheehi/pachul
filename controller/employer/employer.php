<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";

$mysqlFunction = new mysqlFunctions();

//my information case
if(get_parameter('route') == 'myInfo') {
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_get_row('employer', $employerID,'employerID');
}

//call send case
if(get_parameter('route') == 'call') {
  $callItem = $_GET['callItem'];
  $callID = $_GET['callID'];
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_insert('calls',$callItem);
  $mysqlFunction->mysql_call_count_down($employerID);
}

//call cancel case
if(get_parameter('route') == 'callCancel') {
  $callID = $_GET['callID'];
  $cancelData = $_GET['cancelData'];
  //이미 배정된 콜은 취소 불가
  $assignCondition = $mysqlFunction->assign_condition($callID);
  if($assignCondition ==="notAssigned"){
    $mysqlFunction->mysql_call_count_down($employerID);
    $mysqlFunction->mysql_update('calls','callID',$callID,$cancelData);
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
  return_msg("Invalid route name or no route");
}

?>