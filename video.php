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
</head>
<body>
  <nav class="navbar">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="https://swissbutler.ch/wp-content/uploads/2020/11/SwissButler.svg" alt="SwissButler" width="270" height="68">
      </a>
    </div>
  </nav>

  <div class="container">
    <div class="box">
      <div id="video-player">
        <video controls autoplay>
          <?php
          $videoId = $_GET['id'];

          // Verbindung zur Datenbank herstellen
          $servername = "localhost";
          $username = "dbname";
          $password = "W^ZPM+hWhqc{GFCF1r?=AuRvt^58nE%_";
          $dbname = "videoapp";

          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
              die("Verbindung zur Datenbank fehlgeschlagen: " . $conn->connect_error);
          }

          // Pfad zum Video aus der Datenbank abrufen
          $sql = "SELECT path FROM videos WHERE id = '$videoId'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $videoPath = $row['path'];
              echo "<source src=\"" . $videoPath . "\" type=\"video/mp4\">";
          }
          
          $conn->close();
          ?>
          Ihr Browser unterstützt das Video-Tag nicht.
        </video>
      </div>
    </div>
  </div>
  <script src="https://unpkg.com/material-components-web@11.0.0/dist/material-components-web.min.js"></script>
</body>
</html>