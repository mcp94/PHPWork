<?php
//Establishes the database connection
include('../secure/database.php');
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD) or die('Could not connect:' . pg_last_error());
//Check if usernames is already in use
function check_username_exists($username)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$password = pg_escape_string(htmlspecialchars($password));
	$query = "SELECT * FROM lab8.user_info where username LIKE $1";
	pg_prepare($conn, "check_u_name",$query);
	$result = pg_execute($conn,"check_u_name",array($username));
	if(pg_num_rows($result)==0)
		return 0;
	else
		return 1;
}
//Add user to the auth. table
function add_user($username,$password)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$password = pg_escape_string(htmlspecialchars($password));
	$salt = sha1(rand());
	$hash = sha1($password . $salt);
	$query = "INSERT INTO lab8.user_info (username) VALUES ($1)";
	pg_prepare($conn, "add_user_info",$query);
	$query = "INSERT INTO lab8.authentication (username, password_hash,salt) VALUES ($1,$2,$3)";
	pg_prepare($conn, "add_user_auth",$query);
	
	pg_execute($conn, "add_user_info",array($username));
	pg_execute($conn,"add_user_auth",array($username,$hash,$salt));
}
//Check password and username
function check_username_and_password($username,$password)
{
	global $conn;
	$query = "SELECT salt, password_hash FROM lab8.authentication WHERE username LIKE $1";
	pg_prepare($conn,"login",$query);
	$username = pg_escape_string(htmlspecialchars($username));
	$password = pg_escape_string(htmlspecialchars($password));
//Grab salt from the database
	$result = pg_execute($conn, "login", array($username));
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	$salt = $line['salt'];
	$db_hash = $line['password_hash'];
//Start the hash with the salt and password
	$hash = sha1($password . $salt);
//Check the salt and hash
	if($hash == $db_hash)
		return 1;
	else 
		return 0;
}
//Displays the date of registration
function registration_date($username)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$query = "SELECT registration_date FROM lab8.user_info where username LIKE $1";
	pg_prepare($conn,"reg_date",$query);
	$result = pg_execute($conn,"reg_date",array($username));
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	return $line['registration_date'];
}
//Displays IP address
function first_ip($username)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$query = "SELECT ip_address FROM lab8.log where username LIKE $1 ORDER BY log_date LIMIT 1";
	pg_prepare($conn,"get_ip",$query);
	$result = pg_execute($conn,"get_ip",array($username));
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	return $line['ip_address'];	
}
//Displays the log files
function print_logs($username)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$query = "SELECT ip_address, log_date FROM lab8.log where username LIKE $1 ORDER BY log_date desc";
	pg_prepare($conn,"get_logs",$query);
	$result = pg_execute($conn,"get_logs",array($username));
//Table creation
    echo "\n<table border=\"1\">\n\t<tr>\n";
    $i = 0;
    $numFields = pg_num_fields($result);
    while ($i < $numFields)
    {
      $fieldName = pg_field_name($result, $i);
      echo "\t\t<th>" . $fieldName . "</th>\n";
      $i ++;
    }
    echo "\t</tr>\n";
    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC))
    {
      echo "\t<tr>\n";
      foreach($line as $col_value)
      {
        echo "\t\t<td>$col_value</td>\n";
      }
      echo "\t</tr>\n";
    }
    echo "</table>\n";
}
//Saves log in data
function store_login_data($username, $ip, $action)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$ip = pg_escape_string(htmlspecialchars($ip));
	$action = pg_escape_string(htmlspecialchars($action));
	$query = "INSERT INTO lab8.log (username, ip_address,action) VALUES ($1, $2, $3)";
	pg_prepare($conn,"store_login",$query);
	pg_execute($conn,"store_login",array($username,$ip,$action));
}
//Update description
function update_desc($username, $description)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$description = pg_escape_string(htmlspecialchars($description));
	$query = "UPDATE lab8.user_info SET description = $1 WHERE username LIKE $2";
	pg_prepare($conn,"update_desc",$query);
	pg_execute($conn,"update_desc",array($description,$username));
}
//Print description
function print_desc($username)
{
	global $conn;
	$username = pg_escape_string(htmlspecialchars($username));
	$query = "SELECT description FROM lab8.user_info where username LIKE $1";
	pg_prepare($conn, "print_desc", $query);
	$result = pg_execute($conn,"print_desc",array($username));
	$line = pg_fetch_array($result, null, PGSQL_ASSOC);
	echo $line['description'];
}
?>