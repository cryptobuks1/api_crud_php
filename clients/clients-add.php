<?php

  //http://192.168.15.11/api_crud_php/clients/clients-add.php

  include('./../config/conexao.php');

  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
  header('Content-Type: application/json; charset=utf-8');

  $postjson = json_decode(file_get_contents('php://input'), true);

  if($postjson['requisicao'] == 'add'){
    $query = mysqli_query($mysqli, "INSERT INTO clients SET name = '$postjson[name]', phone = '$postjson[phone]', email = '$postjson[email]', created_at = curDate()");
  }