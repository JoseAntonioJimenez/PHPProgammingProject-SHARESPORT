<!DOCTYPE html>
<html>
<header>
	<title>ShareSports</title>	
	<link rel="stylesheet" href="includes/Style.css" type="text/css" media="screen" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

</header>
<body>
    <div class="header">
    <a class="logo"><img id="logo" src="includes/ShareSports.PNG"></a>
	<div id="header-righ">
		<ul>
			<li><a class="<?php if ($pagetitle == 'HOME') {echo'active';}else {echo'noactive';} ?>" href="Home.php">Home</a></li>
			<li><a class="<?php if ($pagetitle == 'EVENTS') {echo'active';}else{echo'noactive';} ?>" href="Events.php">Events</a></li>
			<li><a class="<?php if ($pagetitle == 'RESERVATION') {echo'active';}else{echo'noactive';} ?>" href="Reservations.php">Reservations</a></li>
			<li><a class="<?php if ($pagetitle == 'MYPROFILE') {echo'active';}else{echo'noactive';} ?>" href="MyProfile.php">My Profile</a></li>
			<li><a class="<?php if ($pagetitle == 'LOGIN') {echo'active';}else{echo'noactive';} ?>" href="Login.php">Login</a></li>
		</ul>
	</div>
    </div>
    </body>
</html>