<?php

$page_title = 'Events';
include('header.html');
echo '<h1>Avaliable Events</h1>';

require('../mysqli_connect.php');
$display = 10;

$q = "SELECT id_eventos, actividad, lugar, hora, numero_participantes, descripcion, precio, edad_recomendada, participantes FROM eventos where actividad in $preferidas ORDER BY hora LIMIT 0, $display";
$r = @mysqli_query($dbc, $q);

echo '<table width="60%">
<thead>
<tr>
	<th align="left"><strong>Edit</strong></th>
	<th align="left"><strong>Delete</strong></th>
	<th align="left"><strong><a href="view_users.php?sort=ln">Last Name</a></strong></th>
	<th align="left"><strong><a href="view_users.php?sort=fn">First Name</a></strong></th>
	<th align="left"><strong><a href="view_users.php?sort=rd">Date Registered</a></strong></th>
</tr>
</thead>
<tbody>
'; 

$bg = '#eeeeee';
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_user.php?id=' . $row['id_eventos'] . '">Edit</a></td>
		<td align="left"><a href="delete_user.php?id=' . $row['id_eventos'] . '">Delete</a></td>
		<td align="left">' . $row['actividad'] . '</td>
		<td align="left">' . $row['lugar'] . '</td>
		<td align="left">' . $row['hora'] . '</td>
		<td align="left">' . $row['numero_participantes'] . '</td>
		<td align="left">' . $row['descripcion'] . '</td>
		<td align="left">' . $row['precio'] . '</td>
		<td align="left">' . $row['edad_recomendada'] . '</td>
		<td align="left">' . $row['participantes'] . '</td>
	</tr>
	';
}

echo '</tbody></table>';
mysqli_free_result($r);
mysqli_close($dbc);
include('footer.html');
?>