<?
//employer - reset weekly call count
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

$getEmployerQuery = "SELECT * FROM `employer`";
$getEmployerResult = mysqli_query($connect, $getEmployerQuery);

while($getEmployerRow = mysqli_fetch_assoc($getEmployerResult)){
  $employerID = $getEmployerRow['id'];
  $endGaipDateTime = strtotime($getEmployerRow['endGaipDate']);
  $Gujwa = $getEmployerRow['Gujwa'];
  $newLeftCalls = $Gujwa*$callsPerGujwa;

  //가입 만기일 미도달 업체 - 콜 수 리셋
  if($endGaipDateTime>$todayDateTime) {
    $query = "UPDATE `employer` SET leftCalls = '$newLeftCalls' WHERE id = " . $employerID . "";
    $result = mysqli_query($connect, $query);
    echo "Gujwa: " . $Gujwa . " New LeftCalls: " . $newLeftCalls . " <br />";
  }
  //가입 만기일 도달 업체 - 콜 수 초기화
  else{
    $query = "UPDATE `employer` SET leftCalls = 0 WHERE id = ".$employerID."";
    $result = mysqli_query($connect,$query);
    echo "Gaip ended Company"."<br />";
  };
}

echo "All leftCalls Count reset. It's Monday!";
?>