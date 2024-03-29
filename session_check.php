<?php
session_start();

// Controleer of de gebruiker is ingelogd. Zo niet, omleiden naar de inlogpagina.
if (!isset($_SESSION['ingelogd']) || $_SESSION['ingelogd'] !== true) {
    header("Location: login.php");
    exit;
}

$tijdslimiet = 300; // 5 minuten in seconden

if (isset($_SESSION['laatste_activiteit']) && (time() - $_SESSION['laatste_activiteit'] > $tijdslimiet)) {
    // Gebruiker is inactief geweest voor meer dan 5 minuten
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

$_SESSION['laatste_activiteit'] = time(); // Update laatste activiteitstijd
?>
