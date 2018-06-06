<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";

$mysqlFunction = new mysqlFunctions();

//my information
if (get_parameter('route') == 'myInfo') {
  $employerID = $_GET['employerID'];
  $query = "
    SELECT `employer`.`ceoName`,`employer`.`leftCalls`, `employer`.`employerID`,
    `join_employer`.`startDate`, `join_employer`.`endDate`,`join_employer`.`Gujwa`, `company`.`companyName` 
    FROM `employer` 
    INNER JOIN `join_employer` 
    ON `employer`.employerID = `join_employer`.`employerID`
    INNER JOIN `company` 
    ON `employer`.employerID = `company`.`employerID` 
    WHERE `employer`.employerID = '" . $employerID . "' AND `join_employer`.`endDate`> '" . $todayDate . "' 
    ORDER BY `join_employer`.`endDate` DESC 
    LIMIT 1;
  ";
  $result = mysqli_query($connect, $query);
  $row = mysqli_fetch_assoc($result);
  return_msg("OK", $row);
}

//call send
//DB에 값 입력 후 OK만 리턴
if (get_parameter('route') == 'call') {
  $callItem = json_decode($_GET['callItem']);
  $callID = $_GET['callID'];
  $employerID = $_GET['employerID'];
  $mysqlFunction->mysql_insert('call', $callItem);
  $mysqlFunction->mysql_call_count_down($employerID);
  return_msg("OK");
}

//call list
//call 테이블과 employer 테이블에서 공통의 employerID로 $employerID를 갖는 데이터 JOIN,
//call 테이블의 employee 테이블에서 공통의 employeeID를 갖는 데이터 JOIN
if (get_parameter('route') == 'callList') {
  $employerID = $_GET['employerID'];
  $startDate = $_GET['startDate'];
  $endDate = $_GET['endDate'];

  $query = "
    SELECT `call`.`callID`,`call`.`workingDate`, `call`.`category`, `call`.`startTime`, `call`.`endTime`, `call`.`detail`, `call`.`isCancel`, 
    `employee`.`employeeName`
    FROM `call` LEFT JOIN `employee`
    ON `call`.`employeeID` = `employee`.`employeeID`
    WHERE `call`.`employerID` = ".$employerID." AND  '".$startDate."' <= `call`.`workingDate` AND `call`.`workingDate` <= '".$endDate."'
  ";
    $result = mysqli_query($connect, $query);
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
  }
  return_msg("OK", $array);
}

//call cancel
if (get_parameter('route') == 'callCancel') {
  $callID = $_GET['callID'];
  $employerID = $_GET['employerID'];
  //이미 배정된 콜은 취소 불가
  $assignCondition = $mysqlFunction->assign_condition($callID);
  if ($assignCondition === "notAssigned") {
    $mysqlFunction->mysql_call_count_up($employerID);
    $query =
      "UPDATE `call` SET  `isCancel` =  '1' WHERE  `call`.`callID` = '".$callID."' LIMIT 1 ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    return_msg("OK");
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