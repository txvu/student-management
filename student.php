<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

$sql = "select id, user_name, password, first_name, last_name, is_student, is_administrator " .
        "from person where id = (select person_id from login_session where session_id='$session_id')";

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

echo("
  <form method=\"post\" action=\"student_update_action.php?session_id=$session_id\">
  Id (Read-only):              <input type=\"text\" readonly value = \"$id\" size=\"10\" maxlength=\"10\" name=\"id\"> <br /> 
  Password (Required):         <input type=\"text\" value = \"$password\" size=\"20\" maxlength=\"30\" name=\"password\">  <br />
  User Name (Read-only):       <input type=\"text\" readonly value = \"$user_name\" size=\"20\" maxlength=\"30\" name=\"user_name\">  <br />
  First Name (Read-only):      <input type=\"text\" readonly value = \"$first_name\" size=\"20\" maxlength=\"30\" name=\"first_name\">  <br />
  Last Name (Read-only):       <input type=\"text\" readonly value = \"$last_name\" size=\"20\" maxlength=\"30\" name=\"last_name\">  <br />
  Student (Read-only):         <input type=\"text\" readonly value = \"$is_student\" size=\"1\" maxlength=\"1\" name=\"is_student\">  <br />
  Administrator (Read-only):   <input type=\"text\" readonly value = \"$is_admin\" size=\"1\" maxlength=\"1\" name=\"is_admin\">  <br />
  ");

  echo("
  </select>  <input type=\"submit\" value=\"Change Password\">
  </form>

  <form method=\"post\" action=\"welcomepage.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");

?>