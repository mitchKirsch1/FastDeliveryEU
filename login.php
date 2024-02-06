<?php
session_start();

include 'db_connect.php'; // Verbind met de database

// Check het wachtwoord
if (isset($_POST['wachtwoord'])) {
    $wachtwoord = $_POST['wachtwoord'];

    // Haal het gehashte wachtwoord op uit de database
    $query = $conn->prepare("SELECT wachtwoord FROM admin_wachtwoorden WHERE id = 1");
    $query->execute();
    $resultaat = $query->get_result();

    if ($resultaat->num_rows > 0) {
        $row = $resultaat->fetch_assoc();

        if (password_verify($wachtwoord, $row['wachtwoord'])) {
            // Wachtwoord correct, gebruiker inloggen
            $_SESSION['ingelogd'] = true;
            header("Location: index.php"); // Pas dit aan naar uw beveiligde pagina
            exit;
        } else {
            $bericht = "Onjuist wachtwoord.";
        }
    } else {
        $bericht = "Geen wachtwoord gevonden.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- CSS-bestand koppeling -->
</head>
<body>
    <div class="login-container">
        <form method="POST">
            <h2>Login</h2>
            <?php if (!empty($bericht)) echo "<p>$bericht</p>"; ?>
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" name="wachtwoord" required>
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
