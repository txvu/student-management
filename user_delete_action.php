<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);


ini_set( "display_errors", 0);  


$id = $_POST["id"];

// Form the sql string and execute it.
$sql = "delete from person where id = $id";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"administrator.php?session_id=$session_id\">
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record deleted.  Go back.
Header("Location:administrator.php?session_id=$session_id");
?>