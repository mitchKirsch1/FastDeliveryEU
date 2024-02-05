<?php
$host = 'localhost';
$gebruiker = 'root';
$wachtwoord = '';
$database = 'fastdeliveryeu';

$conn = new mysqli($host, $gebruiker, $wachtwoord, $database);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>