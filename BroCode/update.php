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
<head>
  <meta charset="UTF-8">
  <title>Update details|BroCode</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.min.css'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300'>
    <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,700,300'>
    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font   -awesome.min.css'>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="shortcut icon" href="favicon.ico">
</head>

  <body>
      <div class="signup__container">
      <div class="container__child signup__thumbnail">
        <div class="thumbnail__content text-center">
          <!-- <h2 class="headingsecondary">Forgot your password?<br>Don't worry <br></h2> -->
          <h1 class="heading--primary">Update Your Details</h1>
        </div>
        <div class="signup__overlay"></div>
      </div>
      <div class="container__child signup__form">
        <form action="#">
          <div class="form-group">
            <label for="username">Password</label>
            <input class="form-control" type="password" name="password" value="" placeholder="Password" required />
          </div>
          <div class="form-group">
            <label for="password">Phone number</label>
            <input class="form-control" type="text" name="phone_no" value="" placeholder="Phone number" required />
          </div>
          <div class="form-group">
            <label for="passwordRepeat">Address</label>
            <input class="form-control" type="text" name="address" value="" placeholder="Address" required />
          </div>
          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input class="form-control" type="text" name="dob" value="" placeholder="Date of Birth" required />
          </div>
          <div class="form-group">
            <label for="path">Path of Profile Picture</label>
            <input class="form-control" type="text" name="dp" value="" placeholder="Path of Profile Picture" required />
          </div>
          <div class="m-t-lg">
            <ul class="list-inline">
              <li>
                <input class="btn btn--form" type="submit" name="update" value="Save Changes" />
              </li>
            </ul>
          </div>
        </form>  
      </div>
    </div>
  </body>
