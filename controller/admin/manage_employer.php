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
  global $connect;
  $employerID = $_GET['employerID'];
  $query = "
    SELECT `startDate`, `endDate`, `Gujwa`, `price`, `detail`, `createdTime` FROM `join_employer` 
    WHERE `employerID` = '".$employerID."'
  ";
  $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
  while ($row = mysqli_fetch_assoc($result)) {
    $array[] = $row;
  }
  return_msg("OK", $array);
}

//배정 내역
if(get_parameter('route') == 'assignHistory') {
  global $connect;
  $employerID = $_GET['employerID'];
  $query = "
    SELECT 
    `call`.`callID`,`call`.`workingDate`, `call`.`category`, `call`.`startTime`, `call`.`endTime`, `call`.`detail`, 
    `call`.`createdTime`,`employee`.`employeeName`, `company`.`companyName`
    FROM `call` 
    LEFT JOIN `employee` ON `call`.`employeeID` = `employee`.`employeeID`
    LEFT JOIN `company` ON `call`.`employerID` = `company`.`employerID`
    WHERE `call`.`employerID` = '".$employerID."'
  ";
  $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
  while ($row = mysqli_fetch_assoc($result)){
    $array[] = $row;
  }
  return_msg("OK", $array);
}

//error case
if(get_parameter('route') == 'default') {
  return_msg("Invalid route name or no route");
}
?>