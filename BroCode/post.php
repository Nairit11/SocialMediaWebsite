<?php
include('./classes/DB.php');
include('./classes/Login.php');
$username = "";

if (Login::isLoggedIn()) {     
                
                $userid = Login::isLoggedIn();
                              
                if (isset($_POST['post'])) {
                        $postbody = $_POST['postbody'];
			$password = $_POST['password'];
                	$image = $_POST['image'];
			if (password_verify($password, DB::query('SELECT password FROM user WHERE user_id=:userid', array(':userid'=>$userid))[0]['password'])) {
                        if (strlen($postbody) > 140 || strlen($postbody) < 1) {
                                die('Incorrect length! Should be within 140 characters.');
                        }
                        
                                DB::query('INSERT INTO posts (text,image,posted_at,user_id,likes) VALUES (:postbody, :image, NOW(), :userid, 0)', array(':postbody'=>$postbody, ':image'=>$image, ':userid'=>$userid));
				header('Location: profile.php?username='.$userid);
                        } else {
                                die('Incorrect password!');
                        }
                }
                
        
}
else {
       	die('Not logged in');
}
?>

<h1>Write a Post and/or Mention the Path of an Image you want to Share</h1>

<form action="post.php" method="post">
	<input type="password" name="password" value="" placeholder="Password ..."><p />
        <textarea name="postbody" rows="8" cols="80"></textarea>
	<input type="text" name="image" value="" placeholder="Path to image ..."><p />
        <input type="submit" name="post" value="Post">
</form>
