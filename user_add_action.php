<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);  

// Get the values of the record to be inserted.
$id = $_POST["id"];
// if ($id == "") $id = "NULL";

// $id = $_POST["id"];
$user_name = $_POST["user_name"];
$password = $_POST["password"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$is_student = $_POST["is_student"];
$is_admin = $_POST["is_admin"];

// Form the insertion sql string and run it.
$sql = "insert into person values ($id, '$user_name', '$password', '$first_name', '$last_name', '$is_student', '$is_admin')";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
  
  die("<i> 

  <form method=\"post\" action=\"user_add?session_id=$session_id\">

  <input type=\"hidden\" value = \"$id\" name=\"id\">
  <input type=\"hidden\" value = \"$password\" name=\"password\">
  <input type=\"hidden\" value = \"$user_name\" name=\"user_name\">
  <input type=\"hidden\" value = \"$first_name\" name=\"first_name\">
  <input type=\"hidden\" value = \"$last_name\" name=\"last_name\">
  <input type=\"hidden\" value = \"$is_student\" name=\"is_student\">
  <input type=\"hidden\" value = \"$is_admin\" name=\"is_admin\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record inserted.  Go back.
Header("Location:administrator.php?session_id=$session_id");
?>