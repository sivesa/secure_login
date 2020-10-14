<?php

include 'database.php';

echo "user: " . $DB_USER  . PHP_EOL;
echo "host: " . $DB_DSN . PHP_EOL;

try {
	$init = new PDO("mysql:host=$DB_DSN;", $DB_USER, $DB_PASSWORD);
	$init->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql_query1 = "CREATE DATABASE IF NOT EXISTS abantu;";
	$init->exec($sql_query1);
	echo "Database created successfully" . PHP_EOL;
} 
catch (PDOException $e) {
	echo "Error: " . $sql_query1 . "<br>" . $e->getMessage();
}
$init = null;

$sql_query2 = "CREATE TABLE IF NOT EXISTS abantu ("
. "uid int NOT NULL AUTO_INCREMENT,"
. "fname varchar(50),"
. "lname varchar(50),"
. "email varchar(50),"
. "password varchar(255),"
. "PRIMARY KEY (uid));";

try {
	$conn = new PDO("mysql:host=$DB_DSN;dbname=abantu", $DB_USER, $DB_PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec($sql_query2);
	echo "Table yabantu and attributes created successfully" . PHP_EOL;
} 
catch (PDOException $e) {
	echo "Error: " . $sql_query2 . "<br>" . $e->getMessage();
}
$conn = null;

?>
