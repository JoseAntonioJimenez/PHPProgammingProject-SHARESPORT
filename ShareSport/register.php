<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';
include('header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('./mysqli_connect.php');
	$errors = [];
	if (empty($_POST['name'])) {
		$errors[] = 'You forgot to enter your name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['name']));
	}
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	if (empty($_POST['sex'])) {
		$errors[] = 'You forgot to enter your sex.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['sex']));
	}
	if (!empty($_POST['password'])) {
		if ($_POST['password'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['password']));
		}
	} else {
		$errors[] = 'You forgot to enter your password.';
	}
	if (empty($_POST['prefered'])) {
		$errors[] = 'You forgot to enter your prefered sports.';
	} else {
		$ps = mysqli_real_escape_string($dbc, trim($_POST['prefered']));
	}
	if (empty($_POST['days'])) {
		$errors[] = 'You forgot to enter your prefered days.';
	} else {
		$pd = mysqli_real_escape_string($dbc, trim($_POST['days']));
	}
	if (empty($_POST['age'])) {
		$errors[] = 'You forgot to enter your age.';
	} else {
		$age = mysqli_real_escape_string($dbc, trim($_POST['age']));
	}
	if (empty($errors)) {

		$q = "INSERT INTO users (username, password, email, sex, prefered_sports,prefered_days,age,activation_date) VALUES ('$fn', SHA1('$p'),'$ln', '$e','$ps','$pd','$age', NOW() )";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			echo '<h1>Thank you!</h1>
		<p>You are now registered.</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('footer.html');
		exit();

	} else { // Report the errors.

		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';

	} // End of if (empty($errors)) IF.

	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<p>Name: <input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"></p>
	<p>Password: <input type="password" name="password" size="15" maxlength="40" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"></p>
	<p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p>Email Address: <input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" > </p>
	<p>Mr.<input type="radio" name="sex" value="
		<?php
		 if (isset($_POST['sex']) && $_POST['sex']="Mr."){ echo $_POST['sex'];} 
		 else {echo "Ms."; }?>" >Ms.<input type="radio" name="sex" value="<?php if (isset($_POST['sex'])&&$_POST['sex']="Ms.") echo $_POST['sex']; else echo "Ms.";?>" ></p>
	<p>Prefered Sports: <input type="text" name="prefered" size="15" maxlength="20" value="<?php if (isset($_POST['prefered'])) echo $_POST['prefered']; ?>"></p>
	<p>Prefered Days: <input type="text" name="days" size="15" maxlength="20" value="<?php if (isset($_POST['days'])) echo $_POST['days']; ?>"></p>
	<p>Age: <input type="number" name="age" size="15" maxlength="20" value="<?php if (isset($_POST['age'])) echo $_POST['age']; ?>"></p>
	<p><input type="submit" name="submit" value="Register"></p>
</form>
<?php include('includes/footer.html'); ?>