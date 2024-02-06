<?php
//login
require 'session_check.php';
// Databaseverbinding
include('db_connect.php');

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gebruik de huidige datum en tijd
    $datum = date('Y-m-d');
    $tijd = date('H:i:s');
    
    $keyNumber = $_POST['keyNumber'];
    $user = substr($_POST['user'], 0, 20); // Beperk gebruikersnaam tot maximaal 20 tekens


    // Voeg sleutelinformatie toe aan de database
    $sql = "INSERT INTO registraties (datum, tijd, sleutelnummer, gebruiker) VALUES ('$datum', '$tijd', '$keyNumber', '$user')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = 'Sleutel is succesvol toegevoegd';
        header('Location: index.php'); // Redirect naar dezelfde pagina na succesvolle toevoeging
        exit();
    } else {
        echo "Fout bij toevoegen sleutelregistratie: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleutelregistratie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="logout-button">
<form action="logout.php" method="post">
    <input type="submit" value="Logout" class="button">
</form>
    </div>
    <!-- Alles button rechts boven -->
    <a href="agenda.php" class="all-button">Agenda</a>

    <form method="post" action="" class="registration-form">
        <h1>Sleutelregistratie</h1>

        <!-- Gebruikersnaam invoerveld -->
        <div class="input-group">
            <label for="user">naam:</label>
            <input type="text" name="user" required>
        </div>

        <!-- Sleutelnummer invoerveld -->
        <div class="input-group">
            <label for="keyNumber">Sleutelnummer (1 t/m 6):</label>
            <input type="number" name="keyNumber" min="1" max="6" required>
        </div>

        <!-- De datum en tijd worden automatisch ingevuld -->
        <input type="submit" value="Registreer sleutel">
    </form>

    <!-- Toon succesmelding -->
    <?php
    if ($successMessage) {
        echo "<script>alert('$successMessage');</script>";
    }
    ?>

    <?php
    // Haal alle sleutelregistraties van vandaag op uit de database
    $result = $conn->query("SELECT * FROM registraties WHERE datum = CURDATE() ORDER BY tijd DESC");

    // Toon het logboek in een tabel
    if ($result->num_rows > 0) {
        echo "<h2>Logboek sleutelregistraties vandaag:</h2>";
        echo "<table>";
        echo "<tr><th>Datum</th><th>Tijd</th><th>Gebruiker</th><th>Sleutelnummer</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['datum'] . "</td><td>" . $row['tijd'] . "</td><td>" . $row['gebruiker'] . "</td><td>" . $row['sleutelnummer'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Geen sleutelregistraties gevonden voor vandaag.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
