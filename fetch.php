<?php
include 'config.php';

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_error) {
    exit;//die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

$json = file_get_contents("php://input");

$data = '';
if (!empty($json)) {
	$data = json_decode($json, true);
}

if(isset($data['action']) && $data['action'] == 'getlist') {
    $listname = $data['listname'];
    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    if ( $stmt ){
        $stmt->bind_param('s', $listname); // Fragezeichen (?) ersetzen
        $stmt->execute(); // SQL-Query ausführen
        $result = $stmt->get_result();
    }
    $row = $result->fetch_assoc();
    //var_export($row);
    if($row){
        echo json_encode($row);
    }
}

if(isset($data['action']) && $data['action'] == 'savelist') {
    $listname = $data['listname'];
    $list = json_encode($data['list']);
    $sql = "UPDATE listnames SET data = ? WHERE listname = ?";
    $stmt = $mysqli->prepare($sql);
    if ( $stmt ) {
        $stmt->bind_param('ss', $list, $listname); // Fragezeichen (?) ersetzen
        //$stmt->bind_param('s', $listname); // Fragezeichen (?) ersetzen
        $stmt->execute(); // SQL-Query ausführen
        //$result = $stmt->get_result();
    }
    //$row = $result->fetch_assoc();
    //var_export($row);
   /*  if($row){
        echo json_encode($row);
    } */
}





