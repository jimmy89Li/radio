<?php

$mysqli = new mysqli('mysql', getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'), getenv('MYSQL_PORT'));

if($mysqli->connect_error) {
  echo 'Connection Error: ' . $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
} else {
  echo 'Connected succesfully!';
}