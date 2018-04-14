<?php
include('./classes/DB.php');

function isLoggedIn() {
        if (isset($_COOKIE['SNID'])) {
                if (DB::query('SELECT user_id FROM login_table WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
                        $userid = DB::query('SELECT user_id FROM login_table WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];
                                return $userid;
                        }
	}
        return false;
}

if (!isLoggedIn()) {
        die("Not logged in.");
}
if (isset($_POST['confirm'])) {
        if (isset($_POST['alldevices'])) {
                DB::query('DELETE FROM login_table WHERE user_id=:userid', array(':userid'=>isLoggedIn()));
        } else {
                if (isset($_COOKIE['SNID'])) {
                        DB::query('DELETE FROM login_table WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                
        }
	
	
	header('Location: welcome.html');
	echo "Logged out.";
}
?>
<head>
	<title>Logout|Brocode</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href=css/style3.css">
</head>
<body>
	<div class="container">
		<div class="jumbotron" id="jumbo">
			<h2>Logout of your Account?</h2>
			<br>
			<p>Check the box to log out of all devices. Leave it unchecked it you wanna log out of only this device.</p>
			<form action="logout.php" method="post">
        <input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br />
        <input type="submit" name="confirm" value="Confirm">
</form>
		</div>
	</div>
</body>
