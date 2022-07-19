<?php

class Codeigniter3_routes
{
  public bool $functionDeleteResponseJson;

  public string $fileNameController;
  public string $fileNameModel;
  public string $showName;
  
  public string $fileNameViewCreate;
  public string $fileNameViewRead;
  public string $fileNameViewUpdate;
  public string $dirView;

  public string $functionNameCreate;
  public string $functionNameRead;
  public string $functionNameUpdate;
  public string $functionNameDelete;
  public string $functionNameSufix;

  function __construct(array $config = array())
  {
    // Function names
    $this->functionNameCreate = $config['functionNameCreate'];
    $this->functionNameRead = $config['functionNameRead'];
    $this->functionNameUpdate = $config['functionNameUpdate'];
    $this->functionNameDelete = $config['functionNameDelete'];
    $this->functionNameSufix = $config['functionNameSufix'];
    // File names
    $this->fileNameController = ucfirst($config['fileNameController']);
    $this->fileNameModel = ucfirst($config['fileNameModel']);
    $this->showName = strtolower($config['fileNameShow']);

    $this->fileNameViewCreate = $config['fileNameViewCreate'];
    $this->fileNameViewRead = $config['fileNameViewRead'];
    $this->fileNameViewUpdate = $config['fileNameViewUpdate'];
    $this->dirView = $config['directoryView'];
    // other
    $this->functionDeleteResponseJson = $config['functionDeleteResponseJson'];
  }

  public function run()
  {
    $type_http_delete = ($this->functionDeleteResponseJson) ? 'post' : 'get' ;

    $strRoutes = "/* Routes: {$this->showName} */\n";
    $strRoutes .= "\$route['{$this->showName}']['get'] = '{$this->fileNameController}/{$this->functionNameRead}';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameRead}']['get'] = '{$this->fileNameController}/{$this->functionNameRead}';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameCreate}']['get'] = '{$this->fileNameController}/{$this->functionNameCreate}';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameCreate}']['post'] = '{$this->fileNameController}/{$this->functionNameCreate}_{$this->functionNameSufix}';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameUpdate}/(:num)']['get'] = '{$this->fileNameController}/{$this->functionNameUpdate}/$1';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameUpdate}/(:num)']['post'] = '{$this->fileNameController}/{$this->functionNameUpdate}_{$this->functionNameSufix}/$1';\n";
    $strRoutes .= "\$route['{$this->showName}/{$this->functionNameDelete}/(:num)']['{$type_http_delete}'] = '{$this->fileNameController}/{$this->functionNameDelete}/$1';\n";
    $strRoutes .= "\n";

    return $strRoutes;
  }
}
