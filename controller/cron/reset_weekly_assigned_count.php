<?
//employee - reset weekly assigned count
include $_SERVER['DOCUMENT_ROOT']."/controller/config/config.php";

$query = "SELECT * FROM `employee`";
$result = mysqli_query($connect,$query) or die(mysqli_error($connect));
while($row = mysqli_fetch_assoc($result)){
  $row['weeklyCount'] = 0;
  echo "id: ".$row['id']." weekly count reset"."<br/>";
}
?>