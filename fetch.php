<?php 
session_start(); 
include 'config.php';

// DB Verbindung
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
}

$json = file_get_contents("php://input");

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

$data = '';
if (!empty($json)) {
	$data = json_decode($json, true);
}



// Login
if ( isset($data['action']) && $data['action'] == 'login' ) {
    $listname = $data['listname'];
    $password = $data['password'];

    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', [$listname]);
    
    if ( $result->num_rows > 0 ) {
        $row = $result->fetch_object();
        $password_hash = $row->password;
        if ( password_verify($password, $password_hash) ) {
            $_SESSION['loggedin'] = true;
        }
    }

    $response = [
        'login' => ($_SESSION['loggedin'] ?? false)
    ];

    echo json_encode($response);
    exit;
}



// Logout
if ( isset($data['action']) && $data['action'] == 'logout' ) {
    $_SESSION['loggedin'] = false;

    $response = [
        'logout' => true
    ];

    echo json_encode($response);
    exit;
}



if(isset($data['action']) && $data['action'] == 'getlist') {
    $listname = $data['listname'];
    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', [$listname]);
    $row = $result->fetch_assoc();
    if($row){
        echo json_encode($row);
    }
}



if(isset($data['action']) && $data['action'] == 'savelist') {
    $listname = $data['listname'];
    $list = json_encode($data['list']);
    if(empty($listname)){
        $listname = md5(time());
        $sql = "INSERT INTO listnames SET listname = ?, data = ?";
        $result = mysqlibinder($mysqli, $sql, 'ss', [$listname, $list]);
        echo json_encode(["listname" => $listname]);
    }else{

        $sql = "UPDATE listnames SET data = ? WHERE listname = ?";
        $result = mysqlibinder($mysqli, $sql, 'ss', [$list, $listname]);
        echo json_encode((object)[]);
    }
}



if(isset($data['action']) && $data['action'] == 'savelistname') {
    //$old_listname = $data['old_listname'];
    $list = json_encode($data['list']);
    $new_listname = $data['new_listname'];
    $password = $data['password'];
    $email = $data['email'];

    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $stmt = $mysqli->prepare($sql);
    if ( $stmt ){
        $stmt->bind_param('s', $new_listname); // Fragezeichen (?) ersetzen
        $stmt->execute(); // SQL-Query ausführen
        $result = $stmt->get_result();
    }
    if($result->num_rows == 0){
        $sql = "INSERT listnames SET data = ?, listname = ?, password = ?, email = ?";
        $stmt = $mysqli->prepare($sql);
        if ( $stmt ) {
            $stmt->bind_param('ssss', $list, $listname, $password, $email); // Fragezeichen (?) ersetzen
            //$stmt->bind_param('s', $listname); // Fragezeichen (?) ersetzen
            $stmt->execute(); // SQL-Query ausführen
            //$result = $stmt->get_result();
        }
    }else{
        //failed
    }
    
    // check listname if nothing else is set
    // check listname and pw if pw is set
    // check listname

    //this.listname, this.form_listname, this.form_password, this.form_email
}




// seiten aufruf
// listenbearteitung -> zufallsname -> INSERT
// listennamen/pw bearbeiten -> UPDATE



