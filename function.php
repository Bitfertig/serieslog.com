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
        if (!empty($bindparams)) { $stmt->bind_param($bindtypes, ...$bindparams); } // Fragezeichen (?) ersetzen
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


function fuzzySearch(string $q) {
    global $mysqli;

    
    $q_chars = str_split($q);
    $string = $q;
    $stringmatch = '%'.$q.'%';
    $insertions = '%'.implode('%', $q_chars).'%';
    #$substitutions = [];
    $deletions = [];
    for ($i = 1; $i < count($q_chars); $i++) {
        $deletions[] = '('. substr_replace($q, '', $i, 1) .')';
    }
    $deletions = implode('|', $deletions);
    $transpositions = [];
    for ($i = 0; $i < count($q_chars) - 1; $i++) {
        $transpositions[] = '('. substr_replace($q, '['.$q[$i].$q[$i+1].']', $i, 2) .')';
    }
    $transpositions = implode('|', $transpositions);
    #var_export($insertions);exit;

    $regexp1 = '[[:<:]]'.$string.'[[:>:]]';
    $regexp2 = '([[:<:]]'.$string.')|('.$string.'[[:>:]])';
    $regexp3 = $string;

    $sql = "SELECT 
            s.*, COUNT(s1.imdb_id), COUNT(s2.imdb_id), COUNT(s3.imdb_id)
        FROM
            # Pre-Selection
            (
                SELECT * FROM omdb WHERE 
                    # Exact characters: '%and%'
                    title LIKE ?
                    # Insertions: 'a%n%d'
                    OR title LIKE ?
                    # Deletions starting at 2. char: '(ad)|(an)'
                    OR title REGEXP ?
                    # Transpositions: '([an]d)|(a[nd])'
                    OR title REGEXP ?
            ) AS s
        LEFT JOIN omdb AS s1 ON (s.imdb_id = s1.imdb_id AND s1.title REGEXP ?) # Exact characters
        LEFT JOIN omdb AS s2 ON (s.imdb_id = s2.imdb_id AND s2.title REGEXP ?) # Am Anfang oder Ende
        LEFT JOIN omdb AS s3 ON (s.imdb_id = s3.imdb_id AND s3.title REGEXP ?) # somewhere
        GROUP BY 
            s.imdb_id
        ORDER BY 
            COUNT(s1.imdb_id) DESC,
            COUNT(s2.imdb_id) DESC,
            COUNT(s3.imdb_id) DESC,
            title ASC
        LIMIT 10
    ";
    $result = mysqlibinder($mysqli, $sql, 'sssssss', [$stringmatch, $insertions, $deletions, $transpositions, $regexp1, $regexp2, $regexp3]);

    return $result;
}

function fuzzy_search_parts($text, $q) {
    $q_chars = str_split($q);

    $stringmatch = '/('.$q.')/is';
    $str = preg_replace($stringmatch, '<u>$1</u>', $text, -1, $count);
    if ($count > 0) return $str;

    
    $insertions = [];
    for ($i = 0; $i < count($q_chars); $i++) {
        $insertions[] = '('.$q_chars[$i].')';
    }
    $insertions = '/'.implode('.*', $insertions).'/is';
    $str = preg_replace_callback($insertions, function($matches) use ($q_chars) {
        $r = '';
        $found = 0;
        foreach($matches as $match) {
            foreach (str_split($match) as $char) {
                if (isset($q_chars[$found]) && strtolower($char) == strtolower($q_chars[$found])) {$r .= '<u>'.$char.'</u>'; $found++;}
                else $r .= $char;
            }
            break;
        }
        return $r;
    }, $text, -1, $count);
    if ($count > 0) return $str;

    return $text;
}