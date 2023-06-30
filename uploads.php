<!DOCTYPE html>
<html>
<head>
    <title>Dateien anzeigen</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Dateien im Ordner "uploads":</h1>
    <table>
        <thead>
            <tr>
                <th>Dateiname</th>
                <th>Erstellt am</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Ordnerpfad
            $ordner = 'uploads/';

            // Überprüfen, ob der Ordner existiert
            if (is_dir($ordner)){
                // Verzeichnis öffnen
                if ($handle = opendir($ordner)){
                    // Array für Dateien und deren Erstellungszeit erstellen
                    $dateien = array();

                    // Alle Dateien im Ordner durchgehen
                    while (false !== ($datei = readdir($handle))){
                        // Nur Dateien anzeigen
                        if ($datei != "." && $datei != ".."){
                            $dateipfad = $ordner . $datei;
                            $erstellt = filemtime($dateipfad);

                            // Array mit Dateiname und Erstellungszeit füllen
                            $dateien[$datei] = $erstellt;
                        }
                    }

                    // Array nach Erstellungszeit absteigend sortieren
                    arsort($dateien);

                    // Array durchgehen und Dateien in der Tabelle anzeigen
                    foreach ($dateien as $datei => $erstellt) {
                        $dateipfad = $ordner . $datei;
                        $erstellt = date("d.m.Y H:i:s", $erstellt);

                        echo "<tr>";
                        echo "<td><a href='$dateipfad' target='_blank'>$datei</a></td>";
                        echo "<td>$erstellt</td>";
                        echo "</tr>";
                    }

                    // Verzeichnis schließen
                    closedir($handle);
                }
            } else {
                echo "<tr><td colspan='2'>Der angegebene Ordner existiert nicht.</td></tr>";
            }
        ?>
        </tbody>
    </table>
</body>
</html>