<?php
	session_start();

	$errorMessage=NULL;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        
		$f=TRUE;
		$l=TRUE;
		$e=TRUE;
		$p=TRUE;

		if(empty($_POST['firstname']))
		{
			$f=FALSE;
			$errorMessage.="You must enter a first name. ";
		}

		if(empty($_POST['lastname']))
		{
			$l=FALSE;
			$errorMessage.="You must enter a last name. ";
		}

		if(empty($_POST['email']))
		{
			$e=FALSE;
			$errorMessage.="You must enter an Email address. ";
		}

		if(empty($_POST['pass']))
		{
			$p=FALSE;
			$errorMessage .= "You must enter your password";
		}

		//If email and pass are both valid, retrieve user info
		if($f && $l && $e && $p)
		{            
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$email = $_POST['email'];
			$password = $_POST['pass'];
			$passwordHash = password_hash($password, PASSWORD_DEFAULT);

			date_default_timezone_set("America/Denver");
			$datetime = date('Y-m-d H:i:s');

			$query = 'INSERT INTO accounts
				(first_name, last_name, email, password, datetime)
					VALUES 
					(:firstname, :lastname, :email, :password, :datetime)';

		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':firstname', $firstname);
		  	$statement->bindValue(':lastname', $lastname);
		  	$statement->bindValue(':email', $email);
		  	$statement->bindValue(':password', $passwordHash);
		  	$statement->bindValue(':datetime', $datetime);		  	
		  	$statement->execute();		  	
		  	$statement->closeCursor();

			$url='index.php';
			header("Location: $url");
			exit();
		}
	} //End of submit IF    
?>


<!DOCTYPE html>
<html>
	<head>
		<title>PHP Project Registration Page</title>
		<meta charset="utf-8"/>
		<link href="includes/styles.css" rel="stylesheet" type="text/css" media="screen"/>
	</head>

	<body>
		<div class="container">
			<div id="myHeader">
				<h1 id="myLogo">Paul Merideth</h1>
				<p id="myLogo">Family History Photos - Registration</p>
			</div>

			<!-- Display HTML Form -->
			<h1 class="loginTitle">Register for Family History Pictures</h1>
			<form action="index.php?p=register" method="post">
				<fieldset class="myFieldSet"><legend>Please Enter Desired Login Credentials</legend>
					<label class="label" for="firstname"><b>First Name:</b></label>
			        <input type="text" name="firstname" size="30" maxlength="60"/>
			        <br/>			        
					<label class="label" for="lastname"><b>Last Name:</b></label>
			        <input type="text" name="lastname" size="30" maxlength="60"/>
			        <br/>
			        <label class="label" for="email"><b>Email Address:</b></label>
			        <input type="text" name="email" size="30" maxlength="60"/>
			        <br/>
			        <label class="label" for="pass"><b>Password:</b></label>
			        <input type='password' name="pass" size="30" maxlength="20"/>			        
			        <br/><br/>
			        <div align="center"><input type="submit" class="submitLoginSpec" name="submit" value="Submit"/></div>
				</fieldset>
		        <div align="center">			        	
		        	<a href="index.php" title="Home" class="submitFamilyPics">Home Page</a>
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
