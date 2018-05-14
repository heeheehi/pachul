<?php
//db information
$db_host = "localhost";
$db_user = "aika823";
$db_pw = "ingee440";
$db_name = "aika823";
$domain_address = "http://pachul.dothome.co.kr";
$connect = mysqli_connect("$db_host", "$db_user", "$db_pw", "$db_name");

mysqli_query($connect, "set names utf8");
//CORS를 통한 ACAO ERROR 해결
header("Access-Control-Allow-Origin: *");
?>