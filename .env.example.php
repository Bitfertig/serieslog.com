<?php

$_ENV = [
    'DB_CONNECTION' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => 3306,
    'DB_DATABASE' => 'serieslog',
    'DB_USERNAME' => '',
    'DB_PASSWORD' => '',
    'SESSION_LIFETIME' =>  86400 * 30 * 6, // 6 Monate
    'SESSION_SAVEPATH' => ini_get('session.save_path'),
    'WORKER_KEY' => '',
    'OMDB_APIKEY' => '', // http://www.omdbapi.com/
];