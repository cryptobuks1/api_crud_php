<?php

  //http://192.168.15.11/api_crud_php/clients/clients.php

  include('./../config/conexao.php');

  //Auth 01
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); 
  header('Content-Type: application/json; charset=utf-8'); 

  //Auth 02
  /*
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Accept, Content-Type, Authorization, X-Requested-With');
  header('Accept: application/json, Content-Type: application/json; charset=utf-8');
  */

  //No-Auth
  /*
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Credentials: false');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
  header('Access-Control-Allow-Headers: Accept, Content-Type');
  header('Accept: application/json, Content-Type: application/json; charset=utf-8');
  */

  $postjson = json_decode(file_get_contents('php://input'), true);

  //Inserindo os registros
  if($postjson['method'] == 'post'){
    $query = mysqli_query($mysqli, "INSERT INTO clients SET name = '$postjson[name]', phone = '$postjson[phone]', email = '$postjson[email]', created_at = curDate()");

    $id = mysqli_insert_id($mysqli);

    if($query){
      $result = json_encode(array('success' => true, 'id' => $id));
    }else{
      $result = json_encode(array('success' => false));
    }
    echo $result;

  //Recuperando os registros
  }elseif($postjson['method'] == 'get'){
    $query = mysqli_query($mysqli, "SELECT * FROM clients ORDER BY id DESC LIMIT $postjson[scroolStart], $postjson[scroolLimit]");

    while($row = mysqli_fetch_array($query)){
      $dados[] = array(
        'id' => $row['id'],
        'name' => $row['name'],
        'phone' => $row['phone'],
        'email' => $row['email'],
        'created_at' => $row['created_at'],
        'updated_at' => $row['updated_at']
      );      
    }

    if($query){
      $result = json_encode(array('success' => true, 'result' => $dados));
    }else{
      $result = json_encode(array('success' => false));
    }
    echo $result;

  //Atualizando os registros
  }elseif($postjson['method'] == 'put'){
    $query = mysqli_query($mysqli, "UPDATE clients SET name = '$postjson[name]', phone = '$postjson[phone]', email = '$postjson[email]', updated_at = curDate() WHERE id = '$postjson[id]'");
  
    if($query){
      $result = json_encode(array('success'=>true, 'result'=>'success'));
  
    }else{
      $result = json_encode(array('success'=>false, 'result'=>'error'));
  
    }
    echo $result;
  
  //Deletando os registros  
  }elseif($postjson['method'] == 'delete'){
    $query = mysqli_query($mysqli, "DELETE FROM clients WHERE id = '$postjson[id]'");
  
    if($query){
      $result = json_encode(array('success'=>true, 'result'=>'success'));
  
    }else{
      $result = json_encode(array('success'=>false, 'result'=>'error'));
  
    }
    echo $result;
          
  //Procurando o registro pelo nome
  }elseif($postjson['method'] == 'search'){
    $name = $postjson['name'].'%';
    $query = mysqli_query($mysqli, "SELECT * FROM clients WHERE name LIKE '$name' ORDER BY name ASC");
  
    while($row = mysqli_fetch_array($query)){ 
      $dados[] = array(
        'id' => $row['id'], 
        'name' => $row['name'],
        'phone' => $row['phone'],
        'email' => $row['email'],
        'created_at' => $row['created_at'],
        'updated_at' => $row['updated_at']    
      );
  
  }
  
  if($query){
      $result = json_encode(array('success'=>true, 'result'=>$dados));
  
    }else{
      $result = json_encode(array('success'=>false));
  
    }
    echo $result;
  
  //Fazendo o login
  }elseif($postjson['method'] == 'auth'){
    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE email = '$postjson[email]' AND password = '$postjson[password]'");
    $row = mysqli_num_rows($query);

    if($row>0){
      $data = mysqli_fetch_array($query);

      /*
      $datauser = array(
        'id' => $data['id'],
        'name' => $data['name'],
        'phone' => $data['phone'],
        'email' => $data['email'],
        'password' => $data['password'],
        'level' => $data['level'],
        'created_at' => $data['created_at'],
        'updated_at' => $data['updated_at']
      );
      */

      $datauser = array(
        'id' => $data['id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password']
      );
  
      if($data['level'] == 'admin'){
        $result = json_encode(array('success'=>true, 'result'=>$datauser));
      }else{
        $result = json_encode(array('success'=>false, 'msg'=>'Usuário sem Permissão'));
      }
    }else{
      $result = json_encode(array('success'=>false, 'msg'=>'Dados Incorretos!'));
    }
  
    echo $result;
  }