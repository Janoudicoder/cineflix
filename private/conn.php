<?php
$host = 'localhost';
$dbname = 'cinflix_1'; 
$username = 'root';  
$password = '';  

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verbinding succesvol
    // echo "Verbinding met de database is gelukt!";
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
<!-- school -->
<!-- <?php
// $host = '192.168.6.202';
// $dbname = 'cinflix';
// $username = 'dbadmin';
// $password = 'Welkom01!';

// try
// {
//     $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $e)
// {
//     die("Connection failed: " . $e->getMessage());
// }
// ?> -->