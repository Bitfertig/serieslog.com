<?php

if ( !file_exists(__DIR__.'/.env.php') ) die('Error: Missing environment settings.');
include '.env.php';
include 'function.php';
include 'setup.php';

#if ( !isset($_GET['run']) || $_GET['run'] != $_ENV['WORKER_KEY'] ) exit;



#$result = mysqlibinder($mysqli, $sql, '', []);
#$series = getSeriesByTitle($title);
#var_export($series);


