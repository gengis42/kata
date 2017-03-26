<?php
$db = new PDO("mysql:host=localhost;dbname=kata", "root", "");

//error_reporting(1);
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

// IP for comments trace
$ip = getenv("REMOTE_ADDR");
setlocale (LC_ALL, "it_IT");

$server_url="http://kata.loc";
?>
