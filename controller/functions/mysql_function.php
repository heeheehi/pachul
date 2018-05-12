<?php
include $_SERVER['DOCUMENT_ROOT']."/config/config.php";

class mysqlFunction{
  private $parameter;

  //get parameter
  public function get_parameter ($name, $default = null) {
    if(isset($this->parameter[$name]))
      return $this->parameter[$name];
    return $default;
  }

  //get function
  public function mysql_get_row($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['id']!=null){
      $id = $dataArray['id'];
      $getQuery = "SELECT * FROM $tableName WHERE id = ".$id."";
      $getResult = mysqli_query($connect, $getQuery) or die(mysqli_error($connect));
      return $getResult;
    }
    else
      return "there is no id";
  }

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
    return $insertResult;
  }

  //call count down function
  public function mysql_call_count_down($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['companyID']!=null){
      $companyID = $dataArray['companyID'];
      $countDownQuery =
        "UPDATE '$tableName' SET leftCalls = leftCalls - 1 WHERE id = '$companyID'";
      $countDownResult = mysqli_query($connect, $countDownQuery)  or die(mysqli_error($connect));
    }
    else
      return "there is no companyID";
  }

  //call count up function
  public function mysql_call_count_up($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['companyID']!=null){
      $companyID = $dataArray['companyID'];
      $countDownQuery =
        "UPDATE '$tableName' SET leftCalls = leftCalls + 1 WHERE id = '$companyID'";
      $countDownResult = mysqli_query($connect, $countDownQuery)  or die(mysqli_error($connect));
    }
    else
      return "there is no companyID";
  }

  //call cancel function
  public function mysql_delete($tableName, $data){
    global $connect;
    $dataArray = json_decode($data, true);
    if($dataArray['id']!=null){
      $id = $dataArray['id'];
      $deleteQuery = "DELETE FROM ".$tableName." WHERE ".$tableName.".id = ".$id."";
      $deleteResult = mysqli_query($connect, $deleteQuery)  or die(mysqli_error($connect));
      return $deleteResult;
    }
    else
      return "there is no id";
  }

  public function add_user($id, $pw, $name){
    global $connect;

    $getQuery = "SELECT * FROM USER_TB WHERE id='$id' AND pw='$pw'";

    $addUserQuery = "INSERT INTO USER_TB (id, pw, name) VALUES ($id, $pw, $name)";
    $addUserResult = mysqli_query($connect, $addUserQuery) or die(mysqli_error($connect));
    return $addUserResult;
  }


  function assign_condition($callID){
    global $connect;
    $query = "SELECT * FROM 'ASSIGN_TB' WHERE id = ".$callID."";
    $result = mysqli_query($connect, $query) or die(mysqli_query($connect));
    $row = mysqli_fetch_assoc($result);

    if($row['assigned']==true){
      if($row['assignConfirmed']==true)
        return "assigned";
      else return "assignConfirmed";
    }
    else return "notAssigned";
  }
}
?>