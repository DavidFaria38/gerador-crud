<?php

class Codeigniter3_contoller
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

  private string $dataCreate;
  private string $dataRead;
  private string $dataUpdate;
  private string $dataDelete;


  private string $strOptionalControllerConstructor;
  private string $strOptionalPathModel;
  private string $strOptionalPathView;
  private string $strOptionalPreBaseUrl;

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
    
    // optional
    $this->strOptionalControllerConstructor = $config['strOptionalControllerConstructor'];
    $this->strOptionalPathModel = $config['strOptionalPathModel'];
    $this->strOptionalPathView = $config['strOptionalPathView'];
    $this->strOptionalPreBaseUrl = $config['strOptionalPreBaseUrl'];
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
    $str = $this->strInserir($dataTable);
    $str .= $this->strInserir_salvar($dataTable);
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionRead(array $dataTable)
  {
    $str = $this->strConsultar($dataTable);
    // var_dump("<textarea> $str </textarea>");
    // die;

    return $str;
  }
  private function createFunctionUpdate(array $dataTable)
  {
    $str = $this->strAlterar($dataTable);
    $str .= $this->strAlterar_salvar($dataTable);
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

  private function strStartFunction()
  {
    $str = "<?php

    class {$this->fileNameController} extends CI_Controller
    {
      public function __construct()
      {
        parent::__construct();
        {$this->strOptionalControllerConstructor}

        \$this->load->model('{$this->strOptionalPathModel}{$this->fileNameModel}', '{$this->showName}');
      }
    ";
    return $str;
  }
  private function strEndFunction()
  {
    return "}";
  }

  /* Funções auxiliares */
  private function strPhpValidation(array $dataTable, bool $validationUpdate = FALSE)
  {
    if ($validationUpdate) {
      // retorna os registros que são chave primaria ou não possuem campo hidden 
      $arr_table_data_selected = array_filter($dataTable, function ($value) {
        return $value[GERADOR_COL_PK] || !$value[GERADOR_COL_HIDDEN];
      }, ARRAY_FILTER_USE_BOTH);
    } else {
      // retorna os registros que não possuem campo hidden 
      $arr_table_data_selected = array_filter($dataTable, function ($value) {
        return !$value[GERADOR_COL_HIDDEN];
      }, ARRAY_FILTER_USE_BOTH);
    }

    $strDataPhpValidation = "";

    foreach ($arr_table_data_selected as $key => $dataInput) {

      $nomeCampoDB = $dataInput[GERADOR_COL_NAMEFIELD_DB];
      $nomeCampoHTML = $dataInput[GERADOR_COL_NAMEFIELD_HTML];
      $inputRequired = ($dataInput[GERADOR_COL_REQUIRED]) ? '|required' : '';
      $inputEmail = ($dataInput[GERADOR_COL_TYPE_VALIDATION] == TYPE_EMAIL) ? '|valid_email' : '';
      $inputMinLength = (!empty($dataInput[GERADOR_COL_MIN_LENGTH]) && $dataInput[GERADOR_COL_MIN_LENGTH] != -1) ? "|min_length[{$dataInput[GERADOR_COL_MIN_LENGTH]}]" : '';
      $inputMaxLength = (!empty($dataInput[GERADOR_COL_MAX_LENGTH]) && $dataInput[GERADOR_COL_MAX_LENGTH] != -1) ? "|max_length[{$dataInput[GERADOR_COL_MAX_LENGTH]}]" : '';

      $strDataPhpValidation .= "\$this->form_validation->set_rules('{$nomeCampoDB}', '{$nomeCampoHTML}', 'trim{$inputRequired}{$inputEmail}{$inputMinLength}{$inputMaxLength}');";
      $strDataPhpValidation .= "\n";
    }
    return $strDataPhpValidation;
  }

  private function strControllerArray(array $dataTable, string $arrayFrom = '$data', bool $validationUpdate = FALSE)
  {
    if ($validationUpdate) {
      // retorna os registros que são chave primaria, não possuem campo hidden ou possuem uma função padrão para um campo na alteração 
      $arr_table_data_selected = array_filter($dataTable, function ($value) {
        return $value[GERADOR_COL_PK] || !$value[GERADOR_COL_HIDDEN] || (trim($value[GERADOR_COL_FUNCTION_FIELD_TYPE]) == 'update');
      }, ARRAY_FILTER_USE_BOTH);
    } else {
      // retorna os registros que não possuem campo hidden ou possuem uma função padrão para um campo na inserção
      $arr_table_data_selected = array_filter($dataTable, function ($value) {
        return !$value[GERADOR_COL_HIDDEN] || (trim($value[GERADOR_COL_FUNCTION_FIELD_TYPE]) == 'create');
      }, ARRAY_FILTER_USE_BOTH);
    }

    $str = "array(";

    foreach ($arr_table_data_selected as $key => $dataInput) {
      $nomeCampoDB = $dataInput['gerbas_CampoNomeDB'];
      $type_field = $dataInput[GERADOR_COL_TYPEFIELD_HTML];
      $function_field = trim($dataInput[GERADOR_COL_FUNCTION_FIELD]);

      if ($type_field == 'checkbox' || $type_field == 'radio') {
        $str .= "'{$nomeCampoDB}' => (isset({$arrayFrom}['{$nomeCampoDB}']) && {$arrayFrom}['{$nomeCampoDB}'] == 'on') ? TRUE : FALSE ,\n";
      } else if (!empty($function_field)) {
        $str .= "'{$nomeCampoDB}' => {$function_field},\n";
      } else {
        $str .= "'{$nomeCampoDB}' => {$arrayFrom}['{$nomeCampoDB}'],\n";
      }
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

    return $arr_registro[array_key_first($arr_registro)];
  }

  private function strSearchOtherTables(array $dataTable)
  {
    $str_join = "";

    // retornar registro que possuem tabela estrangeira
    $arr_table_foreign_data = array_filter($dataTable, function ($value) {
      return !empty($value[GERADOR_COL_NAMETABLE_FOREIGN]);
    }, ARRAY_FILTER_USE_BOTH);

    // Gerar joins com tabelas estrangeiras
    foreach ($arr_table_foreign_data as $key => $data_input) {
      $foreign_table_name = $data_input[GERADOR_COL_NAMETABLE_FOREIGN];

      $str_join .= "
      \$db->select('*');
      \$db->from('{$foreign_table_name}');
      \$data = \$db->get()->result();
      \$arr_data['{$foreign_table_name}'] = \$data;\n";
    }

    return $str_join;
  }

  /* Funções para createFunctionCreate() */
  private function strInserir(array $dataTable)
  {
    $str_search_related_tables = $this->strSearchOtherTables($dataTable);

    if (!empty($str_search_related_tables)) {
      $str = "
      public function {$this->functionNameCreate}()
      {
        \$data_related_tables = \$this->{$this->showName}->{$this->functionNameRead}_from_related_tables();
        
        \$data_view = array(
          'data_related_tables' => \$data_related_tables,
        );

        render_template('{$this->strOptionalPathView}{$this->dirView}/{$this->fileNameViewCreate}', \$data_view);
      }
      ";
    } else {
      $str = "
      public function {$this->functionNameCreate}()
      {
        render_template('{$this->strOptionalPathView}{$this->dirView}/{$this->fileNameViewCreate}');
      }
      ";
    }

    return $str;
  }
  private function strInserir_salvar(array $dataTable)
  {
    $strDataPhpValidation = $this->strPhpValidation($dataTable, FALSE);
    $strDataArray = $this->strControllerArray($dataTable, '$data_post', FALSE);

    $str = "
    public function {$this->functionNameCreate}_{$this->functionNameSufix}(\$item_id = 0)
    {
      // \$usr_codigo = session_codigo_usr();
    
      {$strDataPhpValidation}

      if (!\$this->form_validation->run()) {
        \$this->{$this->functionNameCreate}(\$item_id);
      } else {
  
        \$data_post = \$this->input->post();
  
        \$data_insert = {$strDataArray}
  
        \$linha = \$this->{$this->showName}->{$this->functionNameCreate}(\$data_insert);
  
        if (empty(\$linha)) {
          set_flash_message_danger('error', 'Não foi possivel inserir o registro, tente novamente.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameCreate}'));
        } else {
          set_flash_message_success('success', 'Registro inserido com sucesso!');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }
      }
    }
    ";

    return $str;
  }

  /* Funções para createFunctionRead() */
  private function strConsultar(array $dataTable)
  {
    $str = "
    public function {$this->functionNameRead}()
    {
      \$dados_item = \$this->{$this->showName}->{$this->functionNameRead}();

      \$data_view = array(
        'data' => \$dados_item
      );

      render_template('{$this->strOptionalPathView}{$this->dirView}/{$this->fileNameViewRead}', \$data_view);
    }
    ";

    return $str;
  }

  /* Funções para createFunctionUpdate() */
  private function strAlterar(array $dataTable)
  {
    $str_search_related_tables = $this->strSearchOtherTables($dataTable);

    if (!empty($str_search_related_tables)) {
      $str = "
      public function {$this->functionNameUpdate}(\$item_id = 0)
      {
        // \$usr_codigo = session_codigo_usr();

        if (empty(\$item_id)) {
          set_flash_message_danger('error', 'Item não encontrado.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }

        \$dados_item = \$this->{$this->showName}->{$this->functionNameRead}(\$item_id);

        if (empty(\$dados_item)) {
          set_flash_message_danger('error', 'Registro não encontrado.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }

        \$data_related_tables = \$this->{$this->showName}->consultar_from_related_tables();

        \$data_view = array(
          'data' => \$dados_item,
          'data_related_tables' => \$data_related_tables,
          'item_id' => \$item_id
        );

        render_template('{$this->strOptionalPathView}{$this->dirView}/{$this->fileNameViewUpdate}', \$data_view);
      }
      ";
    } else {
      $str = "
      public function {$this->functionNameUpdate}(\$item_id = 0)
      {
        // \$usr_codigo = session_codigo_usr();

        if (empty(\$item_id)) {
          set_flash_message_danger('error', 'Item não encontrado.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }

        \$dados_item = \$this->{$this->showName}->{$this->functionNameRead}(\$item_id);

        if (empty(\$dados_item)) {
          set_flash_message_danger('error', 'Registro não encontrado.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }

        \$data_view = array(
          'data' => \$dados_item,
          'item_id' => \$item_id
        );

        render_template('{$this->strOptionalPathView}{$this->dirView}/{$this->fileNameViewUpdate}', \$data_view);
      }
      ";
    }
    return $str;
  }
  private function strAlterar_salvar(array $dataTable)
  {
    $strDataPhpValidation = $this->strPhpValidation($dataTable, TRUE);
    $strDataArray = $this->strControllerArray($dataTable, '$data_post', TRUE);

    $str = "
    public function {$this->functionNameUpdate}_{$this->functionNameSufix}(\$item_id = 0)
    {
      // \$usr_codigo = session_codigo_usr();

      {$strDataPhpValidation}

      if (!\$this->form_validation->run()) {
        \$this->{$this->functionNameUpdate}(\$item_id);
      } else {

        \$data_post = \$this->input->post();

        \$data_insert = {$strDataArray}

        \$linha = \$this->{$this->showName}->{$this->functionNameUpdate}(\$data_insert);

        if (empty(\$linha)) {
          set_flash_message_danger('error', 'Não foi possivel alterar o registro, tente novamente.');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameUpdate}/' . \$item_id));
        } else {
          set_flash_message_success('success', 'Registro alterado com sucesso!');
          redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}'));
        }
      }
    }
    ";

    return $str;
  }

  /* Funções para createFunctionDelete() */
  private function strRemover(array $dataTable)
  {
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $chave_primaria = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    $response_json = ($this->functionDeleteResponseJson) ? '//' : '';
    $response_set_flashdata = (!$this->functionDeleteResponseJson) ? '//' : '';

    $str = "
    public function {$this->functionNameDelete}(\$item_id = 0)
    {
      // \$usr_codigo = session_codigo_usr();
  
      \$data_post = \$this->input->post();
  
      \$item_id = (isset(\$data_post['{$chave_primaria}'])) ? \$data_post['{$chave_primaria}'] : \$item_id;
  
      if (empty(\$item_id)) {
        \$message_error = 'Registro não encontrado.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}')); 
      }
  
      \$dados_item = \$this->{$this->showName}->{$this->functionNameRead}(\$item_id);
  
      if (empty(\$dados_item)) {
        \$message_error = 'Registro não encontrado.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}')); 
      }
  
      \$linha = \$this->{$this->showName}->{$this->functionNameDelete}(\$item_id);
  
      if (empty(\$linha)) {
        \$message_error = 'Não foi possivel remover o registro.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameDelete}')); 
      } else {
        \$message_success = 'Não foi possivel remover o registro.';
        {$response_json} exit(response_json(array('success' => \$message_success)));
        {$response_set_flashdata} set_flash_message_success('success', \$message_success);
        {$response_set_flashdata} redirect(base_url('{$this->strOptionalPreBaseUrl}{$this->showName}/{$this->functionNameRead}')); 
      }
    }
    ";

    return $str;
  }
}
