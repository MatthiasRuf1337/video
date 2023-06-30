<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Videobewerbung</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/material-components-web@11.0.0/dist/material-components-web.min.css" rel="stylesheet"> 
  <link href="style.css" rel="stylesheet">
  <link rel="icon" href="https://swissbutler.ch/wp-content/uploads/2020/11/favicon.png" sizes="32x32" />
  <link rel="icon" href="https://swissbutler.ch/wp-content/uploads/2020/11/favicon.png" sizes="192x192" />
  <link rel="apple-touch-icon" href="https://swissbutler.ch/wp-content/uploads/2020/11/favicon.png" />
  <meta name="msapplication-TileImage" content="https://swissbutler.ch/wp-content/uploads/2020/11/favicon.png" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    .box {
      margin: 10px 0 !important;
    }
    .statusbox {
      display:flex;
    }
    .status-list {
      max-width: 25%;
      padding-left: 20px;
      padding-right: 20px;
      margin-left: 20px;
      margin-right: 20px;
    }
      .small-font {
    font-size: 13px !important;
  }
  </style>
</head>
<body>
  <nav class="navbar">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="https://swissbutler.ch/wp-content/uploads/2020/11/SwissButler.svg" alt="SwissButler" width="270" height="68">
      </a>
    </div>
  </nav>
  <div class="statusbox">
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

    $statuses = ['bewerbung', 'angeschaut', 'eingestellt', 'abgelehnt'];

    foreach ($statuses as $status) {
        // Videos aus der Datenbank abrufen
        $sql = "SELECT id, path, user_agent, upload_time FROM videos WHERE status = '$status'";
        $result = $conn->query($sql);
        echo "<div class='status-list' id='$status'>";
        echo "<h2>" . ucfirst($status) . "</h2>";
        echo "<div class='cards-container' id='sortable-$status'>";

        if ($result->num_rows > 0) {
            // Ausgabe der Videos in der Tabelle
while ($row = $result->fetch_assoc()) {
    echo "<div data-id='" . $row['id'] . "' class='card box'>";
    echo "<h4>ID: " . $row['id'] . "</h4>";
echo "<p class='card-path small-font'>" . $row['path'] . "</p>";
echo "<p class='card-date small-font'>Erstellungsdatum: " . $row['upload_time'] . "</p>";
echo "<p class='card-user-agent small-font'>User Agent: " . $row['user_agent'] . "</p>";


    // Hinzufügen eines Links zur Video-Seite
    echo "<a href='/video.php?id=" . $row['id'] . "' class='mdc-button mdc-button--raised'>Video anzeigen</a>";

    
    echo "</div>";
}

        } else {
            echo "<p>Keine Videos gefunden</p>";
        }

        echo "</div>";
        echo "</div>";
    }

    $conn->close();
    ?>
  </div>

  <script src="main.js"></script>
</body>
</html>