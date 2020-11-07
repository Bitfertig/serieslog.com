<?php 
session_start();
if ( file_exists(__DIR__.'/.env.php') ) include __DIR__.'/.env.php';
include 'config.php';
include 'function.php';

$mysqli = mysqli_connection($dbhost, $dbuser, $dbpass, $dbname);

// Standardwerte setzen
$listname = $_GET['path'] ?? '';
$list_exists = false;
$authorized = false;
$authorized_required = false;

// Liste auslesen und Standardwerte überschreiben
if(!empty($listname)) {
    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', [$listname]);
    $row = $result->fetch_assoc();
    if($row){
        $list_exists = true;
        $list = (object) $row;
        $authorized_required = !empty($list->password);
        $authorized = isset($_SESSION['loggedin'], $_SESSION['loggedin'][$listname]);
    }
}
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
    
    <script>
        window.list_exists = <?= json_encode($list_exists) ?>;
        window.path = <?= json_encode($listname) ?>;
        window.authorized = <?= json_encode($authorized) ?>;
        window.authorized_required = <?= json_encode($authorized_required) ?>;
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
