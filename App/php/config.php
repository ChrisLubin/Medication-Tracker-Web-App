<?php
// Be sure to use $db->close(); at the end of each php file that includes this!

$dbhost = 'localhost';
$dbname = ''; // FAU username
$dbuser = ''; // FAU username
$dbpass = ''; // FAU LAMP password

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if($db->connect_errno > 0) {
   die('Unable to connect to database [' . $db->connect_error . ']');
}
?>