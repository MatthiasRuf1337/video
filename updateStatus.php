<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "dbname";
$password = "W^ZPM+hWhqc{GFCF1r?=AuRvt^58nE%_";
$dbname = "videoapp";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $itemId = $_POST["itemId"];
    $newStatus = $_POST["newStatus"];

    // Aktualisiere den Status in der Datenbank
    $sql = "UPDATE videos SET status = '$newStatus' WHERE id = '$itemId'";
    if ($conn->query($sql) === TRUE) {
        echo "Status erfolgreich aktualisiert für ID: $itemId, neuer Status: $newStatus";
    } else {
        echo "Fehler beim Aktualisieren des Status: " . $conn->error;
    }

    // Prüfen, wie viele Zeilen betroffen waren
    $affected_rows = $conn->affected_rows;
    if ($affected_rows == 0) {
        echo "Keine Zeilen aktualisiert. Überprüfen Sie, ob die ID $itemId existiert.";
    } else {
        echo "$affected_rows Zeile(n) aktualisiert.";
    }
}


$conn->close();
?>