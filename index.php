<?php

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
        echo "Fout bij toevoegen sleutel: " . $conn->error;
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
    <!-- Alles button rechts boven -->
    <a href="agenda.php" class="all-button">Alles</a>

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
    // Oude code voor het tonen van sleutelregistraties is hier verwijderd
    ?>
</body>
</html>