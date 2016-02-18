<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Lesson 7 Home Page</title>
		<meta charset="utf-8"/>
		<link href="includes/styles.css" rel="stylesheet" type="text/css" media="screen"/>
	</head>

	<body>
		<div class="container">
			<div id="myHeader">
				<h1 id="myLogo">Paul Merideth</h1>
				<p id="myLogo">Home Page</p>
			</div>
			<div id="menu">
				<?php
					if(!isset($_SESSION['acct_id'])) //User not logged in
					{
						echo '<a href="signin.php" title="Please Sign In" class="logInPage">Click Here to Sign In</a>';	
					}
					else //User logged in
					{
						echo '<p class="welcome">Welcome ' . $_SESSION['username'] . "</p>";
						echo '<a href="signout.php" title="Sign Out" class="submitFamilyPics">Sign Out</a><br/>';
					}
				?>
			</div>
		</div>
	</body>
</html>
