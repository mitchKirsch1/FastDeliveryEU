
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sleutelagenda</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
    // Databaseverbinding
    include('db_connect.php');

    // Functie om de dagen van de maand op te halen
    function getMonthDays($year, $month) {
        $firstDayOfMonth = strtotime("$year-$month-01");
        $lastDayOfMonth = strtotime(date('Y-m-t', $firstDayOfMonth));
        $days = array();

        for ($day = $firstDayOfMonth; $day <= $lastDayOfMonth; $day += 86400) {
            $days[] = date('Y-m-d', $day);
        }

        return $days;
    }

    // Huidige jaar en maand
    $currentYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $currentMonth = isset($_GET['month']) ? $_GET['month'] : date('m');

    // Vorige en volgende maand
    $prevMonth = date('m', strtotime("-1 month", strtotime("$currentYear-$currentMonth-01")));
    $nextMonth = date('m', strtotime("+1 month", strtotime("$currentYear-$currentMonth-01")));

    // Dagen van de huidige maand
    $daysOfMonth = getMonthDays($currentYear, $currentMonth);

    // Logboek voor de geselecteerde dag
    $selectedDate = isset($_GET['date']) ? $_GET['date'] : null;
    $logbookEntries = array();

    if ($selectedDate) {
        // Haal het sleutellogboek op voor de geselecteerde dag
        $result = $conn->query("SELECT * FROM registraties WHERE datum = '$selectedDate' ORDER BY tijd DESC");

        while ($row = $result->fetch_assoc()) {
            $logbookEntries[] = $row;
        }
    }
    ?>

    <h1>Sleutelagenda</h1>

    <!-- Terugknop rechtsboven -->
    <a href="index.php" class="back-button">Terug</a>

    <!-- Navigatie naar vorige en volgende maand -->
    <div class="nav-buttons">
        <a href="agenda.php?year=<?= $currentYear ?>&month=<?= $prevMonth ?>" class="calendar-button">&lt; Vorige maand</a>
        <span><?= date('F Y', strtotime("$currentYear-$currentMonth-01")) ?></span>
        <a href="agenda.php?year=<?= $currentYear ?>&month=<?= $nextMonth ?>" class="calendar-button">Volgende maand &gt;</a>
    </div>

    <!-- Kalender -->
    <table class="calendar-table">
        <thead>
            <tr>
                <th>Zo</th>
                <th>Ma</th>
                <th>Di</th>
                <th>Wo</th>
                <th>Do</th>
                <th>Vr</th>
                <th>Za</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $firstDayOfWeek = date('w', strtotime("$currentYear-$currentMonth-01"));
            $currentDay = 1;

            // Loop door de rijen van de kalender
            for ($row = 0; $row < 6; $row++) {
                echo "<tr>";

                // Loop door de dagen van de week
                for ($col = 0; $col < 7; $col++) {
                    echo "<td>";

                    // Controleer of de dag binnen de maand valt
                    if (($row == 0 && $col >= $firstDayOfWeek) || ($row > 0 && $currentDay <= count($daysOfMonth))) {
                        $currentDate = $daysOfMonth[$currentDay - 1];
                        echo "<a href='agenda.php?year=$currentYear&month=$currentMonth&date=$currentDate'>$currentDay</a>";

                        // Markeer de geselecteerde dag
                        if ($currentDate == $selectedDate) {
                            echo "<div class='selected-date-marker'></div>";
                        }

                        $currentDay++;
                    }

                    echo "</td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Toon het sleutellogboek voor de geselecteerde dag -->
    <?php
    if ($selectedDate) {
        echo "<div class='logbook-section'>";
        echo "<h2>Sleutelregistraties voor $selectedDate:</h2>";

        if (!empty($logbookEntries)) {
            echo "<table>";
            echo "<tr><th>Tijd</th><th>Gebruiker</th><th>Sleutelnummer</th></tr>";
            foreach ($logbookEntries as $entry) {
                echo "<tr><td>" . $entry['tijd'] . "</td><td>" . $entry['gebruiker'] . "</td><td>" . $entry['sleutelnummer'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Geen sleutelregistraties gevonden voor $selectedDate.</p>";
        }

        echo "</div>";
    }
    ?>

    <?php
    $conn->close();
    ?>
</body>
</html>
