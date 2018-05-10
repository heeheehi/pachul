<?php
//db information
$db_host = "localhost";
$db_user = "aika823";
$db_pw = "ingee440";
$db_name = "aika823";
$domain_address = "http://pachul.dothome.co.kr";

class mysqlFunction{

  //insert function
  public function mysql_insert($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    $dataKeys = array_keys($dataArray);
    $dataValues = array_map(array($connect, 'real_escape_string'), array_values($dataArray));
    $dataKeysString = implode(",", $dataKeys);
    $dataValuesString = implode(",", $dataValues);

    $insertQuery =
      "INSERT INTO $tableName (".$dataKeysString.") VALUES (".$dataValuesString.")";
    $insertResult = mysqli_query($connect, $insertQuery) or die(mysqli_error($connect));
  }

  //call count down function
  public function mysql_call_count_down($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['companyID']!=null){
      $companyID = $dataArray['companyID'];

      $countDownQuery =
        "UPDATE $tableName SET leftCalls = leftCalls - 1 WHERE id = '$companyID'";
      $countDownResult = mysqli_query($connect, $countDownQuery)  or die(mysqli_error($connect));
    }
    else{
      return "there is no companyID";
    }
  }

  //get function
  public function mysql_get_row($tableName){
    global $connect;
    $query = "SELECT * FROM '$tableName'";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
  }
}

?>