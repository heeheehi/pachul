<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";
mysqli_query($connect, "set names utf8");

$mysqlFunction = new mysqlFunction();//얘는 include 도 안했는데 가능하네??


?>