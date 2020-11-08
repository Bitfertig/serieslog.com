<?php

ini_set('session.cookie_lifetime', $_ENV['SESSION_LIFETIME']);
ini_set('session.gc_maxlifetime', $_ENV['SESSION_LIFETIME']);
session_start();

$dbhost = $_ENV['DB_HOST'].':'.$_ENV['DB_PORT'];
$dbname = $_ENV['DB_DATABASE'];
$dbuser = $_ENV['DB_USERNAME'];
$dbpass = $_ENV['DB_PASSWORD'];
