<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);

$sql = "select first_name, last_name, is_student, is_administrator " .
        "from person where id = (select person_id from login_session where session_id='$session_id')";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($values = oci_fetch_array ($cursor)){
  oci_free_statement($cursor);
  $first_name = $values[0];
  $last_name = $values[1];
  $is_student = $values[2];
  $is_administrator = $values[3];
}

echo("<H1>$first_name $last_name</H1>");

// Here we can generate the content of the welcome page
echo("Data Management Menu: <br />");

if ($is_student == 1) {
  echo("<UL>
  <LI><A HREF=\"student.php?session_id=$session_id\">Student Portal</A></LI>
  </UL>");
}

if ($is_administrator == 1) {
  echo("<UL>
  <LI><A HREF=\"administrator.php?session_id=$session_id\">Administrator Portal</A></LI>
  </UL>");
}

echo("<br />");
echo("<br />");
echo("Click <A HREF = \"logout_action.php?session_id=$session_id\">here</A> to Logout.");
?>