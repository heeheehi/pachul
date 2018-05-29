<?php
//db information
$db_host = "localhost";
$db_user = "informationsys";
$db_pw = "ingee440";
$db_name = "informationsys";
$domain_address = "http://bestpachul.com";
$connect = mysqli_connect("$db_host", "$db_user", "$db_pw", "$db_name");

//default values
$callsPerGujwa = 3;
$todayDate = date("Y-m-d H:i:s");
$todayDateTime = strtotime($todayDate);

//initial headers
mysqli_query($connect, "set names utf8");

//CORS를 통한 ACAO ERROR 해결
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');

$error000 = "Invalid data";
$error100 = "Error 100: There is no data";
$error200 = "Error 200: Duplicated data";

?>