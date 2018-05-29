<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";

$mysqlFunction = new mysqlFunctions();

//업체 삽입
if(get_parameter('route') == 'insert') {
  $employerData = $_GET['employerData'];
  $mysqlFunction->mysql_insert('employer',$employerData);
}

//업체 재가입
if(get_parameter('route') == 'reJoin') {
  $employerData = $_GET['employerData'];
  $mysqlFunction->mysql_insert('employer',$employerData);
}

//업체 수정
if(get_parameter('route') == 'update') {
  $employerID = $_GET['employerID'];
  $employerData = $_GET['employerData'];
  $mysqlFunction->mysql_update('employer','employerID',$employerID,$employerData);
}

//업체 삭제
if(get_parameter('route') == 'delete') {
  $employerID = $_GET['employerID'];
  $deleteData = $_GET['deleteData'];
  $mysqlFunction->mysql_update('employer','employerID', $employerID, $deleteData);
}

//가입 내역
if(get_parameter('route') == 'joinHistory') {
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_get_row('join',$employerID, 'employerID');
}

//배정 내역
if(get_parameter('route') == 'assignHistory') {
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_get_row('calls',$employerID,'employerID',"`assigned`=1");
}

//error case
if(get_parameter('route') == 'default') {
  return_msg("Invalid route name or no route");
}
?>