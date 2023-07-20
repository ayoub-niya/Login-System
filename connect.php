<?php

$host = "localhost";
$dbname = "login";
$username = "root";
$password = "93909311";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOExcetpion $e) {
    
    die("Connection failed: ".$e->getMessage());
}