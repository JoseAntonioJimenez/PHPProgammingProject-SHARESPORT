<?php 
$page_title = 'Login';
include('header.html');
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require ('./mysqli_connect.php');
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass']);
	echo $check;
	if ($check) { // OK!
		// Set the session data:
		session_start();
		$_SESSION['id_user'] = $data['user_id'];
		$_SESSION['UserName'] = $data['username'];
		
		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		header('location: Events.php');
			
	} else { // Unsuccessful!

		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.
?>
<h1>Login</h1>
<form action="login.php" method="post">
	<p>UserName: <input type="text" name="username" size="20" maxlength="60" /> </p>
	<p>Password: <input type="password" name="pass" size="20" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
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
include ('footer.html');
?>