<?php
// Simple MySQL connection helper for MOONLIGHT EVENTS
// Usage:
//   require_once __DIR__ . '/db_connect.php';
//   $db = get_db();

function get_db(): mysqli {
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$name = 'moonlight_event';
	$port = 3306;

	$mysqli = new mysqli($host, $user, $pass, $name, $port);
	if ($mysqli->connect_errno) {
		http_response_code(500);
		die('Database connection failed.');
	}
	$mysqli->set_charset('utf8mb4');
	return $mysqli;
}

?>


