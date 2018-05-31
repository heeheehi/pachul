<?php
include $_SERVER['DOCUMENT_ROOT'] . "/controller/config/config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/controller/functions/api.php";

class mysqlFunctions
{

  //get function
  public function mysql_get_row($tableName, $id, $tableID, $condition = null)
  {
    global $connect;
    $getQuery = "SELECT * FROM `" . $tableName . "` WHERE `" . $tableID . "` = " . $id;
    if (isset($condition)) {
      $getQuery .= " AND " . $condition;
    }
    $getResult = mysqli_query($connect, $getQuery) or die(mysqli_error($connect));
    if (mysqli_num_rows($getResult) == 0) {
      return_msg("There is no data matching");
    } else {
      while ($getRow = mysqli_fetch_assoc($getResult)) {
        $array[] = $getRow;
      }
      return_msg("OK", $array);
    }
  }

  //테이블 두 개를 조인해서 공통의 keyValue(ex:123)를 key(ex:employerID)로 가지는 데어터를 리턴
  public function mysql_select_join($tableName1, $tableName2, $key, $keyValue)
  {
    global $connect;
    $joinQuery =
      "SELECT * FROM `" . $tableName1 . "` INNER JOIN `" . $tableName2 . "` ON 
      `" . $tableName1 . "`." . $key . "= " . $keyValue . " AND `" . $tableName2 . "`." . $key . " =" . $keyValue . "";
    echo $joinQuery;
    $joinResult = mysqli_query($connect, $joinQuery) or die(mysqli_error($connect));
    while ($joinRow = mysqli_fetch_assoc($joinResult)) {
      $array[] = $joinRow;
    }
    return_msg("OK", $array);
  }

  //테이블 세 개 조인 - table1, table2는 컬럼 안의 데이터 값까지 같아야, table3는 table1과 같은 컬럼값.
  public function union_3_tables($table1, $table2, $table3, $key1, $keyValue1, $key2)
  {
    global $connect;
    $query =
      "SELECT * FROM `" . $table1 . "` 
      inner JOIN `" . $table2 . "` ON 
      `" . $table1 . "`." . $key1 . "= " . $keyValue1 . " AND `" . $table2 . "`." . $key1 . " =" . $keyValue1 .
      " inner JOIN `" . $table3 . "` ON `" . $table1 . "`." . $key2 . " = `" . $table3 . "`." . $key2;
    echo $query;
    $result = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_assoc($result)) {
      $array[] = $row;
    }
    return_msg("OK", $array);
  }

  //insert function
  public function mysql_insert($tableName, $data)
  {
    global $connect;
    $dataArray = json_decode($data, true);
    $dataKeys = array_keys($dataArray);
    $dataValues = array_map(array($connect, 'real_escape_string'), array_values($dataArray));
    for ($i = 0; $i < count($dataValues); $i++) {
      $dataValues[$i] = "'" . $dataValues[$i] . "'";
    }
    $dataKeysString = implode(",", $dataKeys);
    $dataValuesString = implode(",", $dataValues);

    $insertQuery =
      "INSERT INTO `" . $tableName . "`(" . $dataKeysString . ") VALUES (" . $dataValuesString . ")";
    $insertResult = mysqli_query($connect, $insertQuery) or die(mysqli_error($connect));
    return_msg("OK");
  }

  //call count down function
  public function mysql_call_count_down($employerID)
  {
    global $connect;
    $countDownQuery =
      "UPDATE `employer` SET `leftCalls` = `leftCalls`-1 WHERE `employerID` = " . $employerID . " LIMIT 1";
    $countDownResult = mysqli_query($connect, $countDownQuery) or die(mysqli_error($connect));
  }

  //call count up function
  public function mysql_call_count_up($employerID)
  {
    global $connect;
    $countDownQuery =
      "UPDATE `employer` SET `leftCalls` = `leftCalls`+1 WHERE `employerID` = " . $employerID . " LIMIT 1";
    $countDownResult = mysqli_query($connect, $countDownQuery) or die(mysqli_error($connect));
  }

  public function mysql_update($tableName, $tableID, $id, $data)
  {
    global $connect;

    $dataArray = json_decode($data, true);
    $keys = array_keys($dataArray);
    $values = array_map(array($connect, 'real_escape_string'), array_values($dataArray));

    print_r($values);

    $updateQuery = "UPDATE `" . $tableName . "` SET ";
    for ($i = 0; $i < count($values); $i++) {
      $updateQuery .=
        "`" . $keys[$i] . "`" . " = '" . $values[$i] . "' ";
      if ($i != count($values) - 1) {
        $updateQuery .= ",";
      }
    }
    $updateQuery .= "WHERE `" . $tableName . "`.`" . $tableID . "`= " . $id . " LIMIT 1";

    $updateResult = mysqli_query($connect, $updateQuery) or die(mysqli_error($connect));
    return_msg($updateResult);
  }

  public function add_user($id, $pw, $name)
  {
    global $connect;
    $addUserQuery = "INSERT INTO `user` (id, pw, name) VALUES ($id, $pw, $name)";
    $addUserResult = mysqli_query($connect, $addUserQuery) or die(mysqli_error($connect));
    return $addUserResult;
  }

  function assign_condition($callID)
  {
    global $connect;
    $assignConditionQuery = "SELECT * FROM `calls` WHERE `callId` = " . $callID . " LIMIT 1";
    $assignConditionResult = mysqli_query($connect, $assignConditionQuery) or die(mysqli_query($connect));
    $assignConditionRow = mysqli_fetch_assoc($assignConditionResult);

    if ($assignConditionRow['employeeID'] != null) {
      if ($assignConditionRow['assignConfirmed'] == 1) {
        return_msg("assigned");
      } else return_msg("assignConfirmed");
    } else return_msg("notAssigned");
  }
}

?>