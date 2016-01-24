<?php
	session_start();

	//Check for p="display".  If true, display results only

	$display_only = FALSE;
	$survey_done = FALSE;
	$already_voted = FALSE;

	if(isset($_GET['p'])) //Use GET in <a> link
	{

		if($_GET['p']=="destroy")
		{
			echo "Killing Session";
			session_destroy();
			exit();
		}

		//Insert code to read file
		$display_only = TRUE;

		//Read file, build results
		if(file_exists("results.txt"))
		{
			$newFile = FALSE;

			//Read file contents into Results[] array;
			$myFile = fopen("results.txt", "r");
				
			for($i=0; $i<=11; $i++)
			{
				$Results[$i] = fgets($myFile);
			}
			fclose($myFile);
		}
		else  //File does not exist
		{
			$newFile = TRUE;
			//Create file, initialize array to all zeroes.
			$myFile = fopen("results.txt", "w");
			fclose($myFile);
			for($i=0; $i<=11; $i++)
				$Results[$i]="0\n";
		}
	}	

	if($_SERVER['REQUEST_METHOD']=='POST') //If form has been posted
	{
		//$president=$_REQUEST['president'];
		//if(isset($president))
			//session_destroy();

		if(isset($_SESSION['survey_done']))
		{		
			$already_voted = TRUE;
			$survey_done = TRUE;
			
			//Read file, build results
			if(file_exists("results.txt"))
			{
				$newFile = FALSE;

				//Read file contents into Results[] array;
				$myFile = fopen("results.txt", "r");
				
				for($i=0; $i<=11; $i++)
				{
					$Results[$i] = fgets($myFile);
				}
				fclose($myFile);
			}
		else  //File does not exist
		{
			$newFile = TRUE;
			//Create file, initialize array to all zeroes.
			$myFile = fopen("results.txt", "w");
			fclose($myFile);
			for($i=0; $i<=11; $i++)
				$Results[$i]="0\n";
		}
	}
	else //First time voting
	{
		$error_msg = NULL;
		if(!empty($_REQUEST['president']))
		{
			$president=$_REQUEST['president'];
		}
		else
		{
			$president=NULL;
			$error_msg="You must select a President<br/>";
		}
				
		if(!empty($_REQUEST['issue']))
		{
			$issue=$_REQUEST['issue'];
		}
		else
		{
			$issue=NULL;
			$error_msg.="You must select an Issue<br/>";
		}

		if(!empty($_REQUEST['spending']))
		{
			$spending=$_REQUEST['spending'];
		}
		else
		{
			$spending=NULL;
			$error_msg.="You must select spending<br/>";
		}

		if(!empty($_REQUEST['least']))
		{
			$least=$_REQUEST['least'];
		}
		else
		{
			$least=NULL;
			$error_msg.="You must select the least important issue<br/>";
		}

		if($president && $issue && $spending && $least)
		{
			$_SESSION['survey_done']=TRUE;
			$survey_done = TRUE;
				
			unset($Results);
			//Write out voting, build result
			if(file_exists("results.txt"))
			{
				$newFile = FALSE;

				//Read file contents into Results[] array;
				$myFile = fopen("results.txt", "r");
					
				for($i=0; $i<=11; $i++)
				{
					$Results[$i] = fgets($myFile);
				}
				fclose($myFile);
			}
			else  //File does not exist
			{
				$newFile = TRUE;
				//Create file, initialize array to all zeroes.
				$myFile = fopen("results.txt", "w");
				fclose($myFile);

				for($i=0; $i<=11; $i++)
					$Results[$i]="0\n";
			}

			//Add voting results
			switch($president)
			{
				case 'Donald':
					$newVal = $Results[0];
					$newVal+=1;
					$Results[0] = "$newVal" . "\n";
				break;
				case 'Hillary':						
					$newVal = $Results[1];
					$newVal+=1;
					$Results[1] = "$newVal" . "\n";
				break;
				case 'Bernie':
					$newVal = $Results[2];
					$newVal+=1;
					$Results[2] = "$newVal" . "\n";
				break;
			}

			switch($issue)
			{
				case 'Warming':
					$newVal = $Results[3];
					$newVal+=1;
					$Results[3] = "$newVal" . "\n";
				break;
				case 'Syria':						
					$newVal = $Results[4];
					$newVal+=1;
					$Results[4] = "$newVal" . "\n";
				break;
				case 'Iran':
					$newVal = $Results[5];
					$newVal+=1;
					$Results[5] = "$newVal" . "\n";
				break;
			}


			switch($spending)
			{
				case 'SOS':
					$newVal = $Results[6];
					$newVal+=1;
					$Results[6] = "$newVal" . "\n";
				break;
				case 'SSA':						
					$newVal = $Results[7];
					$newVal+=1;
					$Results[7] = "$newVal" . "\n";
				break;
				case 'Healthcare':
					$newVal = $Results[8];
					$newVal+=1;
					$Results[8] = "$newVal" . "\n";
				break;
			}

			switch($least)
			{
				case 'Trump':
					$newVal = $Results[9];
					$newVal+=1;
					$Results[9] = "$newVal" . "\n";
				break;
				case 'Clinton':						
					$newVal = $Results[10];
					$newVal+=1;
					$Results[10] = "$newVal" . "\n";
				break;
				case 'Cruz':
					$newVal = $Results[11];
					$newVal+=1;
					$Results[11] = "$newVal" . "\n";
				break;
			}


			//Write to file
			$myFile = fopen("results.txt", "w");
			$value = "";
			for($i=0; $i<=11; $i++)
			{
				if($newFile)
					$value.=$Results[$i];
				else
					$value.=$Results[$i];
			}

			fwrite($myFile, $value);
			fclose($myFile);
				
			$results_string = "Voting Complete.  Display Results";
		}
		else
		{
			echo $error_msg . "<br/>";
			echo "Please complete the survey<br/>";
		}
	}
}

