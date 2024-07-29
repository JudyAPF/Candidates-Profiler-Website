<?php
$host="localhost";
$user="root";
$pwd="";
$db="candidates_profiler";
$connect=new mysqli($host, $user, $pwd, $db);

// Check if the connection was successful
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
?>