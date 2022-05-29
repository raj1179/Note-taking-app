<?php

	$db_host = "localhost";
	$db_user = "rmw462";
	$db_pwd = "sql2022CS215";
	$db_db = "rmw462";
	$chars = "utf8mb4";
	$attr = "mysql:host=$db_host;dbname=$db_db;charset = $chars";
	$opts =[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
	];

?>