<?php # signin.php for lesson 7
		/* This is the main page.
		 * It includes the config.inc.php file, the templates,
		 * and any content-specific modules.
		 * This is the "bootstrap" file.  All activity routes thru this file.
		 * It is the only file that is ever loaded in the web browser.
		 */
	session_start();

	require('includes/database.php');
	require('password.php');

	$errorMessage=NULL;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        
		$e=TRUE;
		$p=TRUE;

		if(empty($_POST['username']))
		{
			$e=FALSE;
			$errorMessage.="Please enter a Username. ";
		}

		if(empty($_POST['pass']))
		{
			$p=FALSE;
			$errorMessage .= "Please enter a password";
		}

		//If email and pass are both valid, retrieve user info
		if($e && $p)
		{            
			//echo "Email = " . $_POST['email'] . "<br/>";
			//echo "PW = " . $_POST['pass'] . "<br/>";

			$username = $_POST['username'];
			$password = $_POST['pass'];

			$passwordHash = password_hash($password, PASSWORD_DEFAULT);

			$query = 'INSERT INTO users
				(username, password)
					VALUES 
					(:username, :password)';

		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':username', $username);
		  	$statement->bindValue(':password', $passwordHash);
		  	$statement->execute();		  	
		  	$statement->closeCursor();

			$url='signin.php';
			header("Location: $url");
			exit();
	  	}
	} //End of submit IF    
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Lesson 7 Sign Up Page</title>
		<meta charset="utf-8"/>
		<link href="includes/styles.css" rel="stylesheet" type="text/css" media="screen"/>
	</head>

	<body>
		<div class="container">
			<div id="myHeader">
				<h1 id="myLogo">Paul Merideth</h1>
				<p id="myLogo">Account Sign Up</p>
			</div>

			<!-- Display HTML Form -->
			<h1 class="loginTitle">Login to Account</h1>
			<form action="signup.php" method="post">
				<fieldset class="myFieldSet"><legend>Please Enter Desired Credentials</legend>
			        <label class="label" for="email"><b>Username:</b></label>
			        <input type="text" name="username" size="30" maxlength="60"/>
			        <br/>
			        <label class="label" for="pass"><b>Password:</b></label>
			        <input type='password' name="pass" size="30" maxlength="20"/>
			        <br/><br/>
			        <div align="center"><input type="submit" class="submitLoginSpec" name="submit" value="Submit"/></div>
				</fieldset>
		        <div align="center">			        	
		        	<a href="signup.php" title="Sign Up" class="submitFamilyPics">Sign Up Page</a>
		        </div>			        
				<?php
					if($errorMessage)
					{
						echo '<p class="errorMessage">ERROR: ' . $errorMessage . "<br/>";
					}
				?>
			</form>
		</div>
	</body>
</html>
