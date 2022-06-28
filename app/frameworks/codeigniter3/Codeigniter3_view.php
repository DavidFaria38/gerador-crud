<?php

class Codeigniter3_view
{

    public bool $validationClientSide;
    private string $dataCreate;
    private string $dataUpdate;
    private string $dataRead;
    
    function __construct()
    {
        $validationClientSide = TRUE;
    }

    public function run(array $dataTable)
    {
        $this->dataCreate = $this->createViewCreate($dataTable, $this->validationClientSide);
        $this->dataUpdate = $this->createViewUpdate($dataTable, $this->validationClientSide);
        $this->dataRead = $this->createViewRead($dataTable, $this->validationClientSide);

        return $this->join();
    }
    private function createViewCreate(array $dataTable, bool $validationClientSide){}
    private function createViewUpdate(array $dataTable, bool $validationClientSide){}
    private function createViewRead(array $dataTable, bool $validationClientSide){}
    private function join(){
        return [$this->dataCreate, $this->dataUpdate, $this->dataRead];
    }
}
