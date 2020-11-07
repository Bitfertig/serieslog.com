<?php 
session_start();
if ( file_exists(__DIR__.'/.env.php') ) include __DIR__.'/.env.php';
include 'config.php';
include 'function.php';

$mysqli = mysqli_connection($dbhost, $dbuser, $dbpass, $dbname);


// Request-Body
$json = file_get_contents("php://input");
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
            if ( !isset($_SESSION['loggedin']) ) $_SESSION['loggedin'] = [];
            $_SESSION['loggedin'][$listname] = [
                'listname' => $listname,
                'password_hash' => $password_hash
            ];
        }
    }

    $response = [
        'login' => isset($_SESSION['loggedin'], $_SESSION['loggedin'][$listname])
    ];

    echo json_encode($response);
    exit;
}



// Logout
if ( isset($data['action']) && $data['action'] == 'logout' ) {
    $listname = $data['listname'];
    unset($_SESSION['loggedin'][$listname]);

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



if ( isset($data['action']) && $data['action'] == 'savelistname' ) {
    $old_listname = $data['old_listname'];
    $new_listname = $data['new_listname'];
    $password = $data['password'];
    $email = $data['email'];

    $new_password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
    $result = mysqlibinder($mysqli, $sql, 's', [$old_listname]);
    $row = $result->fetch_object();
    $password_hash = $row->password;

    if ( $result->num_rows && ($password_hash == NULL || password_verify($password, $password_hash)) ) { // Old listname and password is ok
    
        $sql = "SELECT * FROM listnames WHERE listname = ? LIMIT 1";
        $result = mysqlibinder($mysqli, $sql, 's', [$new_listname]);

         // Listname is free to use, change listname, password and email
        if ( $result->num_rows == 0 ) {

            $sql = "UPDATE listnames SET listname = ?, `password` = ?, email = ? WHERE listname = ?";
            $result = mysqlibinder($mysqli, $sql, 'ssss', [$new_listname, $new_password_hash, $email, $old_listname]);

            if ( !isset($_SESSION['loggedin']) ) $_SESSION['loggedin'] = [];
            $_SESSION['loggedin'][$new_listname] = [
                'listname' => $new_listname,
                'password_hash' => $new_password_hash,
            ];
            unset($_SESSION['loggedin'][$old_listname]);

            echo json_encode((object)[
                'savelistname' => true,
                'authorized_required' => true,
                'authorized' => true,
                'listname' => $new_listname,
            ]);
            exit;
        }
    }

    echo json_encode((object)[
        'savelistname' => false,
    ]);
    exit;

}


