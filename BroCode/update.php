<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        if (isset($_POST['update'])) {
                $password = $_POST['password'];
                $phone_no = $_POST['phone_no'];
                $Address = $_POST['address'];
		$dob = $_POST['dob'];
		$dp = $_POST['dp'];
		
                $userid = Login::isLoggedIn();
                if (password_verify($password, DB::query('SELECT password FROM user WHERE user_id=:userid', array(':userid'=>$userid))[0]['password'])) {
                        
                      DB::query('UPDATE userDetails SET phone=:phone_no, address=:Address, dateOfBirth=:dob, profilePic=:dp WHERE user_id=:userid', array(':userid'=>$userid, ':phone_no'=>$phone_no, ':Address'=>$Address, ':dob'=>$dob, ':dp'=>$dp));
                                        echo 'Updated details successfully!';
        	}
		else{
			echo 'Password Incorrect.';
		}
	}
}
else {
       	die('Not logged in');
}
?>
<h1>Update you Details</h1>
<form action="update.php" method="post">
        <input type="password" name="password" value="" placeholder="Password ..."><p />
        <input type="text" name="phone_no" value="" placeholder="Phone number ..."><p />
        <input type="text" name="address" value="" placeholder="Address ..."><p />
	<input type="text" name="dob" value="" placeholder="Date of Birth ..."><p />
	<input type="text" name="dp" value="" placeholder="Path of Profile Picture ..."><p />
        <input type="submit" name="update" value="Save Changes">
</form>

