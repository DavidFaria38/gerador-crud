<?php

class Codeigniter3_contoller 
{
    public bool $validationServerSide;
    private string $dataCreate;
    private string $dataRead;
    private string $dataUpdate;
    private string $dataDelete;

    function __construct()
    {
        $validationServerSide = TRUE;
    }

    public function run(array $dataTable) {
        $dataCreate = $this->createFunctionCreate($dataTable, $this->validationServerSide);
        $dataRead = $this->createFunctionRead($dataTable, $this->validationServerSide);
        $dataUpdate = $this->createFunctionUpdate($dataTable, $this->validationServerSide);
        $dataDelete = $this->createFunctionDelete($dataTable, $this->validationServerSide);
        
        $strFile = $this->makeFile();

        return $strFile;
    }
    private function createFunctionCreate(array $dataTable, bool $validationServerSide) {}
    private function createFunctionRead(array $dataTable, bool $validationServerSide) {}
    private function createFunctionUpdate(array $dataTable, bool $validationServerSide) {}
    private function createFunctionDelete(array $dataTable, bool $validationServerSide) {}
    private function makeFile() {}
}
