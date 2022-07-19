<?php

require_once 'app/DataGerador.php';
require_once 'app/config/constants.php';
require_once 'app/config/Router.php';
require_once 'app/config/Request.php';
require_once 'app/Main.php';

$router = new Router(new Request);

$router->get('/', function () {
  include('app/public/home.php');
});

$router->post('/get_tables', function () {
  $dataGerador = new DataGerador();

  $table_name = $dataGerador->getTablesNameFromDB();
  $gerador_data = $dataGerador->getAllDataFromDB();

  $json = array(
    'table_name' => $table_name,
    'gerador_data' => $gerador_data,
  );

  return json_encode($json);
});

$router->get('/make', function () {
  $selectedTables = $_GET['selectedTables'];
  $frameworkType = $_GET['frameworkType'];

  $config = array(
    'selectedTables' => $selectedTables,
    'frameworkType' => $frameworkType,
  );

  $main = new Main();
  $dump_dir = $main->run($config);

  return json_encode(array(
    'success' => $dump_dir
  ));
});

$router->get('/create_database', function () {
  $main = new Main();
  // $main->makeDB();
  
  header('Location : http://localhost/git/gerador_crud/', true, 200); die;
});
