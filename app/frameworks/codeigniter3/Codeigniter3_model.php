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
    $this->dataCreate = $this->createFunctionCreate($dataTable);
    $this->dataRead = $this->createFunctionRead($dataTable);
    $this->dataUpdate = $this->createFunctionUpdate($dataTable);
    $this->dataDelete = $this->createFunctionDelete($dataTable);

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

        return \$db->inserted_id();
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionRead(array $dataTable) // todo: to be done
  {
    $table_name = $this->getTableName($dataTable);
    $str_join = $this->strJoinForeignData($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    $str = "
    public function consulta(\$item_id = NULL)
    {
      \$db = \$this->db;
  
      \$db->select('*');
      \$db->from('{$table_name}');
      {$str_join}
      if (\$item_id) \$db->where('{$field_pk}', \$item_id);
      
      \$data = \$db->get->result();
  
      if (\$item_id && count(\$data) == 1) return \$data[0]; // retornar primeiro item se for pesquisa por id
      return \$data;
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionUpdate(array $dataTable)
  {
    $table_name = $this->getTableName($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    $str = "
    public function {$this->functionNameUpdate}(array \$data_update)
    {
        \$db = \$this->db;

        \$db->where('{$field_pk}', \$data_update['{$field_pk}']);
        \$db->update('$table_name', \$data_update); 

        return \$db->affected_rows();
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionDelete(array $dataTable)
  {
    $table_name = $this->getTableName($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    $str = "
    public function {$this->functionNameDelete}(\$item_id)
    {
        \$db = \$this->db;

        \$db->where('{$field_pk}', \$item_id);
        \$db->delete('$table_name'); 

        return \$db->affected_rows();
    }
    ";
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

  private function strJoinForeignData(array $dataTable)
  {
    $str_join = "";

    $arr_table_foreign_data = array_filter($dataTable, function ($value) { // retornar registro que possuem tabela estrangeira
      return !empty($value[GERADOR_COL_NAMETABLE_FOREIGN]);
    }, ARRAY_FILTER_USE_BOTH);

    // var_dump('<pre>', $arr_table_foreign_data); die;

    foreach ($arr_table_foreign_data as $key => $data_input) { // Gerar joins com tabelas estrangeiras
      $current_table_name = $data_input[GERADOR_COL_NAMETABLE];
      $current_field_name = $data_input[GERADOR_COL_NAMEFIELD_DB];
      $foreign_table_name = $data_input[GERADOR_COL_NAMETABLE_FOREIGN];
      $foreign_primary_key_field_name = $data_input[GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE];
      // $foreign_field_value = $data_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];

      $str_join .= "\$db->join('{$foreign_table_name}', '{$current_table_name}.{$current_field_name} = {$foreign_table_name}.{$foreign_primary_key_field_name}');\n";
    }

    return $str_join;
  }
}
