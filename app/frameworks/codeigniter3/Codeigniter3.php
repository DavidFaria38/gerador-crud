<?php

require_once 'app/frameworks/interface/Interface_framework.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_contoller.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_model.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_view.php';

class Codeigniter3 implements Interface_framework
{

  private string $dataController;
  private string $dataModel;
  private array $dataView;
  private array $config;

  function __construct()
  {
    $this->config = array(
      'fileNameController' => 'teste',
      'fileNameModel' => 'test',

      'viewNameCreate' => 'inserir',
      'viewNameRead' => 'consultar',
      'viewNameUpdate' => 'alterar',
      'validationServerSide' => TRUE,

      'validationClientSide' => NULL,
      
      'functionNameCreate' => 'inserir',
      'functionNameRead' => 'consultar',
      'functionNameUpdate' => 'alterar',
      'functionNameDelete' => 'remover',
      'functionNameSufix' => 'salvar',
      'functionDeleteResponseJson' => TRUE,
      
      
      'directoryName' => 'codeigniter3_' . date('Y-m-d_H-i-s'),
    );

  }

  public function createFromTable(array $dataTable)
  {
    $controller = new Codeigniter3_contoller($this->config);
    $model = new Codeigniter3_model($this->config);
    $view = new Codeigniter3_view($this->config);

    $this->dataController = $controller->run($dataTable);
    $this->dataModel = $model->run($dataTable);
    $this->dataView = $view->run($dataTable);

    $this->makeFiles();

    // var_dump("Controller<br><textarea> $this->dataController </textarea>");
    // var_dump("Model<br><textarea> $this->dataModel </textarea>");
    // var_dump("View<br><textarea> $this->dataView </textarea>");
    // die;
  }
  public function makeFiles()
  {
    $dir = "./dump/" . $this->config['directoryName'] . "/";
    // var_dump(mkdir($dir, 0777)); die;

    if (!is_dir("./dump")) {mkdir("./dump", 0777);}
    mkdir($dir, 0777); 
    
    // var_dump("makefile end;");
    $controllerFile = fopen($dir . $this->config['fileNameController'] . '.php', 'w');
    fwrite($controllerFile, $this->dataController);
    fclose($controllerFile);

    var_dump("makefile end;");

  }
}
