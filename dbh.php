<?php

$serverName="localhost:3309";
$userName="admin2";
$dbname="IdentityDB";
$dbpassword="1234";

$conn=mysqli_connect($serverName,$userName,$dbpassword,$dbname);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
}