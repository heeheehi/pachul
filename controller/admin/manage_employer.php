<?php
include $_SERVER['DOCUMENT_ROOT'] . "/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/mysql_function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/api.php";
mysqli_query($connect, "set names utf8");

//업체 삽입 / 수정
if(get_parameter('route') == 'myInfo') {

}

//인력 삽입 / 수정

?>