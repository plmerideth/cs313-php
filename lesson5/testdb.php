<?php
function test() {
	$server  = 'localhost';
	$database = 'cs313';
	$username = 'admin';
	$password = 'loga2872';
	$dsn = 'mysql:host='.$server.';dbname='.$database;
	$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);

$g1db = new PDO('mysql:host=localhost;dbname=cs313', $username, $password);
return $g1db;
}
/*
	try {
		$g1db = new PDO($dsn, $username, $password, $options);
		return $g1db;
	} 
	catch (PDOException $ex) {
        $error_message = $ex->getMessage();
        exit();
	}
}
*/



$test = test();

function viewScriptures() {
	global $test;
	$query = 'SELECT Scriptures.chapter, Scriptures.verse, Scriptures.content, Books.name
	FROM Scriptures
	INNER JOIN Books
	ON Scriptures.book_id = Books.book_id
	ORDER BY Books.name';
	$statement = $test->prepare($query);
	$statement->execute();
	$scriptures = $statement->fetchAll();
	$statement->closeCursor();
	return $scriptures;
}

function viewScripturesByBook($book_id = "-1") {
	global $test;
	if ($book_id == "-1") {
		$scriptures = viewScriptures();
	} else {
		$query = 'SELECT Scriptures.chapter, Scriptures.verse, Scriptures.content, Books.name
		FROM Scriptures
		INNER JOIN Books
		ON Scriptures.book_id = Books.book_id
		WHERE Scriptures.book_id = :book_id
		ORDER BY Books.name';
		$statement = $test->prepare($query);
		$statement->bindValue(":book_id", $book_id);
		$statement->execute();
		$scriptures = $statement->fetchAll();
		$statement->closeCursor();
	}
	return $scriptures;
}

$book = filter_input(INPUT_POST, 'book');

if (!isset($book) || $book == "all"){
	$scriptures = viewScriptures();
} else {
	$scriptures = viewScripturesByBook($book);
}
?>
<article>
	<h1>Scripture Resources</h1>
	<ul>
		<?php foreach ($scriptures as $scripture): ?>
			<li>
				<strong>
					<?php echo $scripture['name']; ?>&nbsp;
					<?php echo $scripture['chapter']; ?>:
					<?php echo $scripture['verse']; ?>
				</strong>
				 - <?php echo $scripture['content']; ?>
			</li>
		<?php endforeach; ?>
	</ul>
</article>