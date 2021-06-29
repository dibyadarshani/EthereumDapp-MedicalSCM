<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$con = mysqli_connect($dbhost, $dbuser, $dbpass);
if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
mysqli_select_db($con, "loginsystem");
