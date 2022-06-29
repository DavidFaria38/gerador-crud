<?php

class Codeigniter3_contoller
{
  public bool $validationServerSide;
  public bool $functionDeleteResponseJson;
  private string $dataCreate;
  private string $dataRead;
  private string $dataUpdate;
  private string $dataDelete;

  function __construct(array $config = array())
  {
    $this->validationServerSide = (isset($config['validationServerSide']) && !empty($config['validationServerSide'])) ? TRUE : FALSE;
    $this->functionDeleteResponseJson = (isset($config['functionDeleteResponseJson']) && !empty($config['functionDeleteResponseJson'])) ? TRUE : FALSE;
  }

  public function run(array $dataTable)
  {
    $this->dataCreate = $this->createFunctionCreate($dataTable);
    $this->dataRead = $this->createFunctionRead();
    $this->dataUpdate = $this->createFunctionUpdate($dataTable);
    $this->dataDelete = $this->createFunctionDelete($dataTable);

    $strFile = $this->strStartFunction($dataTable);
    $strFile .= $this->dataCreate;
    $strFile .= $this->dataRead;
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
  private function createFunctionRead()
  {
    $str = $this->strConsultar();
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

  private function strStartFunction() // todo: fazer gerar o nome do model correto
  {
    return "
    <?php

    class ControllerModelo extends CI_Controller
    {

      // private string \$linkRedirecionamento = '';

      public function __construct()
      {
        parent::__construct();
        \$this->load->model('ModelModelo', 'modelo');
      }
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
    $str .= ");\n";

    return $str;
  }

  private function getRegistroPrimaryKey(array $dataTable){
    $arr_registro = array_filter($dataTable, function($value){ // retornar registro que possui chave primaria
      return $value[GERADOR_COL_PK];
    }, ARRAY_FILTER_USE_BOTH);

    if(empty($arr_registro)){
      exit('ERROR:: Não existe um registro com chave primaria; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()');
    }
    if(count($arr_registro) > 1){
      exit('ERROR:: Existem duas chaves primaria para a mesma tabela; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()');
    }

    return $arr_registro[0];
  }

  /* Funções para createFunctionCreate() */
  private function strInserir()
  {
    return "
    public function inserir()
    {
      render_template('cadastrar'); // todo: inserir caminho 
    }
    ";
  }
  private function strInserir_salvar(array $dataTable)
  {
    $strDataPhpValidation = $this->strPhpValidation($dataTable);
    $strDataArray = $this->strPhpArray($dataTable, '$data_post');

    $str = "
    public function inserir_salvar(\$item_id = 0)
    {
      // \$usr_codigo = session_codigo_usr();
    
      {$strDataPhpValidation}

      if (!\$this->form_validation->run()) {
        \$this->consulta(\$item_id);
      } else {
  
        \$data_post = \$this->input->post();
  
        \$data_insert = {$strDataArray}
  
        \$linha = \$this->modelo->inserir(\$data_insert);
  
        if (empty(\$linha)) {
          set_flash_message_danger('error', 'Não foi possivel inserir o registro, tente novamente.');
          redirect(base_url('inserir')); // todo: link redirect
        } else {
          set_flash_message_success('success', 'Registro inserido com sucesso!');
          redirect(base_url('modelo')); // todo: link redirect
        }
      }
    }
    ";

    return $str;
  }

  /* Funções para createFunctionRead() */
  private function strConsultar()
  {
    $str = "
    public function consultar()
    {
      \$dados_item = \$this->modelo->consultar();

      \$data_view = array(
        'modelo' => \$dados_item
      );

      render_template('consultar', \$data_view); // todo: inserir caminho 
    }
    ";

    return $str;
  }

  /* Funções para createFunctionUpdate() */
  private function strAlterar()
  {
    $str = "
    public function alterar(\$item_id = 0)
    {
      // \$usr_codigo = session_codigo_usr();

      if (empty(\$item_id)) {
        set_flash_message_danger('error', 'Item não encontrado.');
        redirect(base_url('modelo')); // todo: link redirect
      }

      \$dados_item = \$this->modelo->consultar_por_id(\$item_id);

      if (empty(\$dados_item)) {
        set_flash_message_danger('error', 'Registro não encontrado.');
        redirect(base_url('modelo')); // todo: link redirect
      }

      \$data_view = array(
        'modelo' => \$dados_item
      );

      render_template('alterar', \$data_view); // todo: inserir caminho 
    }
    ";

    return $str;
  }
  private function strAlterar_salvar(array $dataTable)
  {
    $strDataPhpValidation = $this->strPhpValidation($dataTable);
    $strDataArray = $this->strPhpArray($dataTable, '$data_post');

    $str = "
    public function alterar_salvar(\$item_id = 0)
    {
      \$usr_codigo = session_codigo_usr();

      {$strDataPhpValidation}

      if (!\$this->form_validation->run()) {
        \$this->consulta(\$item_id);
      } else {

        \$data_post = \$this->input->post();

        \$data_insert = {$strDataArray}

        \$linha = \$this->modelo->alterar(\$usr_codigo, \$data_insert);

        if (empty(\$linha)) {
          set_flash_message_danger('error', 'Não foi possivel inserir o registro, tente novamente.');
          redirect(base_url('inserir')); // todo: link redirect
        } else {
          set_flash_message_success('success', 'Registro inserido com sucesso!');
          redirect(base_url('modelo')); // todo: link redirect
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
    public function remover(\$item_id = 0)
    {
      \$usr_codigo = session_codigo_usr();
  
      \$data_post = \$this->input->post();
  
      \$item_id = (isset(\$data_post['{$chave_primaria}'])) ? \$data_post['{$chave_primaria}'] : \$item_id;
  
      if (empty(\$item_id)) {
        \$message_error = 'Registro não encontrado.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('modelo'));  // todo: link redirect
      }
  
      \$dados_item = \$this->modelo->consulta_por_id(\$item_id);
  
      if (empty(\$dados_item)) {
        \$message_error = 'Registro não encontrado.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('modelo'));  // todo: link redirect
      }
  
      \$linha = \$this->modelo->remover(\$item_id);
  
      if (empty(\$linha)) {
        \$message_error = 'Não foi possivel remover o registro.';
        {$response_json} exit(response_json(array('error' => \$message_error)));
        {$response_set_flashdata} set_flash_message_danger('error', \$message_error);
        {$response_set_flashdata} redirect(base_url('modelo'));  // todo: link redirect
      } else {
        \$message_success = 'Não foi possivel remover o registro.';
        {$response_json} exit(response_json(array('success' => \$message_success)));
        {$response_set_flashdata} set_flash_message_success('success', \$message_success);
        {$response_set_flashdata} redirect(base_url('modelo'));  // todo: link redirect
      }
    }
    ";

    return $str;
  }
}
