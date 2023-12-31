<?php
// Verbindung zur Datenbank herstellen
$servername = "localhost";
$username = "dbname";
$password = "W^ZPM+hWhqc{GFCF1r?=AuRvt^58nE%_";
$dbname = "videoapp";

$sql = "SELECT path2 FROM videos WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (empty($row['path2'])) {
    // Wenn path2 leer ist, speichern Sie das Video in path2
    $stmt = $conn->prepare("UPDATE videos SET path2=? WHERE id=?");
    $stmt->bind_param("ss", $filePath, $id);
} else {
    // Ansonsten speichern Sie das Video in path (wie zuvor)
    $stmt = $conn->prepare("INSERT INTO videos (id, path, user_agent, upload_time) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $id, $filePath, $userAgent);
}


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

    // ID, Dateinamen und User-Agent in die Datenbank schreiben
    $id = $_POST['id'];
    $userAgent = $_SERVER['HTTP_USER_AGENT']; // User-Agent aus dem Headerfeld 'User-Agent' auslesen

    // Prepared Statement verwenden, um SQL-Injection zu verhindern
    $stmt = $conn->prepare("INSERT INTO videos (id, path, user_agent, upload_time) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $id, $filePath, $userAgent);

    if ($stmt->execute()) {
        echo "Daten in die Datenbank geschrieben.";
    } else {
        echo "Fehler beim Schreiben der Daten in die Datenbank: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'error';
}
?>