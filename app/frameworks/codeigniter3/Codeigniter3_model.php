<?php

class Codeigniter3_model
{

  public string $fileNameModel;
  public string $showNameModel;

  public string $functionNameCreate;
  public string $functionNameRead;
  public string $functionNameUpdate;
  public string $functionNameDelete;
  public string $functionNameSufix;

  private string $dataCreate;
  private string $dataRead;
  private string $dataUpdate;
  private string $dataDelete;

  function __construct(array $config = array())
  {
    // Function names
    $this->functionNameCreate = (isset($config['functionNameCreate']) && !empty($config['functionNameCreate'])) ? $config['functionNameCreate'] : 'insert';
    $this->functionNameRead = (isset($config['functionNameRead']) && !empty($config['functionNameRead'])) ? $config['functionNameRead'] : 'read';
    $this->functionNameUpdate = (isset($config['functionNameUpdate']) && !empty($config['functionNameUpdate'])) ? $config['functionNameUpdate'] : 'update';
    $this->functionNameDelete = (isset($config['functionNameDelete']) && !empty($config['functionNameDelete'])) ? $config['functionNameDelete'] : 'delete';
    $this->functionNameSufix = (isset($config['functionNameSufix']) && !empty($config['functionNameSufix'])) ? $config['functionNameSufix'] : 'save';
    // File names
    $this->fileNameModel = (isset($config['fileNameModel']) && !empty($config['fileNameModel'])) ? $config['fileNameModel'] : 'Generic_model';
    $this->showNameModel = strtolower($this->fileNameModel);
  }

  public function run(array $dataTable)
  {
    $dataCreate = $this->createFunctionCreate($dataTable);
    $dataRead = $this->createFunctionRead($dataTable);
    $dataUpdate = $this->createFunctionUpdate($dataTable);
    $dataDelete = $this->createFunctionDelete($dataTable);

    $strFile = $this->strStartFunction();
    $strFile .= $this->dataCreate;
    $strFile .= $this->dataRead;
    $strFile .= $this->dataUpdate;
    $strFile .= $this->dataDelete;
    $strFile .= $this->strEndFunction();

    return $strFile;
  }
  private function createFunctionCreate(array $dataTable)
  {
    $table_name = $this->getTableName($dataTable);

    $str = "
    public function {$this->functionNameCreate}(array \$data_insert)
    {
        \$db = \$this->db;

        \$db->insert('$table_name', \$data_insert); 

        return \$db->affected_rows();
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionRead(array $dataTable) // todo: to be done
  {
    $table_name = $this->getTableName($dataTable);
    $table_foreign_data = $this->getTableForeignData($dataTable);

    $str = "
    public function consulta(\$item_id = NULL)
    {
      \$db = \$this->db;
  
      \$db->select('*');
      \$db->from('{$table_name}');
      \$db->join('tabela_join as b', 'a.X = b.Y'); // obs: ser possuir tabela estrangeira
      
      if (\$item_id) \$db->where('coluna', \$item_id); // todo: inserir coluna de tablea  
      
      \$data = \$db->get->result();
  
      if (\$item_id && count(\$data) > 0) return \$data[0];
      return \$data;
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionUpdate(array $dataTable)
  {
    $str = $this->strAlterar($dataTable);
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionDelete(array $dataTable)
  {
    $str = $this->strRemover($dataTable);
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }

  private function strStartFunction() // todo: fazer gerar o nome do model correto
  {
    return "
    <?php

    class {$this->fileNameModel} extends CI_Model
    {
    ";
  }
  private function strEndFunction()
  {
    return "}";
  }

  /* Funções auxiliares */
  private function strPhpValidation(array $dataTable)
  {

    if ($this->validationServerSide) {
      $strDataPhpValidation = "";

      foreach ($dataTable as $key => $dataInput) {

        $nomeCampoDB = $dataInput['gerbas_CampoNomeDB'];
        $nomeCampoHTML = $dataInput['gerbas_campoTitleHTML'];
        $inputRequired = ($dataInput['gerbas_required']) ? '|required' : '';
        $inputEmail = ($dataInput['gerbas_tipoConsistencia'] == TYPE_EMAIL) ? '|valid_email' : '';
        $inputMaxLength = (!empty($dataInput['gerbas_tamanhoMax'])) ? "|max_length[{$dataInput['gerbas_tamanhoMax']}]" : '';
        $inputMinLength = (!empty($dataInput['gerbas_tamanhoMin'])) ? "|max_length[{$dataInput['gerbas_tamanhoMin']}]" : '';

        $strDataPhpValidation .= "\$this->form_validation->set_rules('{$nomeCampoDB}', '{$nomeCampoHTML}', 'trim{$inputRequired}{$inputEmail}{$inputMinLength}{$inputMaxLength}');";
        $strDataPhpValidation .= "\n";
      }
      return $strDataPhpValidation;
    } else {
      return "";
    }
  }

  private function strPhpArray(array $dataTable, string $arrayFrom = '$data')
  {
    $str = "array(";

    foreach ($dataTable as $key => $dataInput) {
      $nomeCampoDB = $dataInput['gerbas_CampoNomeDB'];
      $str .= "'{$nomeCampoDB}' => {$arrayFrom}['{$nomeCampoDB}'],\n";
    }
    $str .= ");";

    return $str;
  }

  private function getRegistroPrimaryKey(array $dataTable)
  {
    $arr_registro = array_filter($dataTable, function ($value) { // retornar registro que possui chave primaria
      return $value[GERADOR_COL_PK];
    }, ARRAY_FILTER_USE_BOTH);

    if (empty($arr_registro)) {
      exit('ERROR:: Não existe um registro com chave primaria; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()');
    }
    if (count($arr_registro) > 1) {
      exit('ERROR:: Existem duas chaves primaria para a mesma tabela; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()');
    }

    return $arr_registro[0];
  }

  private function getTableName(array $dataTable)
  {
    if (!isset($dataTable[key($dataTable)])) {
      exit('ERROR: Nenhum dado passado; <br>PATH: Codeigniter3_model.php getTableName().');
    }
    if (!isset($dataTable[key($dataTable)][GERADOR_COL_NAMETABLE])) {
      exit('ERROR: Nome da tabela não foi passado devidamente; <br>PATH: Codeigniter3_model.php getTableName().');
    }

    $table_name = $dataTable[key($dataTable)][GERADOR_COL_NAMETABLE];

    return $table_name;
  }

  private function getTableForeignData(array $dataTable)
  {
    $arr_table_foreign_data = array_filter($dataTable, function ($value) { // retornar registro que possuem tabela estrangeira
      return !empty($value[GERADOR_COL_NAMETABLE_FOREIGN]);
    }, ARRAY_FILTER_USE_BOTH);

    return $arr_table_foreign_data;
  }
}
