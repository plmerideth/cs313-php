<?php


loadDatabase();

function loadDatabase()
{
	$dbHost = "";
	$dbPort = "";
	$dbUser = "";
	$dbPassword = "";

	$dbName = "cs313";

	$openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

	if($openShiftVar == null || $openShiftVar == "")
	{
		//Not in OpenShift environment
		echo "Using MY LOCAL credentials<br/><br/>";

		require("setLocalDatabaseCredentials.php");
	}
	else
	{
		//In OpenShift environment
		echo "Using OpenShift Credentials";

		$dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
		$dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT');
		$dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
		$dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
	}

	echo "host:$dbHost:$dbPort  dbName:$dbName  User: $dbUser  Password: $dbPassword<br/>\n";

	try
	{
		$db = new PDO("mysql:host=$dbHost; dbPort=$dbPort; dbname=$dbName", $dbUser, $dbPassword);
	} catch (Exception $e)
	{
		$error_message = $e->getMessage();
		echo "<p>Error Message: $error_message </p>";
	}
	
	return $db;
}

?>