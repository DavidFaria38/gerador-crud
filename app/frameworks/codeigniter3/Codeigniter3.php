<?php

require_once 'app/frameworks/interface/Interface_framework.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_contoller.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_model.php';
require_once 'app/frameworks/codeigniter3/Codeigniter3_view.php';

class Codeigniter3 implements Interface_framework
{

  private string $dataController;
  private string $dataModel;
  private string $dataView;

  function __construct()
  {
  }

  public function createFromTable(array $dataTable)
  {
    $controller = new Codeigniter3_contoller();
    $model = new Codeigniter3_model();
    // $view = new Codeigniter3_view();

    $this->dataController = $controller->run($dataTable);
    // $this->dataModel = $model->run($dataTable);
    // $this->dataView = $view->run($dataTable);

    // $this->makeFiles();

    var_dump("<textarea> $this->dataController </textarea>");
    // var_dump("<textarea> $this->dataModel </textarea>");
    // var_dump("<textarea> $this->dataView </textarea>");
    // die;
  }
  public function makeFiles()
  {
  }
}
