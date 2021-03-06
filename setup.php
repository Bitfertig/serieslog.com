<?php

ini_set('session.cookie_lifetime', $_ENV['SESSION_LIFETIME']);
ini_set('session.gc_maxlifetime', $_ENV['SESSION_LIFETIME']);
ini_set('session.save_path', $_ENV['SESSION_SAVEPATH']);
session_start();

$dbhost = $_ENV['DB_HOST'].':'.$_ENV['DB_PORT'];
$dbname = $_ENV['DB_DATABASE'];
$dbuser = $_ENV['DB_USERNAME'];
$dbpass = $_ENV['DB_PASSWORD'];

$GLOBALS['mysqli'] = $mysqli = mysqli_connection($dbhost, $dbuser, $dbpass, $dbname);

if ( !isset($_SESSION['csrf']) ) $_SESSION['csrf'] = rand(1000, getrandmax());
