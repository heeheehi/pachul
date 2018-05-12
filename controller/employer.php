<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
mysqli_query($connect, "set names utf8");

$mysqlFunction = new mysqlFunction();//얘는 include 도 안했는데 가능하네??

//json 데이터 받아서 $callItem 변수에 저장
$callItem = '
{
    "companyID": 12,
    "date": 2,
    "startHour": 3,
    "startMin": 4
}
';
$callID = 123;
//example

//파라미터를 전부 json으로 보내는 것이 나을까
//아님 주요변수를 따로 떼는게 나을까?
//삭제할 때에는 콜 id만 보내줘도 되는데?!

//클래스를 쓰는 이유는 무엇일까?
//this-> 이걸 쓰는건 메소드 내 변수/함수 사용, 위에 선언이 되어있어야 함

$mysqlFunction->mysql_insert('CALL_TB',$callItem);//삭제
$mysqlFunction->mysql_call_count_down('CALL_TB',$callItem);//삭제

//my information case
if($mysqlFunction->get_parameter('route') == 'myInfo') {
  $mysqlFunction->mysql_get_row('COMPANY_TB', $callItem);
}

//call send case
if($mysqlFunction->get_parameter('route') == 'call') {
  $mysqlFunction->mysql_insert('CALL_TB',$callItem);
  $mysqlFunction->mysql_call_count_down('COMPANY_TB',$callItem);
}

//call cancel case
if($mysqlFunction->get_parameter('route') == 'callCancel') {
  //이미 배정된 콜은 취소 불가
  if($mysqlFunction->assign_condition($callID)=="notAssigned"){
    $mysqlFunction->mysql_delete('CALL_TB',$callItem);
  }
  else return("이미 배정된 콜입니다.");
}

//error case
if($mysqlFunction->get_parameter('route') == null) {
  //error
  echo "error";
}

?>