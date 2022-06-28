<?php

require_once 'Codeigniter3_contoller';
require_once 'Codeigniter3_model';
require_once 'Codeigniter3_view';

class Codeigniter3 implements Interface_framework
{

    private string $dataController;
    private string $dataModel;
    private string $dataView;

    function __construct()
    {
    }

    public function createFromTable(array $dataTable){
        $controller = new Codeigniter3_contoller();
        $model = new Codeigniter3_model();
        $view = new Codeigniter3_view();
    }
    public function makeFiles(){}

}
