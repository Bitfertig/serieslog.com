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