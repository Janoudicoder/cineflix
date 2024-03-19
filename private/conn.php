<?php
/*$dbsernave = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "cinflix_1";

// Connection
$conn = "mysql:host=$dbsernave;dbname=$dbname;charset=utf8";
$PDO = new PDO($conn, $dbUsername,$dbPassword);

// Error Mode
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);*/



$host = '192.168.6.202';
$dbname = 'cinflix';
$username = 'dbadmin';
$password = 'Welkom01!';

try
{
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die("Connection failed: " . $e->getMessage());
}
?>