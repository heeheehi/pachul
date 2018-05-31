<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";

$mysqlFunction = new mysqlFunctions();

//my information
if (get_parameter('route') == 'myInfo') {
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_get_row('employer', $employerID, 'employerID');
}

//call send
//DB에 값 입력 후 OK만 리턴
if (get_parameter('route') == 'call') {
  $callItem = $_GET['callItem'];
  $callID = $_GET['callID'];
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_insert('calls', $callItem);
  $mysqlFunction->mysql_call_count_down($employerID);
}

//call list
//call 테이블과 employer 테이블에서 공통의 employerID로 $employerID를 갖는 데이터 JOIN,
//call 테이블의 employee 테이블에서 공통의 employeeID를 갖는 데이터 JOIN
if (get_parameter('route') == 'callList') {
  $employerID = $_GET['employerID'];
  $mysqlFunction->union_3_tables('call', 'employer', 'employee', 'employerID', $employerID, 'employeeID');
}

//call cancel
if (get_parameter('route') == 'callCancel') {
  $callID = $_GET['callID'];
  $cancelData = $_GET['cancelData'];
  //이미 배정된 콜은 취소 불가
  $assignCondition = $mysqlFunction->assign_condition($callID);
  if ($assignCondition === "notAssigned") {
    $mysqlFunction->mysql_call_count_up($employerID);
    $mysqlFunction->mysql_update('calls', 'callID', $callID, $cancelData);
  } else if ($assignCondition === "assigned") {
    return_msg("Assigned");
  } else if ($assignCondition === "assignConfirmed") {
    return_msg("AssignConfirmed");
  }
}

//error case
if (get_parameter('route') == 'default') {
  return_msg("Invalid route name or no route");
}

?>