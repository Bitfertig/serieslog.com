<?php

session_start(['cookie_lifetime' => $_ENV['SESSION_LIFETIME'] ]);

$dbhost = $_ENV['DB_HOST'].':'.$_ENV['DB_PORT'];
$dbname = $_ENV['DB_DATABASE'];
$dbuser = $_ENV['DB_USERNAME'];
$dbpass = $_ENV['DB_PASSWORD'];
