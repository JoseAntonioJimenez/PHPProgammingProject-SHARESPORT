<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$pagetitle = 'RESERVATION';
include('./includes/Header.php');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('./mysqli_connect.php');
	$errors = [];
	if (empty($_POST['activity'])) {
		$errors[] = 'You forgot to enter the Activity.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['activity']));
	}
	if (empty($_POST['place'])) {
		$errors[] = 'You forgot to enter the Place.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['place']));
	}
	if (empty($_POST['datetime'])) {
		$errors[] = 'You forgot to enter the datetime.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['datetime']));
	}
	if (empty($_POST['participant'])) {
		$errors[] = 'You forgot to enter the participant number.';
	} else {
		$ps = mysqli_real_escape_string($dbc, trim($_POST['participant']));
	}
	if (empty($_POST['description'])) {
		$errors[] = 'You forgot to enter the description.';
	} else {
		$pd = mysqli_real_escape_string($dbc, trim($_POST['description']));
	}
	if (empty($_POST['age'])) {
		$errors[] = 'You forgot to enter your age.';
	} else {
		$age = mysqli_real_escape_string($dbc, trim($_POST['age']));
	}
	if (empty($_POST['price'])) {
		$errors[] = 'You forgot to enter the Price.';
	} else {
		$price = mysqli_real_escape_string($dbc, trim($_POST['price']));
	}
	if (empty($errors)) {

		$q = "INSERT INTO events (activity, place, datetime, participant_, description,price,recomended_age) VALUES ('$fn','$ln', '$e','$ps','$pd','$price','$age')";
		$r = @mysqli_query($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			echo '<h1>Thank you!</h1>
		<p>You created the event.</p><p><br></p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br><br>Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include('includes/Footer.html');
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
<h1 id="header_register">Register your new event here for other users can participate</h1>
<form id="formul" action="Reservations.php" method="post">
	<h2>New Event</h2>
	<hr>
	<p>Activity: <input type="text" id="textbox" name="activity" size="15" maxlength="20" value="<?php if (isset($_POST['activity'])) echo $_POST['activity']; ?>"></p>
	<p>Place: <input type="text" id="textbox" name="place" size="15" maxlength="40" value="<?php if (isset($_POST['place'])) echo $_POST['place']; ?>"></p>
	<p>Date: <input type="datetime-local" id="textbox" name="datetime"  value="<?php if (isset($_POST['datetime'])) echo $_POST['datetime']; ?>" ></p>
	<p>Participant number: <input type="number" id="textbox" name="participant" value="<?php if (isset($_POST['participant'])) echo $_POST['participant']; ?>" > </p>
	<p>Description: <input type="textbox" id="textbox" name="description"  value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>"></p>
	<p>Price: <input type="number" id="textbox" name="price" value="<?php if (isset($_POST['number'])) echo $_POST['number']; ?>"></p>
	<p>Recomended Age: <input type="number" id="textbox" name="age" size="15" maxlength="20" value="<?php if (isset($_POST['age'])) echo $_POST['age']; ?>"></p>
	<p><input type="submit" name="submit" value="Register Event"></p>
</form>
<?php include('includes/Footer.html'); ?>