<?
//employer - reset weekly call count
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

if($_COOKIE[counter]){
//실제 사용은 아래로
//if(!$_COOKIE[counter]){

  $getEmployerQuery = "SELECT * FROM `employer`";
  $getEmployerResult = mysqli_query($connect, $getEmployerQuery);

  while($getEmployerRow = mysqli_fetch_assoc($getEmployerResult)){
    $employerID = $getEmployerRow['employerID'];
    $endJoinDateTime = strtotime($getEmployerRow['endJoinDate']);
    $Gujwa = $getEmployerRow['gujwa'];
    $newLeftCalls = $Gujwa*$callsPerGujwa;

    //가입 만기일 미도달 업체 - 콜 수 리셋
    if($endJoinDateTime>$todayDateTime) {
      $query = "UPDATE `employer` SET `leftCalls` = ".$newLeftCalls." WHERE `employerID` = ".$employerID." LIMIT 1";
      $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
      echo "ID: ".$employerID." - Gujwa: " . $Gujwa . " New LeftCalls: " . $newLeftCalls . " <br />";
    }
    //가입 만기일 도달 업체 - 콜 수 초기화
    else{
      $query = "UPDATE `employer` SET `leftCalls` = 0 WHERE `employerID` = ".$employerID." LIMIT 1";
      $result = mysqli_query($connect,$query) or die(mysqli_error($connect));
      echo "ID: ".$employerID." - Join Ended <br />";
    };
  }
  echo "All leftCalls Count reset.";
  setcookie("counter", "1");
}

else{
  setcookie("counter", $_COOKIE[counter] + 1);
  echo "you have visited $_COOKIE[counter] times since last visit";
}

?>