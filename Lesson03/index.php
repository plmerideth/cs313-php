<?php
	session_start();

	if(!isset($_SESSION['survey_done']))
	{
		echo "Index: Session Variable not set!";
	}
	else
	{
		echo "Index: Session variable previously set";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Lesson 3 - PHP Survey</title>
		<meta charset="utf-8"/>
	</head>
	<body>
		<h1>Welcome to the Pitiful Presidential Survey</h1>
		<form action="handle_form.php" method="post">
		<fieldset><legend>Please answer the following questions.  Make only one selection for each question.</legend>
		
			<!-- Create Radio Button -->
			<p><label for="president">Who would make the worst possible President? </label><br/>
				<input type="radio" name="president" value="Donald" <?php /* if(isset($_REQUEST['president']) && $_REQUEST['president']=="Donald")* echo "checked" */?>/>    Donald Trump<br/>
				<input type="radio" name="president" value="Hillary"/>    Hillary Clinton<br/>
				<input type="radio" name="president" value="Bernie"/>    Bernie Sanders<br/>
			</p>

			<?php echo "REQUEST[president] = " . $_REQUEST['president'] . "<br/>";
			      echo "POST[president] = " . $_POST['president']; ?>

			<p><label for="issue">What is the least important issue? </label><br/>
				<input type="radio" name="issue" value="Warming"/>    Global Warming<br/>
				<input type="radio" name="issue" value="Syria"/>    Syrian Refugees<br/>
				<input type="radio" name="issue" value="Iran"/>    Being Iran's BFF<br/>
			</p>


			<p><label for="issue">What is the most pitiful spending burning taxpayer dollars? </label><br/>
				<input type="radio" name="spending" value="Hillary"/>    Investigating Hillary Clinton<br/>
				<input type="radio" name="spending" value="SSA"/>    Protecting Social Security from Bankruptcy<br/>
				<input type="radio" name="spending" value="Healthcare"/>    Investing billions to undo the billions spent on health care<br/>
			</p>
		</fieldset>

		<!-- Submit Button -->
		<p align="center"><input type="submit" name="submit" value="Submit Answers"/></p>		
		</form>

		<a href="handle_form.php?p=display" title="Survey Results Only">Click Here to View Results without Voting</a>
	</body>
</html>