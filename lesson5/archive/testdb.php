<?php 
function test() {
	$server  = 'localhost';
	$database = 'cs313test';
	$username = 'admin';
	$password = 'loga2872';
	$dsn = 'mysql:host='.$server.';dbname='.$database;
	$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

		$g1db = new PDO($dsn, $username, $password, $options);

		echo "Just called PDO function";

		echo $gldb;

		return $g1db;
}

echo "pre test()";

$test = test();

$scriptureOutput = viewScriptures();

echo "IS this working?";

echo $scriptureOutput;


function viewScriptures() {
    global $test;
    $query = 'SELECT * FROM scriptures
              ORDER BY id';
    $statement = $test->prepare($query);
    $statement->execute();
    return $statement;
}
?>
<h1></h1>