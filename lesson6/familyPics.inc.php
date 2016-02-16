<?php
	session_start();

	global $pics;
	$pics = FALSE;

	//Check for form submission
	if($_SERVER['REQUEST_METHOD']=='POST')
	{                        

		echo "POSTED";
		
		$category = $_POST['cat'];

		try
		{
			$query = 'SELECT pics.pic_id, pics.filename, pics.datetime, comments.acct_id, comments.comment, accounts.first_name, accounts.last_name, categories.name
					  FROM pics
					  LEFT OUTER JOIN comments
					  ON pics.pic_id = comments.pic_id
					  LEFT OUTER JOIN categories
					  ON pics.cat_id = categories.cat_id
					  LEFT OUTER JOIN accounts
					  ON comments.acct_id = accounts.acct_id';

			if($category != "All")
			{
				$query .= ' WHERE pics.cat_id=:category';
			}

			$query .= ' ORDER BY pics.pic_id';

		  	$statement = $db->prepare($query);
		  	$statement->bindValue(':category', $category);	  	
		  	$statement->execute();
			  	
		  	$pics = $statement->fetchAll();

		  	$statement->closeCursor();
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
			        	<?php			        		
			        		$categories=getCategories();			        		
							//$pics=getPics();
							foreach($categories as $picCategory)
							{
								echo '<option value=' . $picCategory['cat_id'] . '>'. $picCategory['name'] . '</option>';
							}
						?>
			  		</select>
			        <input type="submit" class="submitLoginSpec" name="submit" value="Submit"/>
			        <div align="center">			        	
			        	<a href="index.php" title="Home" class="submitFamilyPics">Home Page</a>
			        </div>			        
				</fieldset>				
			</form>

			<?php
				if($pics)
				{
					echo '<div class="divPicDisplay">';
						echo '<h2 class="categoryTitle">Category = ' . $category . "</h2>";
						echo '<a href="index.php?p=insertFamilyPics" title="Insert Pictures" class="submitLogin">Insert Pictures</a>';
						echo '<a href="index.php?p=deleteFamilyPics" title="Delete Pictures" class="submitLogin">Delete Pictures</a><br/><br/>';
						echo "<table>
								<tr>
									<th>Pic ID</th>
									<th>Filename</th>
									<th>Date/Time</th>
									<th>Category</th>
									<th>Comment</th>
									<th>From Acct ID</th>
									<th>Name</th>
								</tr>";
					  	foreach($pics as $pic) :
					  		echo '<tr>
					  				<td>' . $pic['pic_id'] . '</td>
					  				<td>' . $pic["filename"] . '</td>
					  				<td>' . $pic["datetime"] . '</td>
					  				<td>' . $pic["name"] . '</td>
					  				<td>' . $pic["comment"] . '</td>
					  				<td>' . $pic["acct_id"] . '</td>
					  				<td>' . $pic["first_name"] . " " . $pic["last_name"] . '</td>
					  			</tr>';
					  	endforeach;
					echo '</div>';
				}
			?>
		</div>
	</body>
</html>
