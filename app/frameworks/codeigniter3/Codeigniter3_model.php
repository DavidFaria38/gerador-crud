<?php

class Codeigniter3_model 
{

    public string $fileName;
    public string $showName;
    private string $dataCreate;
    private string $dataRead;
    private string $dataUpdate;
    private string $dataDelete;
    
    function __construct($fileName = '', $showName = '')
    {
        $fileName = '';
        $showName = '';
    }

    public function run(array $dataTable) {
        $dataCreate = $this->createFunctionCreate($dataTable);
        $dataRead = $this->createFunctionRead($dataTable);
        $dataUpdate = $this->createFunctionUpdate($dataTable);
        $dataDelete = $this->createFunctionDelete($dataTable);
        
        $strFile = $this->joinFunctions();

        return $strFile;
    }
    private function createFunctionCreate(array $dataTable) {}
    private function createFunctionRead(array $dataTable) {}
    private function createFunctionUpdate(array $dataTable) {}
    private function createFunctionDelete(array $dataTable) {}

    private function startFunction(){
        return "";
    }
    private function endFunction(){
        return "";
    }

    private function joinFunctions() {
        $strFile = $this->startFunction();
        $strFile += $this->dataCreate;
        $strFile += $this->dataRead;
        $strFile += $this->dataUpdate;
        $strFile += $this->dataDelete;
        $strFile = $this->endFunction();
        
    }

}
