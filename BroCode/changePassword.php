<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        if (isset($_POST['changepassword'])) {
                $oldpassword = $_POST['oldpassword'];
                $newpassword = $_POST['newpassword'];
                $newpasswordrepeat = $_POST['newpasswordrepeat'];
                $userid = Login::isLoggedIn();
                if (password_verify($oldpassword, DB::query('SELECT password FROM user WHERE user_id=:userid', array(':userid'=>$userid))[0]['password'])) {
                        if ($newpassword == $newpasswordrepeat) {
                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {
                                        DB::query('UPDATE user SET password=:newpassword WHERE user_id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                        echo 'Password changed successfully!';

                                }
                        } else {
                                echo 'Passwords don\'t match!';
                        }
                } else {
                        echo 'Incorrect old password!';
                }
        }
} else {
        die('Not logged in');
}
?>
<head>
  <meta charset="UTF-8">
  <title>Change Password|BroCode</title>
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
          <h2 class="heading--secondary">Feel Unsecure?</h2>
          <h1 class="heading--primary">Change Your Password</h1>
        </div>
        <div class="signup__overlay"></div>
      </div>
      <div class="container__child signup__form">
        <form action="changePassword.php" method="post">
          <div class="form-group">
            <label for="username">Current Password</label>
            <input class="form-control" type="password" name="oldpassword" value="" placeholder="Current Password" required />
          </div>
          <div class="form-group">
            <label for="password">New Password</label>
            <input class="form-control" type="password" name="newpassword" value="" placeholder="New Password" required />
          </div>
          <div class="form-group">
            <label for="passwordRepeat">Repeat Password</label>
            <input class="form-control" type="password" name="newpasswordrepeat" value="" placeholder="Repeat Password" required />
          </div>
          <div class="m-t-lg">
            <ul class="list-inline">
              <li>
                <input class="btn btn--form" type="submit" name="changepassword" value="Change Password" />
              </li>
            </ul>
          </div>
        </form>  
      </div>
    </div>
  </body>
