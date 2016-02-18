<?php


loadDatabase();

function loadDatabase()
{
	$dbHost = "";
	$dbPort = "";
	$dbUser = "";
	$dbPassword = "";
	global $db;

	$dbName = "cs313";

	$openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

	if($openShiftVar == null || $openShiftVar == "")
	{
		//Not in OpenShift environment
		//echo "Using MY LOCAL credentials<br/><br/>";

		require("setLocalDatabaseCredentials.php");
	}
	else
	{
		//In OpenShift environment
		//echo "Using OpenShift Credentials<br/><br/>";

		$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
		$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
		$dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
		$dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
	}

	//echo "host:$dbHost:$dbPort  dbName:$dbName  User: $dbUser  Password: $dbPassword<br/>\n";

	try
	{
		$db = new PDO("mysql:host=$dbHost; dbPort=$dbPort; dbname=$dbName", $dbUser, $dbPassword);
	} catch (Exception $e)
	{
		$error_message = $e->getMessage();
		echo "<p>Error Message: $error_message </p>";
		exit();
	}

	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $db;
}

function getCategories()
{
	global $db;
		try
		{
			$query = 'SELECT *
					  FROM categories
					  ORDER BY cat_id';

		  	$statement = $db->prepare($query);		  	
		  	$statement->execute();			  	
		  	$categories = $statement->fetchAll();

//print_r($categories);

		  	$statement->closeCursor();
		} catch(PDOException $e)
		{
			$errorMessage = $e->getMessage();
			echo "<p>Database Error: $errorMessage </p>";
			exit();
		}
	return $categories;
}

function getPics()
{
	global $db;

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
	return $pics;
}

?>