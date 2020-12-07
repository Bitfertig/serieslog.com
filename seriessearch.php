<?php

if ( !file_exists(__DIR__.'/.env.php') ) die('Error: Missing environment settings.');
include '.env.php';
include 'function.php';
include 'setup.php';






?>
<h2>Series search</h2>
<p>Searching in present series list. If the series is not present yet, we will try to find the series automatically elsewhere and save the series to the list.</p>
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
echo '<h3>Series list</h3>';
?>
<form method="post" action="">
<input type="hidden" name="action" value="filter">
<input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
<input type="text" name="f" value="<?= htmlspecialchars($_POST['f'] ?? '') ?>" placeholder="Title">
<input type="submit" value="Fuzzy filter"> <a href="">Reset</a>
</form>
<?php
if ( isset($_POST['action']) && isset($_POST['csrf']) && !empty($_POST['f']) && $_POST['action'] == 'filter' && $_POST['csrf'] == $_SESSION['csrf'] ) {
    $result = fuzzySearch($_POST['f'] ?? '');
    /* while( $row = $result->fetch_object() ) {
        var_export($row->title);
        echo '<hr>';
    } */
}
else {
    $sql = 'SELECT * FROM omdb ORDER BY title ASC';
    $result = mysqlibinder($mysqli, $sql, '', []);
}
?>
<table>
<tr>
    <td>Title</td>
    <td>Year</td>
    <td>Released</td>
    <td>Genre</td>
    <td>Rated</td>
    <td>total Seasons</td>
    <td>Runtime</td>
    <td>imdb Rating</td>
</tr>
<?php while ($row = $result->fetch_object()) { ?>
    <?php $json = json_decode($row->data); ?>
    <tr class="<?= ( isset($series->imdbID) && $row->imdb_id == $series->imdbID ? 'highlighted' : '' ) ?>" id="imdbid-<?= $row->imdb_id ?>">
        <td><?= fuzzy_search_parts($row->title, $_POST['f'] ?? '') ?></td>
        <td><?= $json->Year ?></td>
        <td><?= $json->Released ?></td>
        <td><?= $json->Genre ?></td>
        <td><?= $json->Rated ?></td>
        <td><?= $json->totalSeasons ?></td>
        <td><?= $json->Runtime ?></td>
        <td><?= $json->imdbRating ?></td>
    </tr>
<?php } ?>
</table>


<style>
.highlighted {
    background-color:red;
}
</style>