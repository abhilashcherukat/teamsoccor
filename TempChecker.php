<?php

$realtime = $argv[1];

date_default_timezone_set('Asia/Calcutta');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cracker";

//database connection details
$connect = mysqli_connect($servername, $username, $password);

if (!$connect) {
    die('Could not connect to MySQL: ' . mysqli_error());
}
//your database name
$cid = mysqli_select_db($dbname, $connect);

$query = "update realtime_controls set realtime=".$realtime;
echo $query;

$result = mysqli_query($query, $connect) or die(mysqli_error()); 
echo $result;
//echo "Table updated with flag : " . $realtime; exit;

?>

