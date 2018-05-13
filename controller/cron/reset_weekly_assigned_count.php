<?
//employee - reset weekly assigned count
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";

$query = "UPDATE `employee` SET weeklyAssignedCount = 0";
$result = mysqli_query($connect,$query);
echo "All weekly Count reset. It's Monday!";
?>