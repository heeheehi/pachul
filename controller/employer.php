<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
$connect = mysqli_connect("$db_host", "$db_user", "$db_pw", "$db_name");
mysqli_query($connect, "set names utf8");

//json 데이터 받아서 $callItem 변수에 저장
$callItem = '
{
    "companyID": 12,
    "date": 2,
    "startHour": 3,
    "startMin": 4
}
';//example

$mysqlFunction = new mysqlFunction();
$mysqlFunction->mysql_insert('CALL_TB',$callItem);
$mysqlFunction->mysql_call_count_down('CALL_TB',$callItem);

if(isset($_GET['route'])){

  $route = $_GET['route'];

  //send call mode
  if($route=='call'){
    $mysqlFunction->mysql_insert('CALL_TB',$callItem);
    $mysqlFunction->mysql_call_count_down('COMPANY_TB',$callItem);
  }

  //delete call mode
  elseif($route=='deleteCall'){

  }

  //no mode error
  else{
    return "error";
  }

}

?>