if($display_only || $survey_done || $already_voted)
{
	if($display_only)
		echo "<h1>Survey Results ... If you haven't voted, please vote now!</h1>";
	elseif($already_voted)
	{
		echo "<h1>You have already voted, thank you!</h1>";
		echo "<h1>Survey Results:</h1>";
	}
	else
		echo "<h1>Survey Results</h1>";
	echo "<b>Worst President Results:</b><br/>";
	echo "Donald Trump: " . $Results[0] . "<br/>";
	echo "Hllary Clinton: " . $Results[1] . "<br/>";
	echo "Bernie Sanders: " . $Results[2] . "<br/><br/>";

	echo "<b>Least Controversial Issue Results:</b><br/>";
	echo "Global Warming: " . $Results[3] . "<br/>";
	echo "Syrian Refugees: " . $Results[4] . "<br/>";
	echo "Being Iran's BFF: " . $Results[5] . "<br/><br/>";

	echo "<b>Most Pitiful Spending Results:</b><br/>";
	echo "Investigating Hillary: " . $Results[6] . "<br/>";
	echo "Protecting Social Security: " . $Results[7] . "<br/>";
	echo "Investing Billions on Healthcare: " . $Results[8] . "<br/><br/>";

	echo "<b>Least Important Issue Results:</b><br/>";
	echo "Donald Trump's Hair: " . $Results[9] . "<br/>";
	echo "Bill Clinton's Past: " . $Results[10] . "<br/>";
	echo "Ted Cruz Birthplace: " . $Results[11] . "<br/><br/>";
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
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<fieldset><legend>Please answer the following questions.  Make only one selection for each question.</legend>
		
		<!-- Create Radio Button -->
			<p><label for="president">Who would make the worst possible President? </label><br/>
				<input type="radio" name="president" value="Donald" <?php if(isset($_REQUEST['president']) && $_REQUEST['president']=="Donald") echo "checked"?>/>    Donald Trump<br/>
				<input type="radio" name="president" value="Hillary" <?php if(isset($_REQUEST['president']) && $_REQUEST['president']=="Hillary") echo "checked"?>/>    Hillary Clinton<br/>
				<input type="radio" name="president" value="Bernie" <?php if(isset($_REQUEST['president']) && $_REQUEST['president']=="Bernie") echo "checked"?>/>    Bernie Sanders<br/>
			</p>
				<p><label for="issue">What is the least controversial issue? </label><br/>
				<input type="radio" name="issue" value="Warming" <?php if(isset($_REQUEST['issue']) && $_REQUEST['issue']=="Warming") echo "checked"?>/>    Global Warming<br/>
				<input type="radio" name="issue" value="Syria" <?php if(isset($_REQUEST['issue']) && $_REQUEST['issue']=="Syria") echo "checked"?>/>    Syrian Refugees<br/>
				<input type="radio" name="issue" value="Iran" <?php if(isset($_REQUEST['issue']) && $_REQUEST['issue']=="Iran") echo "checked"?>/>    Being Iran's BFF<br/>
			</p>

			<p><label for="issue">What is the most pitiful spending of taxpayer dollars? </label><br/>
				<input type="radio" name="spending" value="SOS" <?php if(isset($_REQUEST['spending']) && $_REQUEST['spending']=="SOS") echo "checked"?>/>    Investigating Hillary Clinton<br/>
				<input type="radio" name="spending" value="SSA" <?php if(isset($_REQUEST['spending']) && $_REQUEST['spending']=="SSA") echo "checked"?>/>    Protecting Social Security from Bankruptcy<br/>
				<input type="radio" name="spending" value="Healthcare" <?php if(isset($_REQUEST['spending']) && $_REQUEST['spending']=="Healthcare") echo "checked"?>/>    Investing billions to undo the billions spent on healthcare<br/>
			</p>

			<p><label for="issue">What is the least important issue in the 2016 election? </label><br/>
				<input type="radio" name="least" value="Trump" <?php if(isset($_REQUEST['least']) && $_REQUEST['least']=="Trump") echo "checked"?>/>    Donald Trump's Hair<br/>
				<input type="radio" name="least" value="Clinton" <?php if(isset($_REQUEST['least']) && $_REQUEST['least']=="Clinton") echo "checked"?>/>    Bill Clinton's Past<br/>
				<input type="radio" name="least" value="Cruz" <?php if(isset($_REQUEST['least']) && $_REQUEST['least']=="Cruz") echo "checked"?>/>    Ted Cruz was born in Canada<br/>
			</p>				
		</fieldset>
			<!-- Submit Button -->
		<p align="center"><input type="submit" name="submit" value="Submit Answers"/></p>		
		</form>
			<a href="handle_form.php?p=display" title="Survey Results Only">Click Here to View Results without Voting</a>
	</body>
</html>