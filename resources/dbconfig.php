<?php
$username = "root";
$password = "";
$hostname = "localhost";

$dbhandle = mysqli_connect($hostname, $username, $password)
 or die("Unable to connect to MySQL");

$db_select = mysqli_select_db($dbhandle, "photostudio");
if (!$db_select) {
    die("Database selection failed: " . mysqli_connect_error());
}

?>
