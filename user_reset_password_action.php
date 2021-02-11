<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

$default_password = "123456";

if (!isset($_POST["update_fail"])) { // from administrator.php
  // Fetch the record to be updated.
  $id = $_GET["id"];

  $sql = "update person set password = '$default_password' " .
          "where id = $id";

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }
}

// Record updated.  Go back.
Header("Location:administrator.php?session_id=$session_id");
?>