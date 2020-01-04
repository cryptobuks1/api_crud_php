<?php

//http://192.168.15.11/api_crud_php/config/conexao.php

date_default_timezone_set('America/Sao_Paulo');

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'hell');
define('DB_PASSWORD', 'hell123');
define('DB_DATABASE', 'api_crud_laravel');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

