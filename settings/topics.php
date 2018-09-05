<?php
	include_once 'Database.class.php';

	// Define configuration
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'libras');

	$database = new Database();
	$database->query('SELECT topic_number, owner, selected FROM register');
	$topics = $database->resultset();

	echo json_encode($topics)
?>