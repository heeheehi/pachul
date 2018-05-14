<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";

class mysqlFunctions{

  //get function
  public function mysql_get_row($tableName, $id){
    global $connect;
    $getQuery = "SELECT * FROM `".$tableName."` WHERE id = " . $id . "";
    $getResult = mysqli_query($connect, $getQuery) or die(mysqli_error($connect));
    if(mysqli_num_rows($getResult)==0){
      return "There is no data";
    }
    elseif (mysqli_num_rows($getResult)==1){
      return_msg(mysqli_fetch_assoc($getResult));
    }

  }

  //insert function
  public function mysql_insert($tableName, $data){
    global $connect;
    var_dump($data);
    echo "<br/>";
    $dataArray = json_decode($data, true);
    var_dump($dataArray);
    echo "<br>";
    $dataKeys = array_keys($dataArray);
    $dataValues = array_map(array($connect, 'real_escape_string'), array_values($dataArray));
    $dataKeysString = implode(",", $dataKeys);
    $dataValuesString = implode(",", $dataValues);

    $insertQuery =
      "INSERT INTO `".$tableName."`(".$dataKeysString.") VALUES (".$dataValuesString.")";
    echo $insertQuery;
    echo "<br>";
    $insertResult = mysqli_query($connect, $insertQuery) or die(mysqli_error($connect));
    return $insertResult;
  }

  //call count down function
  public function mysql_call_count_down($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['employerID']!=null){
      $employerID = $dataArray['employerID'];
      $countDownQuery =
        "UPDATE `".$tableName."` SET leftCalls = leftCalls-1 WHERE id = ".$employerID."";
      $countDownResult = mysqli_query($connect, $countDownQuery)  or die(mysqli_error($connect));
    }
    else
      return "there is no employerID";
  }

  //call count up function
  public function mysql_call_count_up($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['employerID']!=null){
      $employerID = $dataArray['employerID'];
      $countDownQuery =
        "UPDATE `".$tableName."` SET leftCalls = leftCalls+1 WHERE id = ".$employerID."";
      $countDownResult = mysqli_query($connect, $countDownQuery)  or die(mysqli_error($connect));
    }
    else
      return "there is no employerID";
  }

  //delete function
  public function mysql_delete($tableName, $id){
    global $connect;

    if($this->mysql_get_row('call',$id)==1){
      $deleteQuery = "DELETE FROM `".$tableName."` WHERE ".$tableName.".id = ".$id." LIMIT 1";
      $deleteResult = mysqli_query($connect, $deleteQuery)  or die(mysqli_error($connect));
      return "Successfully deleted!";
    }
    else return "There is no data with id: ".$id."...!";
  }

  public function mysql_update($tableName, $columnName, $value){
    global $connect;
    $updateQuery = "UPDATE `".$tableName."` SET ".$columnName." = ".$value."LIMIT 1";
    $updateResult = mysqli_query($connect, $updateQuery) or die(mysqli_error($connect));
    return $updateResult;
  }

  public function add_user($id, $pw, $name){
    global $connect;
//    $getQuery = "SELECT * FROM `USER_TB` WHERE id='$id' AND pw='$pw'";
//    $addUserResult = mysqli_query($connect, $addUserQuery) or die(mysqli_error($connect));

    $addUserQuery = "INSERT INTO `USER_TB` (id, pw, name) VALUES ($id, $pw, $name)";
    $addUserResult = mysqli_query($connect, $addUserQuery) or die(mysqli_error($connect));
    return $addUserResult;
  }

  function assign_condition($callID){
    global $connect;
    $assignConditionQuery = "SELECT * FROM `call` WHERE id = ".$callID." LIMIT 1";
    $assignConditionResult = mysqli_query($connect, $assignConditionQuery) or die(mysqli_query($connect));
    $assignConditionRow = mysqli_fetch_assoc($assignConditionResult);

    if($assignConditionRow['assigned']==true){
      if($assignConditionRow['assignConfirmed']==true)
        return "assigned";
      else return "assignConfirmed";
    }
    else return "notAssigned";
  }
}
?>