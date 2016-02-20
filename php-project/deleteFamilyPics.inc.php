<?php
	session_start();

	global $pics;
	$pics = FALSE;
	$fileDeleted = FALSE;
	$newComment = FALSE;
	$fileNotFound = FALSE;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$filename = $_POST['filename'];
//echo "Filename = $filename <br/>";
//echo "Category = $category <br/>";
//exit();

		//Delete pic
		try
		{

			//Select all rows with filename to get pic_id
			$query = 'SELECT * FROM pics							
						WHERE
							filename = :filename';					  
		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':filename', $filename);		  	
		  	$statement->execute();
		  	$deletePics = $statement->fetch();
		  	$statement->closeCursor();
		  	if(!$deletePics)
		  		$fileNotFound = TRUE;
		  	else
		  		$pic_ID = $deletePics['pic_id'];
		} catch(PDOException $e)
		{
			$errorMessage = $e->getMessage();
			echo "<p>Database Error: $errorMessage </p>";
			exit();
		}

		if($fileNotFound==FALSE)
		{
			try
			{
				//Delete all comments with pic_id
				$query = 'DELETE FROM comments							
							WHERE
								pic_id = :pic_id';					  
			  	$statement = $db->prepare($query);
			  	$statement->bindValue(':pic_id', $pic_ID);		  	
			  	$statement->execute();
			  	$statement->closeCursor();
			}catch(PDOException $e)
			{
				$errorMessage = $e->getMessage();
				echo "<p>Database Error: $errorMessage </p>";
				exit();
			}

			try
			{
				$query = 'DELETE FROM pics							
							WHERE
								filename = :filename';
			  	$statement = $db->prepare($query);
			  	$statement->bindValue(':filename', $filename);		  			  	
			  	$statement->execute();
			  	$statement->closeCursor();

				$fileDeleted = TRUE;
			}catch(PDOException $e)
			{
				$errorMessage = $e->getMessage();
				echo "<p>Database Error: $errorMessage </p>";
				exit();
			}			
		}
	} //End of submit IF
    
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Delete Pictures</title>
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
			<h1 class="loginTitle">Delete Family Pictures</h1>
			<form action="index.php?p=deleteFamilyPics" method="post">
				<fieldset class="myFieldSet"><legend>Please enter name of file to delete</legend>
			        <label class="inputText" for="filename"><b>FileName:</b></label>
			        <input type="text" name="filename" size="30" maxlength="60"/>
			        <br/>
			        <input type="submit" class="submitLoginSpec" name="submit" value="Submit"/>
				</fieldset>				
				<?php
					 if($fileDeleted)				
					 	echo '<p class="newFileMsg">The file ' . $filename . " has been successfully deleted!</p>";
					 if($fileNotFound)
					 	echo '<p class="newFileMsg">The file ' . $filename . " was not found in the database!</p>";
				?>	
		        <div align="center">		        	 
		        	<a href="index.php?p=displayFamilyPics" title="Home" class="submitFamilyPics">Cancel</a>
		        </div>
			</form>
		</div>
	</body>
</html>
