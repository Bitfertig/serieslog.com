<?php 
if ( !file_exists(__DIR__.'/.env.php') ) die('Error: Missing environment settings.');
include '.env.php';
include 'function.php';
include 'setup.php';


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
    <meta name="description" content="Manage series and never forget your last episode.">
    <meta name="keywords" content="serieslog, series, episodes, tracker, logger, log, manager">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= $maincss.'?t='.filemtime(__DIR__.$maincss) ?>">
    <link rel="manifest" href="/manifest.webmanifest">
</head>
<body>

    <div class="main">
        <div id="app"></div>
    </div>
    <div class="container">
        In the spotlight:<br>
        <div class="row">
            <?php $series = getRandomSeries(6); foreach ( $series as $s ) { ?>
                <div class="col-2">
                    <img src="<?= $s->Poster ?>" alt="<?= htmlspecialchars($s->Title) ?>" style="max-height:150px;">
                    <div><strong><?= $s->Title ?></strong></div>
                    <div class="text-muted small"><?= $s->Plot ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
    <footer class="footer">
        <a href="https://www.serieslog.com">www.serieslog.com</a>
        <a href="http://www.bitfertig.de/impressum" target="_blank">Impress</a>
        <a href="https://www.serieslog.com/seriessearch" target="_blank">Series search</a>
    </footer>
    
    <script>
        window.list_exists = <?= json_encode($list_exists) ?>;
        window.path = <?= json_encode($listname) ?>;
        window.authorized = <?= json_encode($authorized) ?>;
        window.authorized_required = <?= json_encode($authorized_required) ?>;
    </script>   
    <script src="<?= $mainjs.'?t='.filemtime(__DIR__.$mainjs) ?>"></script>

<datalist id="datalist_titles">
<?php
$sql = 'SELECT * FROM omdb ORDER BY title ASC';
$result = mysqlibinder($mysqli, $sql, '', []);
?>
<?php while ($row = $result->fetch_object()) { ?><option><?= $row->title ?></option><?php } ?>
</datalist>

    
</body>
</html>