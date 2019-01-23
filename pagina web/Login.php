<?php 
$pagetitle = 'LOGIN';
include('./includes/Header.php');
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require ('./mysqli_connect.php');
	
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass']);
	if ($check) { // OK!
		// Set the session data:
		session_start();
		$_SESSION['id_user'] = $data['id_user'];
		$_SESSION['UserName'] = $data['username'];
		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);
		echo md5($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		header('location: Events.php');
			
	} else { // Unsuccessful!

		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.
?>
<h1 id="header_register">Log in to see and manage your events !!!</h1>
<form id="formul" action="Login.php" method="post">
    <h2>Log in</h2>
    <hr>
	<p>UserName: <input type="text" id="textbox" name="username" size="20" maxlength="60" /> </p>
	<p>Password: <input type="password" id="textbox" name="pass" size="20" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
    <h4>
        You are not yet registered?<br>Click <a href="Register.php">Here</a>!!!
    </h4>
</form>
<?php
function check_login($dbc, $user = '', $pass = '') {
	$errors = array(); // Initialize error array.

	// Validate the email address:
	if (empty($user)) {
		$errors[] = 'You forgot to enter your username.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($user));
	}

	// Validate the password:
	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) { // If everything's OK.

		$q = "SELECT id_user, username FROM users WHERE username='$e' AND password=SHA1('$p')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if (mysqli_num_rows($r) == 1) {
			// Fetch the record:
			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
			
			// Return true and the record:
			return array(true, $row);
			
		} else { // Not a match!
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	} // End of empty($errors) IF.
	
	// Return false and the errors:
	return array(false, $errors);

} // End of check_login() funct
// Create the page:
include ('./includes/Footer.html');
?>