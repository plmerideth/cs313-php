<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Lesson 5 Home Page</title>
		<meta charset="utf-8"/>
		<link href="includes/styles.css" rel="stylesheet" type="text/css" media="screen"/>
	</head>

	<body>
		<div class="container">
			<div id="myHeader">
				<h1 id="myLogo">Paul Merideth</h1>
				<p id="myLogo">Family History Photos</p>
			</div>
			<div id="menu">
				<?php
					if(!isset($_SESSION['first_name'])) //User not logged in
					{
						echo '<a href="index.php?p=logIn" title="Please Login" class="logInPage">Click Here to Log In</a>';
						echo "<br/>";
						echo '<a href="index.php?p=register" title="Please Register" class="logInPage">Click Here to Register</a>';	
					}
					else //User logged in
					{
						echo '<p class="welcome">Welcome ' . $_SESSION['first_name'] . "</p>";
						echo '<a href="index.php?p=displayFamilyPics" title="My Family Picture Page" class="submitFamilyPics">Family History Pictures</a><br/><br/>';
						echo '<a href="index.php?p=logOut" title="Logout" class="submitFamilyPics">Logout</a><br/>';
					}
				?>
			</div>
		</div>
	</body>
</html>
