<?php

require ('session_check.php');
include 'db_connect.php'; // Databaseverbinding

// Wachtwoord wijzigen
$bericht = '';
if (isset($_POST['admin_wachtwoord'], $_POST['nieuw_wachtwoord'])) {
    $admin_wachtwoord = $_POST['admin_wachtwoord'];
    $nieuw_wachtwoord = $_POST['nieuw_wachtwoord'];

    // Haal het huidige admin-wachtwoord op
    $query = $conn->prepare("SELECT admin_wachtwoord FROM admin_wachtwoorden WHERE id = 1");
    $query->execute();
    $resultaat = $query->get_result();

    if ($resultaat->num_rows > 0) {
        $row = $resultaat->fetch_assoc();

        if (password_verify($admin_wachtwoord, $row['admin_wachtwoord'])) {
            // Hash het nieuwe wachtwoord en update het
            $nieuw_gehasht_wachtwoord = password_hash($nieuw_wachtwoord, PASSWORD_DEFAULT);
            $updateQuery = $conn->prepare("UPDATE admin_wachtwoorden SET wachtwoord = ? WHERE id = 1");
            $updateQuery->bind_param("s", $nieuw_gehasht_wachtwoord);
            $updateQuery->execute();

            if ($updateQuery->affected_rows > 0) {
                $bericht = "Wachtwoord succesvol gewijzigd.";
            } else {
                $bericht = "Wachtwoord kon niet worden gewijzigd.";
            }
        } else {
            $bericht = "Onjuist admin-wachtwoord.";
        }
    } else {
        $bericht = "Fout bij het ophalen van het admin-wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wachtwoord Wijzigen</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- CSS-bestand koppeling -->
</head>
<body>
    <div class="wachtwoord-wijzig-container">
        <form method="POST">
            <h2>Wachtwoord Wijzigen</h2>
            <p><?php echo $bericht; ?></p>
            <label for="admin_wachtwoord">Admin Wachtwoord:</label>
            <input type="password" name="admin_wachtwoord" required>
            <br>
            <br>
            <label for="nieuw_wachtwoord">Nieuw Wachtwoord:</label>
            <input type="password" name="nieuw_wachtwoord" required>
            <br>
            <input type="submit" value="Wachtwoord Wijzigen">
        </form>
    </div>
</body>
</html>