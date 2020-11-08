<?php 
session_start();
if ( !file_exists(__DIR__.'/.env.php') ) die('Error: Missing environment settings.');
include '.env.php';
include 'config.php';
include 'function.php';

$mysqli = mysqli_connection($dbhost, $dbuser, $dbpass, $dbname);

// Generated files
$mainjs = '/dist/main.js';
$maincss = '/dist/main.css';

// Standardwerte setzen
$listname = $_GET['path'] ?? '';
$list_exists = false;
$authorized = false;
$authorized_required = false;

// Liste auslesen und Standardwerte überschreiben
if ( !empty($listname) ) {
    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', [$listname]);
    $row = $result->fetch_assoc();
    if ( $row ) {
        $list_exists = true;
        $list = (object) $row;
        $authorized_required = !empty($list->password);
        $authorized = access_granted($listname);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serieslog</title>
    <meta name="keywords" content="serieslog, series, episodes, tracker, logger, log, manager">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $maincss.'?t='.filemtime(__DIR__.$maincss) ?>">
</head>
<body>

    <div class="main">
        <div id="app"></div>
    </div>
    <footer class="footer"><a href="http://www.bitfertig.de/impressum" target="_blank">Impress</a></footer>
    
    <script>
        window.list_exists = <?= json_encode($list_exists) ?>;
        window.path = <?= json_encode($listname) ?>;
        window.authorized = <?= json_encode($authorized) ?>;
        window.authorized_required = <?= json_encode($authorized_required) ?>;
    </script>   
    <script src="<?= $mainjs.'?t='.filemtime(__DIR__.$mainjs) ?>"></script>
    
</body>
</html>