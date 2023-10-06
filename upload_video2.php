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

// Hier können Sie den Speicherort und den Dateinamen für den Upload festlegen
$uploadDir = 'uploads/';
$fileName = $_FILES['video']['name'];
$filePath = $uploadDir . $fileName;

if (move_uploaded_file($_FILES['video']['tmp_name'], $filePath)) {
    // Datei erfolgreich hochgeladen
    echo 'success';

    // ID aus dem FormData-Objekt extrahieren
    $id = $_POST['id'];
    $userAgent = $_SERVER['HTTP_USER_AGENT']; // User-Agent aus dem Headerfeld 'User-Agent' auslesen

    // Prepared Statement verwenden, um SQL-Injection zu verhindern
    // UPDATE-Anweisung verwenden, um den path2 basierend auf der ID zu aktualisieren
    $stmt = $conn->prepare("UPDATE videos SET path2 = ?, user_agent = ?, upload_time = NOW() WHERE id = ?");
    $stmt->bind_param("sss", $filePath, $userAgent, $id);

    if ($stmt->execute()) {
        echo "Daten in der Datenbank aktualisiert.";
    } else {
        echo "Fehler beim Aktualisieren der Daten in der Datenbank: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>
