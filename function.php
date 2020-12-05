<?php


// DB Verbindung
function mysqli_connection($dbhost, $dbuser, $dbpass, $dbname) {
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
    }
    return $mysqli;
}


function mysqlibinder($mysqli, $sql, $bindtypes='', $bindparams=[]){
    $result = false;
    $stmt = $mysqli->prepare($sql);
    if ( $stmt ){
        if(!empty($bindparams)){$stmt->bind_param($bindtypes, ...$bindparams);} // Fragezeichen (?) ersetzen
        $stmt->execute(); // SQL-Query ausführen
        $result = $stmt->get_result();
    }
    return $result;
}


function access_granted($listname) {
    $access_granted = isset($_SESSION['loggedin'], $_SESSION['loggedin'][$listname]);
    return $access_granted;
}


function getSeriesByTitle($title) {
    global $mysqli;

    // Try to select
    $sql = "SELECT * FROM omdb WHERE title LIKE ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', ['%'.$title.'%']);
    $row = $result->fetch_object();
    #echo '<pre>';var_export($row);echo '</pre>';exit;

    // If no database result
    if ( $result && !$result->num_rows ) {
        // Curl
        $url = 'http://www.omdbapi.com/?apikey='.$_ENV['OMDB_APIKEY'].'&type=series&t='.urlencode($title);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        #echo '<pre>';var_export($response);echo '</pre>';exit;

        $json = json_decode($response);
        if ( $json && isset($json->imdbID) ) {
            $sql = "INSERT INTO omdb SET imdb_id = ?, title = ?, `data` = ?";
            $result = mysqlibinder($mysqli, $sql, 'sss', [$json->imdbID, $json->Title, $response]);
        }
    } else {
        $json = json_decode($row->data);
    }

    return ( $json && isset($json->imdbID) ) ? $json : false;
}



function getRandomSeries(int $limit = 1) {
    global $mysqli;
    $sql = "SELECT * FROM omdb ORDER BY RAND() LIMIT ".$limit;
    $result = mysqlibinder($mysqli, $sql);
    $series = [];
    while( $row = $result->fetch_object() ) {
        $series[] = json_decode($row->data);
    }
    return $series;
}