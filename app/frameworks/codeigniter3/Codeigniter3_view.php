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
  private function createViewCreate(array $dataTable, bool $validationClientSide)
  {
  }
  private function createViewUpdate(array $dataTable, bool $validationClientSide)
  {
  }
  private function createViewRead(array $dataTable, bool $validationClientSide)
  {
    $html = $this->htmlStart();
    $html .= $this->htmlTable($dataTable);
    $html .= $this->htmlEnd();
  }
  private function join()
  {
    return [$this->dataCreate, $this->dataUpdate, $this->dataRead];
  }

  private function htmlStart()
  {
    $html = '
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="width-view">
            <div class="row">
              <div class="col-md-12">
                <div class="header-view">
                  <div class="container-fluid">
                    <div class="row align-items-center">
                      <div class="col-md-6">
                        <h2 class="text-md-left text-white">Header</h2>
                      </div>
                      <div class="col-md-6">
                        <h5 class="text-md-right text-white">Detalhes 1</h5>
                        <h5 class="text-md-right text-white">Detalhes 2</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-md-8">
                <div class="body-view">
        ';
    return $html;
  }
  private function htmlEnd()
  {
    $html = '
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>';
    return $html;
  }

  private function htmlTable(array $dataTable) {
    $htmlTable = '';
  }
}
