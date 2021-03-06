<?php
	session_start();

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        
		$e=TRUE;
		$p=TRUE;
		$errorMessage=NULL;

		if(empty($_POST['email']))
		{
			$e=FALSE;
			$errorMessage.="Please enter an Email address. ";
		}

		if(empty($_POST['pass']))
		{
			$p=FALSE;
			$errorMessage .= "Please enter your password";
		}

		//If email and pass are both valid, retrieve user info
		if($e && $p)
		{            
			//echo "Email = " . $_POST['email'] . "<br/>";
			//echo "PW = " . $_POST['pass'] . "<br/>";

			$email = $_POST['email'];
			$password = $_POST['pass'];

			$query = 'SELECT acct_id, first_name, last_name, email, password, datetime
					  FROM accounts
					  WHERE email=:email AND password=:password';

		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':email', $email);
		  	$statement->bindValue(':password', $password);
		  	$statement->execute();
		  	
		  	$users = $statement->fetchAll();
		  	$statement->closeCursor();

		  	if($users == FALSE) //Invalid login
		  	{
		  		$errorMessage = "Invalid credentials!";
		  	}
		  	else //Valid login
		  	{
			  	foreach($users as $user) :
			  		echo "ID: " . $user['acct_id'] . "<br/>";
			  		echo "First Name: " . $user['first_name'] . "<br/>";
			  		$first_name = $user['first_name'] . "<br/>";
			  		echo "Last Name: " . $user['last_name'] . "<br/>";
			  		echo "Email: " . $user['email'] . "<br/>";
			  		echo "Password: " . $user['password'] . "<br/>";
			  	endforeach;

				//Store retrieved values in $_SESSION
				$_SESSION['first_name'] = $first_name;

				$url='index.php';
				header("Location: $url");
				exit();
		  	}
		}
		
		if($errorMessage)
		{
			echo '<p class="errorMessage">ERROR: ' . $errorMessage . "<br/>";
		}
	} //End of submit IF
    
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

			<!-- Display HTML Form -->
			<h1 class="loginTitle">Login to Family History Pictures</h1>
			<form action="index.php?p=logIn" method="post">
				<fieldset class="myFieldSet"><legend>Please Enter Login Credentials</legend>
			        <label for="email"><b>Email Address:</b></label>
			        <input type="text" name="email" size="20" maxlength="60"/>
			        <br/>
			        <label for="pass"><b>Password:</b></label>
			        <input type='password' name="pass" size="20" maxlength="20"/>
			        <br/><br/>
			        <div align="center"><input type="submit" class="submitLoginSpec" name="submit" value="Login"/></div>
				</fieldset>
			</form>
		</div>
	</body>
</html>
