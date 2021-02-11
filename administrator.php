<?
include "utility_functions.php";

$session_id =$_GET["session_id"];
verify_session($session_id);


// Generate the query section
echo("
  <form method=\"post\" action=\"administrator.php?session_id=$session_id\">
  User Name: <input type=\"text\" size=\"15\" maxlength=\"15\" name=\"user_name\">

  First Name: <input type=\"text\" size=\"15\" maxlength=\"15\" name=\"first_name\">
  Last Name: <input type=\"text\" size=\"15\" maxlength=\"15\" name=\"last_name\">

  Student <input type=\"radio\" name=\"is_student\" value=\"student\"/>
  Administrator <input type=\"radio\" name=\"is_administrator\" value=\"administrator\"/>
  
  <input type=\"submit\" value=\"Search\">
  </form>

  

  <form method=\"post\" action=\"welcomepage.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Go Back\">
  </form>

  <form method=\"post\" action=\"user_add.php?session_id=$session_id\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>
  ");


// Interpret the query requirements
$user_name = $_POST["user_name"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$is_student = $_POST["is_student"];
$is_administrator = $_POST["is_administrator"];

$whereClause = " 1=1 ";

if (isset($user_name) and trim($user_name)!= "") { 
  $whereClause .= " and user_name like '%$user_name%'"; 
}

if (isset($first_name) and trim($first_name)!= "") { 
  $whereClause .= " and first_name like '%$first_name%'"; 
}

if (isset($last_name) and trim($last_name)!= "") { 
  $whereClause .= " and last_name like '%$last_name%'"; 
}

if (isset($is_student) and $is_student=="student") { 
  $whereClause .= " and is_student = 1"; 
}

if (isset($is_administrator) and $is_administrator== "administrator") { 
  $whereClause .= " and is_administrator = 1"; 
}


// Form the query and execute it
$sql = "select id, user_name, password, first_name, last_name, is_student, is_administrator from person where $whereClause order by id";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}


// Display the query results
echo "<table border=1>";
echo "<tr> <th>ID</th> <th>User_Name</th> <th>Password</th> <th>First_Name</th> <th>Last_Name</th> <th>Is_Student</th> <th>Is_Admin</th> <th>Update</th> <th>Delete</th></tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $id = $values[0];
  $username = $values[1];
  $password = $values[2];
  $firstname = $values[3];
  $lastname = $values[4];
  $isstudent = $values[5];
  $isadmin = $values[6];

  if ($isstudent == 1) {
    $isstudent_verbose = "Yes";
  } else {
    $isstudent_verbose = "_";
  }

  if ($isadmin == 1) {
    $isadmin_verbose = "Yes";
  } else {
    $isadmin_verbose = "_";
  }

  echo("<tr>" . 
    "<td>$id</td> <td>$username</td> <td>$password</td> <td>$firstname</td> <td>$lastname</td> <td>$isstudent_verbose</td> <td>$isadmin_verbose</td>".
   
    " <td> <A HREF=\"user_update.php?session_id=$session_id&id=$id\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?session_id=$session_id&id=$id\">Delete</A> </td> ".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";
?>