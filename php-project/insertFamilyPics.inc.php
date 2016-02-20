<?php
	session_start();

	global $pics;
	$pics = FALSE;
	$fileAdded = FALSE;
	$newComment = FALSE;


	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{

		$filename = $_POST['filename'];

		if(!empty($_POST['newCategory']))
		{
			$category = $_POST['newCategory'];
			$newCategory = TRUE;
		}
		else
		{
			$categoryID = $_POST['cat'];
			$newCategory = FALSE;
		}

		if(!empty($_POST['newComment']))
		{
			$comment = $_POST['newComment'];
			$newComment = TRUE;
		}


		if($newCategory)
		{
			try
			{
				$query = 'INSERT INTO categories
								(name)
							VALUES
								(:category)';
						  
			  	$statement = $db->prepare($query);
			  	$statement->bindValue(':category', $category);
			  	$statement->execute();
			  	$statement->closeCursor();
				$categoryID = $db->lastInsertId();
			} catch(PDOException $e)
			{
				$errorMessage = $e->getMessage();
				echo "<p>Database Error: $errorMessage </p>";
				exit();
			}
		}

		//Insert new pic and new comment
		try
		{
			//$datetime = time();
			date_default_timezone_set("America/Denver");
			$datetime = date('Y-m-d H:i:s');

			$query = 'INSERT INTO pics
							(filename, datetime, acct_id, cat_id)
						VALUES
							(:filename, :datetime, :acct_id, :cat_id)';
					  
		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':filename', $filename);		  	
		  	$statement->bindValue(':datetime', $datetime);
		  	$statement->bindValue(':acct_id', $_SESSION['acct_id']);
		  	$statement->bindValue(':cat_id', $categoryID);
		  	$statement->execute();
		  	$statement->closeCursor();
			$picID = $db->lastInsertId();

			$fileAdded = TRUE;

			if($newComment)
			{
				$query = 'INSERT INTO comments
								(comment, datetime, pic_id, acct_id)
							VALUES
								(:comment, :datetime, :pic_id, :acct_id)';
				$statement = $db->prepare($query);
				$statement->bindValue(':comment', $comment);
				$statement->bindValue(':datetime', $datetime);
				$statement->bindValue(':pic_id', $picID);
				$statement->bindValue(':acct_id', $_SESSION['acct_id']);
				$statement->execute();
				$statement->closeCursor();
			}	
		} catch(PDOException $e)
		{
			$errorMessage = $e->getMessage();
			echo "<p>Database Error: $errorMessage </p>";
			exit();
		}
/*		
		if($errorMessage)
		{
			echo '<p class="errorMessage">ERROR: ' . $errorMessage . "<br/>";
		}
*/
	} //End of submit IF
    
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Insert Pictures</title>
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
			<h1 class="loginTitle"><?php if(!tableHasRows("pics")) echo "Database is Empty - Please Add Pictures"; else echo "Insert Family Pictures";?></h1>
			<form action="index.php?p=insertFamilyPics" method="post">
				<fieldset class="myFieldSet"><legend>Please enter file to upload</legend>
			        <label class="inputText" for="filename"><b>FileName:</b></label>
			        <input type="text" name="filename" size="30" maxlength="60"/>
			        <br/>
			        <span class="inputTextSpec"><b>Select a Category:</b></span>
			        <select name="cat">
			        	<?php
			        		$categories=getCategories();
							foreach($categories as $picCategory)
							{
								echo '<option value=' . $picCategory['cat_id'] . '>'. $picCategory['name'] . '</option>';
							}
						?>
			  		</select>
			        <br/>
			        <p class="inputText"><b>OR</b></p>
			        <label class="inputNewCat" for="newCategory"><b>New Category:</b></label>
			        <input type="text" name="newCategory" size="30" maxlength="60"/>
			        <br/><br/>
			        <label class="inputComment" for="newComment"><b>Comments:</b></label>
			        <textarea name="newComment" cols="50" rows="3"></textarea>
			        <br/><br/>
			        <input type="submit" class="submitLoginSpec" name="submit" value="Submit"/>
				</fieldset>				
				<?php
					 if($fileAdded)				
					 	echo '<p class="newFileMsg">The file ' . $filename . " has been successfully added!</p>";
				?>	
		        <div align="center">		        	 
		        	<a href="index.php?p=displayFamilyPics" title="Home" class="submitFamilyPics">Cancel</a>
		        </div>
			</form>
		</div>
	</body>
</html>
