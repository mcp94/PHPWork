<!doctype>
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form id='register' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
		<fieldset >
			<legend>Register</legend>
			<label for='username' >Desired Username:</label>
			<input type='text' name='username' id='username' maxlength="50" required/> 
			<label for='password' >Desired Password:</label>
			<input type='password' name='password' id='password' maxlength="50" required/>
			<input type='submit' name='Submit' value='Submit' />
		</fieldset>
	</form>


<?php
	session_start();
  include("logic.php");
  if ( isset( $_POST['Submit'] ) )
  {
//Save username and password
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
//Check if username is already in use
		if(check_username_exists($username)==0)
		{
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			$action = "register";
//If username is unique, accept it
			add_user($username,$password);
//Log the user in and append the log in
			store_login_data($username, $ipaddress, $action);
			$_SESSION['username'] = $username;
			header('Location: /~mcpv49/cs3380/lab8/home.php');
		}
		else
			echo "Error. Username is already in use!";
	}
  ?>
  <br><a href="index.php">Back to login</a> 
</body>
</html>