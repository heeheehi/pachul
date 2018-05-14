<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/api.php";
mysqli_query($connect, "set names utf8");

$mysqlFunction = new mysqlFunctions();

$route = $_GET['route'];
$callItem = $_GET['callItem'];
$callDataArray = json_decode($callItem, true);
$callID = $callDataArray['id'];

//파라미터를 전부 json으로 보내는 것이 나을까
//아님 주요변수를 따로 떼는게 나을까?
//삭제할 때에는 콜 id만 보내줘도 되는데?!
//클래스를 쓰는 이유는 무엇일까?
//this-> 이걸 쓰는건 메소드 내 변수/함수 사용, 위에 선언이 되어있어야 함

//my information case
if(get_parameter('route') == 'myInfo') {
  echo('myInfo page');
  print_r($mysqlFunction->mysql_get_row('employer', $callID));
}

//call send case
if(get_parameter('route') == 'call') {
  $mysqlFunction->mysql_insert('call',$callItem);
  $mysqlFunction->mysql_call_count_down('employer',$callItem);
  echo "call";
}

//call cancel case
if(get_parameter('route') == 'callCancel') {
  //이미 배정된 콜은 취소 불가
  $assignCondition = $mysqlFunction->assign_condition($callID);
  if($assignCondition ==="notAssigned"){
    echo $mysqlFunction->mysql_delete('call',$callID);
  }
  else if($assignCondition ==="assigned"){
   echo "Assigned";
  }
  else if($assignCondition ==="assignConfirmed"){
    echo "AssignConfirmed";
  }
}

//error case
if(get_parameter('route') == 'default') {
  //error
  echo "no route";
}


?>