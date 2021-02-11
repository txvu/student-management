<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

// Get values for the record to be added if from user_add_action.php
$id = $_POST["id"];
$user_name = $_POST["user_name"];
$password = $_POST["password"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$is_student = $_POST["is_student"];
$is_admin = $_POST["is_admin"];

// display the insertion form.
echo("
  <form method=\"post\" action=\"user_add_action.php?session_id=$session_id\">
  Id (Required):        <input type=\"text\" value = \"$id\" size=\"10\" maxlength=\"10\" name=\"id\"> <br /> 
  Password (Required):  <input type=\"text\" value = \"$password\" size=\"20\" maxlength=\"30\" name=\"password\">  <br />
  User Name (Required):  <input type=\"text\" value = \"$user_name\" size=\"20\" maxlength=\"30\" name=\"user_name\">  <br />
  First Name (Required): <input type=\"text\" value = \"$first_name\" size=\"20\" maxlength=\"30\" name=\"first_name\">  <br />
  Last Name (Required):  <input type=\"text\" value = \"$last_name\" size=\"20\" maxlength=\"30\" name=\"last_name\">  <br />
  Student (1/0):         <input type=\"text\" value = \"$is_student\" size=\"1\" maxlength=\"1\" name=\"is_student\">  <br />
  Administrator (1/0):   <input type=\"text\" value = \"$is_admin\" size=\"1\" maxlength=\"1\" name=\"is_admin\">  <br />
  ");

echo("
  </select>
  <input type=\"submit\" value=\"Add\">
  </form>

  <form method=\"post\" action=\"administrator.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
?>