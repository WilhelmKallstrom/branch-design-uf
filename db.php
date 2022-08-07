<?php

$database = "03wka01";
$username = "03wka01";
$password = "Kaktus123!";

$connection = new mysqli('localhost', $username, $password, $database);



if($connection->connect_error){
    die("Connection failed" .$connection->connect_error);
}