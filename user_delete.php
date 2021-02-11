<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);


$id = $_GET["id"];


// Fetech the record to be deleted and display it
$sql = "select id, user_name, password, first_name, last_name, is_student, is_administrator from person where id = $id";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:administrator.php?session_id=$session_id");
}
oci_free_statement($cursor);

$id = $values[0];
  $user_name = $values[1];
  $password = $values[2];
  $first_name = $values[3];
  $last_name = $values[4];
  $is_student = $values[5];
  $is_admin = $values[6];

// Display the record to be deleted.
echo("
  <form method=\"post\" action=\"user_delete_action.php?session_id=$session_id\">
  Id (Read-only):        <input type=\"text\" readonly value = \"$id\" size=\"10\" maxlength=\"10\" name=\"id\"> <br /> 
  Password (Required):   <input type=\"text\" disabled value = \"$password\" size=\"20\" maxlength=\"30\" name=\"password\">  <br />
  User Name (Required):  <input type=\"text\" disabled value = \"$user_name\" size=\"20\" maxlength=\"30\" name=\"user_name\">  <br />
  First Name (Required): <input type=\"text\" disabled value = \"$first_name\" size=\"20\" maxlength=\"30\" name=\"first_name\">  <br />
  Last Name (Required):  <input type=\"text\" disabled value = \"$last_name\" size=\"20\" maxlength=\"30\" name=\"last_name\">  <br />
  Student (1/0):         <input type=\"text\" disabled value = \"$is_student\" size=\"1\" maxlength=\"1\" name=\"is_student\">  <br />
  Administrator (1/0):   <input type=\"text\" disabled value = \"$is_admin\" size=\"1\" maxlength=\"1\" name=\"is_admin\">  <br />
  ");

// // Display department list
// // create the dropdown list for the departments.
// $sql = "select dnumber, dname from dept order by dnumber";

// $result_array = execute_sql_in_oracle ($sql);
// $result = $result_array["flag"];
// $cursor = $result_array["cursor"];

// if ($result == false){
//   display_oracle_error_message($cursor);
//   die("Query Failed.");
// }

// echo("
//   Department:
//   <select disabled name=\"dnumber\">
//   <option value=\"\">Choose One:</option>
//   ");

// // Fetch the departments from the cursor one by one into the dropdown list
// while ($values = oci_fetch_array ($cursor)){
//   $d_dnumber = $values[0];
//   $d_dname = $values[1];
//   if (!isset($dnumber) or $dnumber == "" or $d_dnumber != $dnumber) {
//     echo("
//       <option value=\"$d_dnumber\">$d_dnumber, $d_dname</option>
//       ");
//   }
//   else {
//     echo("
//       <option selected value=\"$d_dnumber\">$d_dnumber, $d_dname</option>
//       ");
//   }
// }
// oci_free_statement($cursor);

echo("
  </select>  <input type=\"submit\" value=\"Delete\">
  </form>

  <form method=\"post\" action=\"administrator.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");

?>