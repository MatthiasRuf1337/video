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
  <style>
 .mdc-data-table__row:hover {
    cursor: pointer;
    background-color: #f5f5f5;
  }
  .col-id {
    width: 10%; /* oder ein anderer Wert, der zu Ihrem Layout passt */
  }
  .col-path {
    width: 45%; /* oder ein anderer Wert, der zu Ihrem Layout passt */
  }
  .col-user-agent {
    width: 35%; /* oder ein anderer Wert, der zu Ihrem Layout passt */
  }
  .col-upload-time {
    width: 10%; /* oder ein anderer Wert, der zu Ihrem Layout passt */
  }
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
  <div class="container">
    <div class="box">
      <div class="headline">
        <h1>Explore</h1>
      </div>
      <table class="mdc-data-table">
        <thead>
  <tr>
    <th class="mdc-data-table__header-cell col-id">ID</th>
    <th class="mdc-data-table__header-cell col-path">Path</th>
    <th class="mdc-data-table__header-cell col-user-agent">User Agent</th>
    <th class="mdc-data-table__header-cell col-upload-time">Upload Time</th>
  </tr>
</thead>

        <tbody>
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

          // Videos aus der Datenbank abrufen
          $sql = "SELECT id, path, user_agent, upload_time FROM videos"; // Hinzufügen von upload_time in der SQL-Abfrage
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              // Ausgabe der Videos in der Tabelle
              while ($row = $result->fetch_assoc()) {
                  echo "<tr onclick=\"location.href='/video.php?id=" . $row['id'] . "'\" class='mdc-data-table__row'>";
                  echo "<td class='mdc-data-table__cell'>" . $row['id'] . "</td>";
                  echo "<td class='mdc-data-table__cell'>" . $row['path'] . "</td>";
                  echo "<td class='mdc-data-table__cell'>" . $row['user_agent'] . "</td>";
                  echo "<td class='mdc-data-table__cell'>" . $row['upload_time'] . "</td>"; // Hinzufügen von upload_time in der Tabelle
                  echo "</tr>";
              }
          } else {
              echo "<tr><td class='mdc-data-table__cell' colspan='4'>Keine Videos gefunden</td></tr>"; // Ändern der colspan auf 4
          }

          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="https://unpkg.com/material-components-web@11.0.0/dist/material-components-web.min.js"></script>
</body>
</html>