<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

// Verify where we are from, administrator.php or  user_update_action.php.
if (!isset($_POST["update_fail"])) { // from administrator.php
  // Fetch the record to be updated.
  $id = $_GET["id"];

  // the sql string
  $sql = "select id, user_name, password, first_name, last_name, is_student, is_administrator from person where id = $id";
  //echo($sql);

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $id = $values[0];
  $user_name = $values[1];
  $password = $values[2];
  $first_name = $values[3];
  $last_name = $values[4];
  $is_student = $values[5];
  $is_admin = $values[6];
}
else { // from user_update_action.php
  // Obtain values of the record to be updated directly.
  $id = $_POST["id"];
  $user_name = $_POST["user_name"];
  $password = $_POST["password"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $is_student = $_POST["is_student"];
  $is_admin = $_POST["is_admin"];
}

// Display the record to be updated.
echo("
  <form method=\"post\" action=\"user_update_action.php?session_id=$session_id\">
  Id (Read-only):        <input type=\"text\" readonly value = \"$id\" size=\"10\" maxlength=\"10\" name=\"id\"> <br /> 
  Password (Required):  <input type=\"text\" value = \"$password\" size=\"20\" maxlength=\"30\" name=\"password\">  <br />
  User Name (Required):  <input type=\"text\" value = \"$user_name\" size=\"20\" maxlength=\"30\" name=\"user_name\">  <br />
  First Name (Required): <input type=\"text\" value = \"$first_name\" size=\"20\" maxlength=\"30\" name=\"first_name\">  <br />
  Last Name (Required):  <input type=\"text\" value = \"$last_name\" size=\"20\" maxlength=\"30\" name=\"last_name\">  <br />
  Student (1/0):         <input type=\"text\" value = \"$is_student\" size=\"1\" maxlength=\"1\" name=\"is_student\">  <br />
  Administrator (1/0):   <input type=\"text\" value = \"$is_admin\" size=\"1\" maxlength=\"1\" name=\"is_admin\">  <br />
  ");

echo("
  </select>  <input type=\"submit\" value=\"Update\">
  </form>

  <form method=\"post\" action=\"user_reset_password_action.php?session_id=$session_id&id=$id\">
  <input type=\"submit\" value=\"Reset Password\">
  </form>

  <form method=\"post\" action=\"administrator.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>