<?php

require_once 'app/frameworks/interface/Interface_framework.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_contoller.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_model.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_view.php';

class Codeigniter3 implements Interface_framework
{
  private string $fileExtention = ".php";
  private string $frameworkName = "codeigniter_3";
  private string $dataController;
  private string $dataModel;
  private array $arrDataView;
  private array $config;

  function __construct(array $config)
  {
    $this->config = array(
      'fileNameController' => '',
      'fileNameModel' => '',

      'fileNameViewCreate' => $config['fileNameViewCreate'],
      'fileNameViewRead' => $config['fileNameViewRead'],
      'fileNameViewUpdate' => $config['fileNameViewUpdate'],
      
      'validationServerSide' => $config['validationServerSide'],
      'validationClientSide' => $config['validationClientSide'],
      
      'functionNameCreate' => $config['functionNameCreate'],
      'functionNameRead' => $config['functionNameRead'],
      'functionNameUpdate' => $config['functionNameUpdate'],
      'functionNameDelete' => $config['functionNameDelete'],
      'functionNameSufix' => $config['functionNameSufix'],
      'functionDeleteResponseJson' => $config['functionDeleteResponseJson'],
      
      'directoryName' => $config['directoryName'],
      'directoryView' => '',
    );

  }

  public function createFromTable(array $dataTable)
  {
    // configuração de nomes de arquivos por nome de tabela
    $table_name = $dataTable[0][GERADOR_COL_NAMETABLE];
    $file_name = str_replace('T', '', $table_name);
    $file_name = ucfirst($file_name);
    $this->config['fileNameController'] = $file_name;
    $this->config['fileNameModel'] = $file_name;
    $this->config['directoryView'] = strtolower($file_name);


    $controller = new Codeigniter3_contoller($this->config);
    $model = new Codeigniter3_model($this->config);
    $view = new Codeigniter3_view($this->config);

    $this->dataController = $controller->run($dataTable);
    $this->dataModel = $model->run($dataTable);
    $this->arrDataView = $view->run($dataTable);

    $this->makeFiles();
  }
  public function makeFiles()
  {
    // definindo diretorios dos arquivos
    $dir_dump = "./dump";
    $dir_framework = $dir_dump . "/" . $this->frameworkName;
    $dir_crud = $dir_framework . '/' . $this->config['directoryName'];
    $dir_controller = $dir_crud . "/controller/";
    $dir_model = $dir_crud . "/model/";
    $dir_view = $dir_crud . "/view/";
    $dir_view_item = $dir_view . $this->config['directoryView'] . "/";

    // criando diretorios para arquivos
    if (!is_dir($dir_dump)) {mkdir($dir_dump, 0777);}
    if (!is_dir($dir_framework)) {mkdir($dir_framework, 0777);}
    if (!is_dir($dir_crud)) {mkdir($dir_crud, 0777);}
    if (!is_dir($dir_controller)) {mkdir($dir_controller, 0777);}
    if (!is_dir($dir_model)) {mkdir($dir_model, 0777);}
    if (!is_dir($dir_view)) {mkdir($dir_view, 0777);}
    if (!is_dir($dir_view_item)) {mkdir($dir_view_item, 0777);}

    // criar arquivo controller
    $file_controller = fopen($dir_controller . $this->config['fileNameController'] . $this->fileExtention, 'w');
    fwrite($file_controller, $this->dataController);
    fclose($file_controller);
    
    // criar arquivo model
    $file_model = fopen($dir_model . $this->config['fileNameModel'] . $this->fileExtention, 'w');
    fwrite($file_model, $this->dataModel);
    fclose($file_model);
    
    // criar arquivos views
    foreach ($this->arrDataView as $key => $dataView) {
      $file_view = fopen($dir_view_item . $dataView['fileName'] . $this->fileExtention, 'w');
      fwrite($file_view, $dataView['fileData']);
      fclose($file_view);
    }

    var_dump("makefile end;");

  }
}
