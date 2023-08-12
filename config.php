<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "FinalProject";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed");

$base_url = "http://localhost/FinalProject/";
$my_email = "";

$smtp['host'] = "smtp.gmail.com";
$smtp['user'] = "";
$smtp['pass'] = "";
$smtp['port'] = 465;
