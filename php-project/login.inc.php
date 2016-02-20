<?php
	session_start();

	$errorMessage=NULL;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        
		$e=TRUE;
		$p=TRUE;

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
					  WHERE email=:email';

		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':email', $email);
		  	$statement->execute();
		  	
		  	$users = $statement->fetch();
		  	$statement->closeCursor();

		  	if($users==FALSE ) //Invalid login
		  	{
		  		$errorMessage = "Invalid Credentials!";
		  	}
		  	else //Valid login
		  	{
		  		$verified = password_verify($password, $users['password']);
		  		if($verified)
		  		{
				  	echo "ID: " . $users['acct_id'] . "<br/>";
				  	echo "User Name: " . $users['username'] . "<br/>";
				  	echo "Password: " . $users['password'] . "<br/>";
					
					//Store retrieved values in $_SESSION
					$_SESSION['acct_id'] = $users['acct_id'];
					$_SESSION['first_name'] = $users['first_name'];
					
					$url='index.php';
					header("Location: $url");
					exit();
		  		}
		  		else
		  		{
		  			$errorMessage = "Invalid Credentials!";
		  		}			  		
		  	}
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
			        <label class="label" for="email"><b>Email Address:</b></label>
			        <input type="text" name="email" size="30" maxlength="60"/>
			        <br/>
			        <label class="label" for="pass"><b>Password:</b></label>
			        <input type='password' name="pass" size="30" maxlength="20"/>
			        <br/><br/>
			        <div align="center"><input type="submit" class="submitLoginSpec" name="submit" value="Login"/></div>
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
