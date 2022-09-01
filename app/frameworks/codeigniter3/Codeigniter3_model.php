<?php

class Codeigniter3_model
{

  public string $fileNameModel;

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
    $this->functionNameCreate = $config['functionNameCreate'];
    $this->functionNameRead = $config['functionNameRead'];
    $this->functionNameUpdate = $config['functionNameUpdate'];
    $this->functionNameDelete = $config['functionNameDelete'];
    $this->functionNameSufix = $config['functionNameSufix'];
    // File names
    $this->fileNameModel = $config['fileNameModel'];
  }

  public function run(array $dataTable)
  {
    $this->dataCreate = $this->createFunctionCreate($dataTable);
    $this->dataRead = $this->createFunctionRead($dataTable);
    $this->dataUpdate = $this->createFunctionUpdate($dataTable);
    $this->dataDelete = $this->createFunctionDelete($dataTable);

    $strFile = $this->strStartFunction();
    $strFile .= $this->dataRead;
    $strFile .= $this->dataCreate;
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

        return \$db->insert_id();
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionRead(array $dataTable)
  {
    $table_name = $this->getTableName($dataTable);
    $str_join = $this->strJoinForeignData($dataTable);
    $str_search_related_tables = $this->strSearchOtherTables($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];
    
    // se tabela possuir coluna de ativação e desativação de registro 
    $field_activate_register = $this->hasActivateRegister($dataTable);
    $str_activate_register = ($field_activate_register) ? "// \$db->where('{$field_activate_register}', 1);" : "";

    $str = "
    public function {$this->functionNameRead}(\$item_id = NULL)
    {
      \$db = \$this->db;
  
      \$db->select('*');
      \$db->from('{$table_name} as a');
      {$str_join}
      {$str_activate_register}
      if (\$item_id) \$db->where('{$field_pk}', \$item_id);
      
      \$data = \$db->get()->result();
  
      if (\$item_id && count(\$data) == 1) return \$data[0]; // retornar primeiro item se for pesquisa por id
      return \$data;
    }
    ";

    if (!empty($str_search_related_tables)) {
      $str .= "
      public function {$this->functionNameRead}_from_related_tables()
      {
        \$arr_data = array();
          \$db = \$this->db;
          
          {$str_search_related_tables}
          return \$arr_data;
      }
      ";
    }
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionUpdate(array $dataTable)
  {
    $table_name = $this->getTableName($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    // se tabela possuir coluna de ativação e desativação de registro 
    $field_activate_register = $this->hasActivateRegister($dataTable);
    $str_activate_register = ($field_activate_register) ? "// \$db->where('{$field_activate_register}', 1);" : "";

    $str = "
    public function {$this->functionNameUpdate}(array \$data_update)
    {
        \$db = \$this->db;

        \$db->where('{$field_pk}', \$data_update['{$field_pk}']);
        \$db->update('$table_name', \$data_update); 
        {$str_activate_register}

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

    // se tabela possuir coluna de ativação e desativação de registro 
    $field_activate_register = $this->hasActivateRegister($dataTable);
    $str_activate_register = ($field_activate_register) ? "// \$db->where('{$field_activate_register}', 1);" : "";

    $str = "
    public function {$this->functionNameDelete}(\$item_id)
    {
        \$db = \$this->db;

        \$db->where('{$field_pk}', \$item_id);
        \$db->delete('$table_name'); 
        {$str_activate_register}

        return \$db->affected_rows();
    }
    ";
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }

  private function strStartFunction()
  {
    $str = "<?php

    class {$this->fileNameModel} extends CI_Model
    {
    ";

    return $str;
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
      exit(json_encode(['error' => "ERROR:: Não existe um registro com chave primaria; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()"]));
    }
    if (count($arr_registro) > 1) {
      exit(json_encode(['error' => "ERROR:: Existem duas chaves primaria para a mesma tabela; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()"]));
    }

    return $arr_registro[array_key_first($arr_registro)];
  }

  private function getTableName(array $dataTable)
  {
    if (!isset($dataTable[key($dataTable)])) {
      exit(json_encode(['error' => "ERROR: Nenhum dado passado; <br>PATH: Codeigniter3_model.php getTableName()."]));
    }
    if (!isset($dataTable[key($dataTable)][GERADOR_COL_NAMETABLE])) {
      exit(json_encode(['error' => "ERROR: Nome da tabela não foi passado devidamente; <br>PATH: Codeigniter3_model.php getTableName()."]));
    }

    $table_name = $dataTable[key($dataTable)][GERADOR_COL_NAMETABLE];

    return $table_name;
  }

  private function strJoinForeignData(array $dataTable)
  {
    $str_join = "";
    $arr_letters = array_combine(range(0, 24), range('b', 'z')); // array de letras para utilizar como pseudônimo para tabelas de join

    $arr_table_foreign_data = array_filter($dataTable, function ($value) { // retornar registro que possuem tabela estrangeira
      return !empty($value[GERADOR_COL_NAMETABLE_FOREIGN]);
    }, ARRAY_FILTER_USE_BOTH);

    // reindex do array
    $arr_table_foreign_data = array_values($arr_table_foreign_data);

    if (count($arr_table_foreign_data) >= 25) {
      $count = count($arr_table_foreign_data);
      exit(json_encode(['error' => "ERROR:: Não há nomes de pseudônimo suficientes para esse quantidade de tabelas estrangeira. <br> Pseudônimos utilizados pelo sistema (a -> z), quantidade de tabelas utilizadas ({$count})"]));
    }

    foreach ($arr_table_foreign_data as $key => $data_input) { // Gerar joins com tabelas estrangeiras
      $main_table_name = $data_input[GERADOR_COL_NAMETABLE];
      $main_field_name = $data_input[GERADOR_COL_NAMEFIELD_DB];
      $main_table_alias = 'a'; // pseudônimo para tabela principal
      $foreign_table_name = $data_input[GERADOR_COL_NAMETABLE_FOREIGN];
      $foreign_primary_key_field_name = $data_input[GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE];
      $foreign_table_alias = $arr_letters[$key]; // pseudônimo para tabela
      // $foreign_field_value = $data_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];

      $str_join .= "\$db->join('{$foreign_table_name} as {$foreign_table_alias}', '{$foreign_table_alias}.{$foreign_primary_key_field_name} = {$main_table_alias}.{$main_field_name}', 'left');\n";
    }

    return $str_join;
  }

  private function strSearchOtherTables(array $dataTable)
  {
    $str_join = "";

    $arr_table_foreign_data = array_filter($dataTable, function ($value) { // retornar registro que possuem tabela estrangeira
      return !empty($value[GERADOR_COL_NAMETABLE_FOREIGN]);
    }, ARRAY_FILTER_USE_BOTH);

    // var_dump('<pre>', $arr_table_foreign_data); die;

    foreach ($arr_table_foreign_data as $key => $data_input) { // Gerar joins com tabelas estrangeiras
      $foreign_table_name = $data_input[GERADOR_COL_NAMETABLE_FOREIGN];

      $str_join .= "
      \$db->select('*');
      \$db->from('{$foreign_table_name}');
      \$data = \$db->get()->result();
      \$arr_data['{$foreign_table_name}'] = \$data;\n";
    }

    return $str_join;
  }

  private function hasActivateRegister(array $dataTable)
  {

    foreach ($dataTable as $key => $data_input) {
      $input_name = $data_input[GERADOR_COL_NAMEFIELD_DB];
      $activate_register = $this->strposa($input_name, GERADOR_ATIVAR_REGISTRO);

      if ($activate_register) {
        return $input_name;
      }
    }
    return FALSE;
  }

  private function strposa(string $haystack, array $needles, int $offset = 0)
  {
    foreach ($needles as $needle) {
      if (strpos($haystack, $needle, $offset) !== false) {
        return true; // stop on first true result
      }
    }

    return false;
  }
}
