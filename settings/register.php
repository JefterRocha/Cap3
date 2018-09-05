<?php
	include_once 'Database.class.php';

	// Define configuration
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'libras');

	$json = json_decode(file_get_contents('php://input'));

	$database = new Database();
	foreach ($json->topics as $key => $value) {
		$database->query('INSERT INTO register VALUES (:topicId, :topicNumber, :owner, :selected)');
		$database->bind(':topicId', NULL);
		$database->bind(':topicNumber', $value);
		$database->bind(':owner', $json->name);
		$database->bind(':selected', true);
		$database->execute();
	}
	/*  */

	echo json_encode($json)
?>