<?php
ob_start();//Turns on output buffering
session_start();

date_default_timezone_set("Africa/Cairo");

try{
    $con= new PDO("mysql:dbname=72-lxxii;host=localhost:3307","root","");
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    exit("Connection Failed: ". $e->getMessage());
}


?>