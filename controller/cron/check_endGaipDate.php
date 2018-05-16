<?
//check endGaipDate every day
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

$getEmployerQuery = "SELECT * FROM `employer`";
$getEmployerResult = mysqli_query($connect, $getEmployerQuery);

//전체 업체에 대해 실행
while($getEmployerRow = mysqli_fetch_assoc($getEmployerResult)){
  $employerID = $getEmployerRow['id'];
  $endGaipDateTime = strtotime($getEmployerRow['endGaipDate']);

  //가입 만기일 미도달 업체
  if($endGaipDateTime>$todayDateTime) {
    echo "id: ".$employerID." still activated"."<br/>";
  }
  //가입 만기일 도달 업체 - activated 값 수정
  else{
    $getEmployerRow['activated'] = 0;
    echo "id: ".$employerID." not activated"."<br/>";
  };
}

echo "All leftCalls Count reset. It's Monday!";
?>