<?php 
session_start(); 
include 'config.php';
$listname = $_GET['path'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seriestracker</title>
</head>
<body>
  <div id="app"></div>
  <?php 
  if(isset($_SESSION['password_hash'])){

  }
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ($mysqli->connect_error) {
      exit;//die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
  }
  $list = false;
  if(!empty($listname)) {
      $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
      $stmt = $mysqli->prepare($sql);
      if ( $stmt ) {
          $stmt->bind_param('s', $listname); // Fragezeichen (?) ersetzen
          $stmt->execute(); // SQL-Query ausführen
          $result = $stmt->get_result();
      }
      $row = $result->fetch_assoc();
      var_export($row);
      if($row){
        $list = true;
      }
  }
/*     else{
    do{
        $hash = md5();
        $sql = "INSERT INTO listnames SET name = ?";
    }
    while()
    } */

    
    ?>
    <script>
        window.list = <?= $list ? 'true' : 'false' ?>;
        window.path = <?= json_encode($listname) ?>;
        window.authorized = false;
    </script>   
    <script src="/dist/bundle.js"></script>
</body>
</html>


<?php
/*
1. startseite -> sobald werteintrag weiterleitung mit js auf neue seite
2. listenname in url eingetragen ohne existierende liste -> können werte eingetragen werden und für diese seite wird ein eintrag erstellt
    -> das geht weil eine existierende tabelle schon angezeigt werden würde. TODO: private listen kennzeichnen. PW abfrage

*/
?>