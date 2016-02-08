<?php
	session_start();

	global $pics;
	$pics = FALSE;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        

		$category = $_POST['cat'];

		$query = 'SELECT *
				  FROM pics';
		if($category != "All")
		{
			$query .= ' WHERE category=:category';
		}				 

	  	$statement = $db->prepare($query);
	  	$statement->bindValue(':category', $category);	  	
	  	$statement->execute();
		  	
	  	$pics = $statement->fetchAll();
	  	$statement->closeCursor();

	  	if($pics == FALSE) //Invalid login
	  	{
	  		$errorMessage = "No pictures found!";
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
			<h1 class="loginTitle">Family History Pictures</h1>
			<form action="index.php?p=displayFamilyPics" method="post">
				<fieldset class="myFieldSet"><legend>Please Select a Category</legend>
			        <select name="cat">
			        	<option value="All">All</option>
			        	<option value="Smith">Smith</option>
			        	<option value="Jones">Jones</option>
			        	<option value="1900">1900</option>
			        	<option value="2000">2000</option>
			  		</select>
			        <br/>
			        <div align="center">
			        	<input type="submit" class="submitLoginSpec" name="submit" value="Submit"/>
			        	<a href="index.php" title="Home" class="submitLogin">Home Page</a>
			        </div>
			        
				</fieldset>				
			</form>

			<?php
				if($pics)
				{
					echo '<h2 class="categoryTitle">Category = ' . $category . "</h2>";
					echo "<table>
							<tr>
								<th>Pic ID</th>
								<th>Filename</th>
								<th>Date/Time</th>
								<th>Acct ID</th>
							</tr>";
				  	foreach($pics as $pic) :
				  		echo '<tr>
				  				<td>' . $pic['pic_id'] . '</td>
				  				<td>' . $pic["filename"] . '</td>
				  				<td>' . $pic["datetime"] . '</td>
				  				<td>' . $pic["acct_id"] . '</td>
				  			</tr>';
				  	endforeach;
				}
			?>
		</div>
	</body>
</html>
