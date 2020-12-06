<?php

if ( !file_exists(__DIR__.'/.env.php') ) die('Error: Missing environment settings.');
include '.env.php';
include 'function.php';
include 'setup.php';





?>
<h2>Series search</h2>
<form method="post" action="">
<input type="hidden" name="action" value="search">
<input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
<input type="text" name="q" value="<?= htmlspecialchars($_POST['q'] ?? '') ?>" placeholder="Title">
<input type="submit" value="Search">
</form>
<?php
if ( isset($_POST['action']) && isset($_POST['csrf']) && $_POST['action'] == 'search' && $_POST['csrf'] == $_SESSION['csrf'] ) {
    $q = $_POST['q'] ?? '';
    $series = getSeriesByTitle($q);
    if ( $series->Response ?? false ) {
        echo '<h3>Detail</h3>';
        echo '▼ <a href="#imdbid-'.$series->imdbID.'">'.$series->Title.'</a>';
    }
    else {
        echo '<p>No series found like that.</p>';
    }
}
?>
<hr>
<?php

echo '<h3>Series</h3>';
echo '<table>';
$sql = 'SELECT * FROM omdb ORDER BY title ASC';
$result = mysqlibinder($mysqli, $sql, '', []);
while ($row = $result->fetch_object()) {
    $json = json_decode($row->data);
    echo '<tr class="highlighted" id="imdbid-'. $row->imdb_id .'">';
    echo '<td>'. $row->title .'</td>';
    echo '<td>'. $json->Year .'</td>';
    echo '<td>'. $json->Released .'</td>';
    echo '<td>'. $json->Genre .'</td>';
    echo '<td>'. $json->Rated .'</td>';
    echo '<td>'. $json->totalSeasons .'</td>';
    echo '</tr>';
}
echo '</table>';

