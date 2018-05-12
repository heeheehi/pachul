<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
mysqli_query($connect, "set names utf8");

$mysqlFunction = new mysqlFunction();//얘는 include 도 안했는데 가능하네??

//업체 추가/수정 form 으로 받은 데이터
$companyItem = '
{
    "companyID": 12,
    "date": 2,
    "startHour": 3,
    "startMin": 4
}
';
$companyName = "감자탕";

//insert case
if($mysqlFunction->get_parameter('route') == 'insert') {
  $mysqlFunction->mysql_insert('COMPANY_TB',$companyItem);
  $mysqlFunction->add_user("name");
}


?>