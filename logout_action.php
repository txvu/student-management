<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);


// connection OK - delete the session.
$sql = "delete from login_session where session_id = '$session_id'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];
if ($result == false){
  display_oracle_error_message($cursor);
  die("Session removal failed");
}

// jump to login page
header("Location:login.html");
?>