<?php

require_once 'app/frameworks/interface/Interface_framework.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_contoller.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_model.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_view.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_routes.php';

class Codeigniter3 implements Interface_framework
{
  private string $fileExtention = ".php";
  private string $frameworkName = "codeigniter_3";
  private string $dataController;
  private string $dataModel;
  private array $arrDataView;
  private string $dataRoutes;
  private array $config;

  function __construct(array $config)
  {
    $this->config = array(
      'fileNameController' => '',
      'fileNameModel' => '',

      'fileNameViewCreate' => $config['fileNameViewCreate'],
      'fileNameViewRead' => $config['fileNameViewRead'],
      'fileNameViewUpdate' => $config['fileNameViewUpdate'],
      
      'functionNameCreate' => $config['functionNameCreate'],
      'functionNameRead' => $config['functionNameRead'],
      'functionNameUpdate' => $config['functionNameUpdate'],
      'functionNameDelete' => $config['functionNameDelete'],
      'functionNameSufix' => $config['functionNameSufix'],
      'functionDeleteResponseJson' => $config['functionDeleteResponseJson'],
      
      'directoryName' => $config['directoryName'],
      'directoryView' => '',

      'strOptionalControllerConstructor' => "\nif (!is_logged_sistema()) return redirect(base_url_sistema('login'));", // para inserir no __constructor do controller
      'strOptionalPathModel' => "sistema/evento/", // para inserir no __constroctor do controller, caminho do arquivo model
      'strOptionalPathView' => "sistema/evento/", // para inserir no controller, caminho do arquivo view
      'strOptionalPreBaseUrl' => "sistema/", // prefixo para campo de redirecionamento, controller e views
      'strOptionalUrlPath' => "sistema/", // para inserir na url de routes, url para acesso
      'strOptionalUrlControllerPath' => "sistema/evento/", // para inserir no caminho do controller em routes
    );

  }

  public function createFromTable(array $dataTable)
  {
    // configuração de nomes de arquivos por nome de tabela
    $table_name = $dataTable[0][GERADOR_COL_NAMETABLE];
    $file_name = ucfirst(strtolower($table_name));
    $file_name = str_replace('T_', '', $file_name);
    $file_name = ucfirst($file_name);
    $this->config['fileNameController'] = "{$file_name}_controller";
    $this->config['fileNameModel'] = "{$file_name}_model";
    $this->config['fileNameShow'] = $file_name;
    $this->config['directoryView'] = strtolower($file_name);


    $controller = new Codeigniter3_contoller($this->config);
    $model = new Codeigniter3_model($this->config);
    $view = new Codeigniter3_view($this->config);
    $routes = new Codeigniter3_routes($this->config);

    $this->dataController = $controller->run($dataTable);
    $this->dataModel = $model->run($dataTable);
    $this->arrDataView = $view->run($dataTable);
    $this->dataRoutes = $routes->run();

    return $this->makeFiles();
  }

  public function makeFiles()
  {
    $path = str_replace('app\frameworks\codeigniter3', '', __DIR__);

    // definindo diretorios dos arquivos
    chdir($path);
    $dir_dump = $path . "dump";
    $dir_framework = $dir_dump . "/" . $this->frameworkName;
    $dir_crud = $dir_framework . '/' . $this->config['directoryName'];
    $dir_controller = $dir_crud . "/controllers/";
    $dir_model = $dir_crud . "/models/";
    $dir_view = $dir_crud . "/views/";
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
    
    // criar arquivo model
    $file_routes = fopen($dir_crud . '/routes.txt', 'a');
    fwrite($file_routes, $this->dataRoutes);
    fclose($file_routes);

    return dirname($dir_crud);

  }
}
