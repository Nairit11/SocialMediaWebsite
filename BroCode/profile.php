<?php
include('./classes/DB.php');
include('./classes/Login.php');

$username = "";
$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT user_id FROM user WHERE user_id=:username', array(':username'=>$_GET['username']))) {
                $username = DB::query('SELECT name FROM user WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['name'];
                $userid = DB::query('SELECT user_id FROM user WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['user_id'];
                $followerid = Login::isLoggedIn();
		
                if (isset($_POST['follow'])) {
                        if ($userid != $followerid) {
                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        DB::query('INSERT INTO followers (user_id, follower_id) VALUES (:userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
					DB::query('UPDATE userDetails SET following = following+1 WHERE user_id=:followerid', array(':followerid'=>$followerid));
					DB::query('UPDATE userDetails SET followers = followers+1 WHERE user_id=:userid', array(':userid'=>$userid));
                                } else {
                                        echo 'Already following!';
                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {
                        if ($userid != $followerid) {
                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
					DB::query('UPDATE userDetails SET following = following-1 WHERE user_id=:followerid', array(':followerid'=>$followerid));
					DB::query('UPDATE userDetails SET followers = followers-1 WHERE user_id=:userid', array(':userid'=>$userid));
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid', array(':userid'=>$userid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }
	 	$dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";
                
        } else {
                die('User not found!');
        }
}
?>

<html>
<head>
<title>Profile Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Elegant Profile Tabs Widget Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //custom-theme -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="js/jquery.min.js"></script>
<!-- //js --> 
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<link rel="stylesheet" href="css/easy-responsive-tabs.css">
<link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext" rel="stylesheet">
<script src="js/easy-responsive-tabs.js"></script>
</head>
<body>
	<div class="main">
		<h1>WELCOME TO BRO CODE</h1>
		<div class="w3_main_grids">
			<div class="w3layouts_profile_grid1">
				<div class="w3l_profile_grid1_padd">
					<div class="w3ls_menu_grids">
						<div class="w3ls_menu_grid">
							<span class="menu-icon">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</span>
							<!-- menu -->
								<ul class="w3_agile_nav1">
									<li><a href="changePassword.php">Change Password</a></li>
									<li><a href="update.php">Update Details</a></li>
									<li><a href="logout.php">Log Out</a></li>
								</ul> 	
								<!-- script-for-menu -->
								 <script>
								   $( "span.menu-icon" ).click(function() {
									 $( "ul.w3_agile_nav1" ).slideToggle( 300, function() {
									 // Animation complete.
									  });
									 });
								</script>
								<!-- /script-for-menu -->
							<!-- //menu -->
						</div>
						<div class="w3ls_menu_grid">
							<h2><?php echo $username; ?></h2>
						</div>
					
						<div class="clear"> </div>
					</div>
				</div>
			</div>
			<div class="agileinfo_profile_grid2">
				<div class="w3_agile_profile_grid2_left">
				<img src="<?php echo DB::query('SELECT profilePic FROM userDetails WHERE user_id=:userid', array(':userid'=>$userid))[0]['profilePic'] ?>" alt="" class="img-responsive" />
				</div>
				<div class="agile_profile_grid2_left">
					<?php
					if ($userid != $followerid) {
					echo '<form action="profile.php?username='.$userid.'" method="post">';
						
        						
                						if ($isFollowing) {
                        						echo '<input type="submit" name="unfollow" value="Unfollow">';
                						} else {
                        						echo '<input type="submit" name="follow" value="Follow">';
                						}
        						
        					
					echo '</form>';
					} else{
						echo '<form action="post.php" method="post">';
                        						echo '<input type="submit" name="Post" value="Post">';
                				echo '</form>';
					
					}					
					?>
				</div>
				<div class="clear"> </div>
				<p><?php echo $userid; ?> - <?php echo $username; ?></p>
			</div>
			<div class="wthree_tabs">
				<div id="horizontalTab">
					<ul class="resp-tabs-list">
						<li>Posts</li>
						<li>Follwers</li>
						<li>Contact Details</li>
					</ul>
					<div class="resp-tabs-container">
						<div class="agileinfo_tab1">
							<ul>
								<?php

								foreach($dbposts as $p) {
                        						echo '<li><i class="fa fa-comments-o agileits_comment" aria-hidden="true"></i><span>'.htmlspecialchars($p['posted_at']).'</span>'.htmlspecialchars($p['text']).'<img src="images/2.jpg" alt=" " class="img-responsive w3ls_men" />';
									if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid', array(':userid'=>$userid))){
									echo '<form action="profile.php?username='.$username.'" method="post">
                                					<input type="submit" name="like" value="Like">
                        						</form>';}
								echo '</li>';
									
                						}
								
								?>
							</ul>
						</div>
						<div class="agileinfo_tab2">
							<div class="wthree_tab_grid">
								
								<div class="wthree_tab_grid_sub">
									<div class="wthree_tab_grid_sub_left">
										<h5><?php echo DB::query('SELECT followers FROM userDetails WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['followers'];  ?></h5>
										<p>Followers</p>
									</div>
									<div class="wthree_tab_grid_sub_left">
										<h5><?php echo DB::query('SELECT following FROM userDetails WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['following'];  ?></h5>
										<p>Following</p>
									</div>
									<div class="clear"> </div>
								</div>
							</div>
						</div>
						
						<div class="agileinfo_tab3">
							<div class="wthree_tab_grid">
								<ul class="wthree_tab_grid_list">
									<li><i class="fa fa-mobile" aria-hidden="true"></i></li>
									<li>Mobile<span><?php echo DB::query('SELECT phone FROM userDetails WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['phone'];  ?></span></li>
								</ul>
								<ul class="wthree_tab_grid_list">
									<li><i class="fa fa-envelope-o" aria-hidden="true"></i></li>
									<li>Mail Me<span><a href="mailto:<?php echo DB::query('SELECT email_id FROM user WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['email_id'];  ?>"><?php echo DB::query('SELECT email_id FROM user WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['email_id'];  ?></a></span></li>
								</ul>
								<ul class="wthree_tab_grid_list">
									<li><i class="fa fa-map-marker" aria-hidden="true"></i></li>
									<li>Address<span><?php echo DB::query('SELECT address FROM userDetails WHERE user_id=:username', array(':username'=>$_GET['username']))[0]['address'];  ?></span></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>
	<script>
		$(document).ready(function () {
			$('#horizontalTab').easyResponsiveTabs({
				type: 'default', //Types: default, vertical, accordion           
				width: 'auto', //auto or any width like 600px
				fit: true,   // 100% fit in a container
				closed: 'accordion', // Start closed if in accordion view
				activate: function(event) { // Callback function if tab is switched
				var $tab = $(this);
				var $info = $('#tabInfo');
				var $name = $('span', $info);
				$name.text($tab.text());
				$info.show();
				}
			});
		});
	</script>
	
</body>
</html>
