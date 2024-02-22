<?php 
$name = "localhost";
$username = "root";
$password = "";
$db_name = "hackathon_db";

$con = mysqli_connect($name, $username, $password, $db_name);

if(!$con){
    echo "Failed";
}
?>