<?php
  date_default_timezone_set('UTC');

  $db_hostname = ''; //Set the host IP address (or localhost)
  $db_database = ''; //Set the database name e.g. threads
  $db_username = ''; //Set the username (user must have permission to write to database)
  $db_password = ''; //Set the password

  global $connection;
  $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
  if ($connection->connect_error) die($connection->connect_error);

  function queryMySQL($query)
  {
    global $connection;
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    return $result;
  }
  function insertID(){
    global $connection;
    $result = $connection->insert_id;
    if (!$result) die($connection->error);
    return $result;
  }
  function sanitizeString($var)
	{
		global $connection;
		$var = strip_tags($var);
		$var = htmlentities($var);
		//$var = stripslashes($var);
		return $connection->real_escape_string($var);
	}
?>
