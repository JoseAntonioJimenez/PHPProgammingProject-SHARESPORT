<?php
    $pagetitle = 'MYPROFILE';
    session_start();
    if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {

	    header("Location: Login.php");	

    }

    include ('./includes/Header.php');
	require('./mysqli_connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
	    $id = $_SESSION['id_user'];
		$q = "update users set username='$fn', password=SHA1('$p'), email='$ln', sex='$e', prefered_sports='$ps',prefered_days='$pd',age='$age' where id_user=$id limit 1";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
			echo '<h1>Thank you!</h1>
		<p>Changes saved.</p><p><br></p>';
		} else { // If it did not run OK.
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not change the saves due to a system error. We apologize for any inconvenience.</p>';
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';
		} // End of if ($r) IF.
		mysqli_close($dbc); // Close the database connection.
		// Include the footer and quit the script:
		include('./includes/Footer.html');
		exit();
	} else { // Report the errors.
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br>';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br>\n";
		}
		echo '</p><p>Please try again.</p><p><br></p>';
	} // End of if (empty($errors)) IF.
} // End of the main Submit conditional.
$id = $_SESSION['id_user'];
$q = "SELECT username, email, Sex, Prefered_sports, Prefered_days, Age FROM users WHERE id_user=$id";
$r = @mysqli_query($dbc, $q);

if (mysqli_num_rows($r) == 1) { // Valid user ID, show the form.

	// Get the user's information:
	$row = mysqli_fetch_array($r, MYSQLI_NUM);
}

?>
<form action="MyProfile.php" method="post">
<div id="formul">
    <h2>My profile</h2>
    <hr>
	<p>Name: <input type="text" id="textbox" name="name" size="15" maxlength="20" value="<?php echo $row[0];  ?>"></p>
	<p>Password: <input type="password" id="textbox" name="password" size="15" maxlength="40" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"></p>
	<p>Confirm Password: <input type="password" id="textbox" name="pass2" size="10" maxlength="20" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>" ></p>
	<p>Email Address: <input type="email" id="textbox" name="email" size="20" maxlength="60" value="<?php echo $row[1]; ?>" > </p>
	<p>Mr.<input type="radio" name="sex" value="
		<?php
		 if ( $row[2]="Mr." ){echo 'Mr.';} ?>" >Ms.<input type="radio" name="sex" value="<?php if ( $row[2]="Ms.") echo "Ms.";?>" ></p>
	<p>Prefered Sports: <input type="text" id="textbox" name="prefered" size="15" maxlength="20" value="<?php echo $row[3];  ?>"></p>
	<p>Prefered Days: <input type="text" id="textbox" name="days" size="15" maxlength="20" value="<?php  echo $row[4]; ?>"></p>
	<p>Age: <input type="number" id="textbox" name="age" size="15" maxlength="20" value="<?php echo $row[5];  ?>"></p>
	<p><input type="submit" name="submit" value="Save changes"></p>
</div>
</form>
<?php include('./includes/Footer.html'); 
	mysqli_close($dbc); // Close the database connection.?>
