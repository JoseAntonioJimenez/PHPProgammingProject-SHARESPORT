<?php
session_start();
if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {

	header("Location: Login.php");	

}

$pagetitle = 'EVENTS';
include('./includes/Header.php');
echo '<h1 id="header_register">Avaliable Events</h1>';

require('./mysqli_connect.php');
if (isset($_GET['m'])){
	$iduser = $_SESSION['UserName'];
	$iduser2 = $_SESSION['id_user'];
	$idevent = $_GET['id'];
	$participants = $_GET['p'];
	if ($_GET['m']=='join') {
		$q = "UPDATE events SET participants='$participants $iduser,' WHERE id_event=$idevent LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		$F = "INSERT INTO participants (id_user, id_event) VALUES ('$iduser2','$idevent')";
		$X= @mysqli_query($dbc, $F);
	}
	elseif ($_GET['m']=='leave') {
		$q = "UPDATE events SET participants='' WHERE id_event=$idevent LIMIT 1";
		$r = @mysqli_query($dbc, $q);
		$F = "DELETE FROM participants where id_user='$iduser2' and id_event='$idevent'";
		$X= @mysqli_query($dbc, $F);
	}

}
$display = 10;

$q = "SELECT id_event, activity, place, datetime, participant_, description, price, recomended_Age, participants FROM events ORDER BY datetime LIMIT 0, 10";
$r = @mysqli_query($dbc, $q);

echo '<table width="60%">
<thead>
<tr>
	<th align="left"><strong>Join</strong></th>
	<th align="left"><strong>Leave</strong></th>
	<th align="left"><strong>Activity</strong></th>
	<th align="left"><strong>Place</strong></th>
	<th align="left"><strong>Date</strong></th>
	<th align="left"><strong>Participants</strong></th>
	<th align="left"><strong>Description</strong></th>
	<th align="left"><strong>Price</strong></th>
	<th align="left"><strong>Recomended Age</strong></th>
</tr>
</thead>
<tbody>
'; 

$bg = '#eeeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="Events.php?id=' . $row['id_event'] . '&m=join&p='.$row['participants'].'">Join</a></td>
		<td align="left"><a href="Events.php?id=' . $row['id_event'] . '&m=leave&p='.$row['participants'].'">Leave</a></td>
		<td align="left">' . $row['activity'] . '</td>
		<td align="left">' . $row['place'] . '</td>
		<td align="left">' . $row['datetime'] . '</td>
		<td align="left">' . $row['participant_'] . '</td>
		<td align="left">' . $row['description'] . '</td>
		<td align="left">' . $row['price'] . '</td>
		<td align="left">' . $row['recomended_Age'] . '</td>
		<td align="left">' . $row['participants'] . '</td>
	</tr>
	';
}

echo '</tbody></table>';
echo '<form action="Reservations.php" method="get">';
echo '<input type="submit" id="inputEvents" value="New Event">';
echo '</form>';
mysqli_free_result($r);
mysqli_close($dbc);
include('./includes/Footer.html');
?>