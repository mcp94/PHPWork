<!doctype>
<html>
<head>
	<title>Lab 8</title>
</head>
<body>
<a href="index.php">Home</a>
<form id='login' action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
		<fieldset >
			<legend>Login</legend>
			<label for='username' >UserName:</label>
			<input type='text' name='username' id='username' maxlength="50" required/> 
			<label for='password' >Password:</label>
			<input type='password' name='password' id='password' maxlength="50" required/>
			<input type='submit' name='Submit' value='Submit' />
		</fieldset>
	</form>

<?php
	include('logic.php');
	session_start();
//If session exists, redirect them to home
	if(isset($_SESSION['username']))
		header('Location: /~mcpv49/cs3380/lab8/home.php');
//Form submission
	if (isset( $_POST['Submit'] ) )
	{
//Save username and password from post
		$username = htmlspecialchars($_POST['username']);
		$password = htmlspecialchars($_POST['password']);
//Save IP address.
		$ipaddress = $_SERVER["REMOTE_ADDR"];
//Action set
		$action = "login";
//Check log in information
	  if(check_username_and_password($username,$password,$conn)==1)
	  {
//Set username
	  	$_SESSION['username'] = $username;
//Append the log
	  	store_login_data($username, $ipaddress, $action);
		header('Location: /~mcpv49/cs3380/lab8/home.php');
	  }
	  else
	  	echo "Incorrect password or username. Try again!";	
  }
?>
<br>
<a href = "registration.php">Register</a>
</body>
</html>