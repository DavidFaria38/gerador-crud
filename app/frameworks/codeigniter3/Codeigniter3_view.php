<?php

class Codeigniter3_view
{

  public bool $validationClientSide;

  public string $fileNameViewCreate;
  public string $fileNameViewRead;
  public string $fileNameViewUpdate;

  private string $dataCreate;
  private string $dataUpdate;
  private string $dataRead;

  function __construct(array $config = array())
  {
    // File names
    $this->fileNameViewCreate = (isset($config['fileNameViewCreate']) && !empty($config['fileNameViewCreate'])) ? $config['fileNameViewCreate'] : 'Create';
    $this->fileNameViewRead = (isset($config['fileNameViewRead']) && !empty($config['fileNameViewRead'])) ? $config['fileNameViewRead'] : 'Update';
    $this->fileNameViewUpdate = (isset($config['fileNameViewUpdate']) && !empty($config['fileNameViewUpdate'])) ? $config['fileNameViewUpdate'] : 'Read';
    $this->fileNameViewCreate = ucfirst($this->fileNameViewCreate);
    $this->fileNameViewRead = ucfirst($this->fileNameViewRead);
    $this->fileNameViewUpdate = ucfirst($this->fileNameViewUpdate);

    // other
    $this->validationClientSide = (isset($config['validationClientSide']) && !empty($config['validationClientSide'])) ? TRUE : FALSE;
    // $this->functionDeleteResponseJson = (isset($config['functionDeleteResponseJson']) && $config['functionDeleteResponseJson']) ? TRUE : FALSE;
  }

  public function run(array $dataTable)
  {
    $this->dataCreate = $this->createViewCreate($dataTable);
    $this->dataUpdate = $this->createViewUpdate($dataTable);
    $this->dataRead = $this->createViewRead($dataTable);

    // return 'nada retornado das views';
    return $this->join();
  }
  private function createViewCreate(array $dataTable)
  {
    $html = $this->htmlStart($this->fileNameViewCreate);
    $html .= $this->htmlCreate($dataTable);
    $html .= $this->htmlEnd();
    // $html .= $this->validationClientSide($dataTable);

    // var_dump("<textarea>{$html}</textarea>"); die;

    return $html;
  }
  private function createViewUpdate(array $dataTable)
  {
    $html = $this->htmlStart($this->fileNameViewUpdate);
    $html .= $this->htmlUpdate($dataTable);
    $html .= $this->htmlEnd();
    // $html .= $this->validationClientSide($dataTable);
    
    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html}</textarea>"); die;

    return $html;
  }
  private function createViewRead(array $dataTable)
  {
    $html = $this->htmlStart($this->fileNameViewRead);
    $html .= $this->htmlTable($dataTable);
    $html .= $this->htmlEnd();

    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html}</textarea>"); die;
    return $html;
  }
  private function join()
  {
    return array(
      array('fileData' => $this->dataCreate, 'fileName' => $this->fileNameViewCreate),
      array('fileData' => $this->dataUpdate, 'fileName' => $this->fileNameViewUpdate),
      array('fileData' => $this->dataRead, 'fileName' => $this->fileNameViewRead),
    );
  }

  private function htmlStart(string $name_header)
  {
    $html = <<<EOT
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
                        <h2 class="text-md-left text-white">{$name_header}</h2>
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

    EOT;
    return $html;
  }
  private function htmlEnd()
  {
    $html = <<<EOT

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    EOT;
    return $html;
  }

  private function htmlTable(array $dataTable)
  {
    $html_table_header = $this->strGetTableHeaderHtml($dataTable);
    $html_table_body = $this->strGetTableBodyHtml($dataTable);
    $item_pk = $this->getRegistroPrimaryKey($dataTable);
    $field_pk = $item_pk[GERADOR_COL_NAMEFIELD_DB];

    $html_table = <<<EOT
    <table class="datatable display cell-border">
      <thead>
        <tr>
          <th width="10">#</th>
          {$html_table_header}
        </tr>
      </thead>
      <tbody>
        <?php foreach (\$data as \$key => \$dataValue) : ?>
          <tr>
            <td><a href="<?= base_url('modelo/alterar/' . \$dataValue[{$field_pk}]) ?>" class="btn btn-primary">Editar</a></td>
            {$html_table_body}
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    EOT;

    return $html_table;
  }

  private function htmlCreate(array $dataTable)
  {

    $str_inputs_create = $this->strGetInputCreate($dataTable);

    $html_create = <<<EOT
    <?= form_open(base_url('/inserir')); ?>

    {$str_inputs_create}
    
    <?= form_close(); ?>
    EOT;

    return $html_create;
  }
  
  private function htmlUpdate(array $dataTable)
  {

    $str_inputs_update = $this->strGetInputUpdate($dataTable);

    $html_update = <<<EOT
    <?= form_open(base_url('/inserir')); ?>

    {$str_inputs_update}
    
    <?= form_close(); ?>
    EOT;

    return $html_update;
  }

  private function validationClientSide(array $dataTable)
  {
    return "";
  }

  // funções aux
  private function strGetInputCreate(array $dataTable)
  {
    // retorna os registros que não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_inputs = "";
    
    foreach ($arr_table_data_selected as $key => $table_input) {
      $input_type = $table_input[GERADOR_COL_TYPEFIELD_HTML];

      $attribute_minMax_type = HTML_INPUT_TYPE_LIST[$input_type]['attr_minMax'];

      $min_value = ($attribute_minMax_type == 'value') ? $table_input[GERADOR_COL_MIN_LENGTH] : '';
      $max_value = ($attribute_minMax_type == 'value') ? $table_input[GERADOR_COL_MAX_LENGTH] : '';
      $min_length = ($attribute_minMax_type == 'length') ? $table_input[GERADOR_COL_MIN_LENGTH] : '';
      $max_length = ($attribute_minMax_type == 'length') ? $table_input[GERADOR_COL_MAX_LENGTH] : '';

      $input_config = array(
        'label' => $table_input[GERADOR_COL_NAMEFIELD_HTML],
        'type' => $table_input[GERADOR_COL_TYPEFIELD_HTML],
        'id' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'name' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'class' => '',
        'value' => '',
        'placeholder' => TRUE,
        'required' => $table_input[GERADOR_COL_REQUIRED],
        'disabled' => '',
        'readonly' => '',
        'minValue' => $min_value,
        'maxValue' => $max_value,
        'minLength' => $min_length,
        'maxLength' => $max_length,
      );
      // var_dump('<pre>', $input_config); die;

      $html_inputs .= $this->strMakeInput($input_config);
      
    }
    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html_inputs}</textarea>"); die;
    return $html_inputs;
  }
  
  private function strGetInputUpdate(array $dataTable)
  {
    // retorna os registros que são chave primaria ou não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return $value[GERADOR_COL_PK] || !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_inputs = "";
    
    foreach ($arr_table_data_selected as $key => $table_input) {
      $input_type = $table_input[GERADOR_COL_TYPEFIELD_HTML];

      $attribute_minMax_type = HTML_INPUT_TYPE_LIST[$input_type]['attr_minMax'];

      $min_value = ($attribute_minMax_type == 'value') ? $table_input[GERADOR_COL_MIN_LENGTH] : '';
      $max_value = ($attribute_minMax_type == 'value') ? $table_input[GERADOR_COL_MAX_LENGTH] : '';
      $min_length = ($attribute_minMax_type == 'length') ? $table_input[GERADOR_COL_MIN_LENGTH] : '';
      $max_length = ($attribute_minMax_type == 'length') ? $table_input[GERADOR_COL_MAX_LENGTH] : '';

      $input_config = array(
        'label' => $table_input[GERADOR_COL_NAMEFIELD_HTML],
        'type' => $table_input[GERADOR_COL_TYPEFIELD_HTML],
        'id' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'name' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'class' => '',
        'value' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'placeholder' => TRUE,
        'required' => $table_input[GERADOR_COL_REQUIRED],
        'disabled' => '',
        'readonly' => '',
        'minValue' => $min_value,
        'maxValue' => $max_value,
        'minLength' => $min_length,
        'maxLength' => $max_length,
      );
      // var_dump('<pre>', $input_config); die;

      $html_inputs .= $this->strMakeInput($input_config);
      
    }
    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html_inputs}</textarea>"); die;
    return $html_inputs;
  }

  private function strMakeInput(array $input_config)
  {

    $label = $input_config['label'];
    $type = $input_config['type'];
    $id = $input_config['id'];
    $name = $input_config['name'];
    $value = (isset($input_config['value']) && !empty($input_config['value'])) ? $input_config['value'] : '';
    $class_input = (isset($input_config['class']) && !empty($input_config['class'])) ? $input_config['class'] : '';
    $class_label = "form-label";

    $required = (isset($input_config['required']) && !empty($input_config['required'])) ? " required" : '';
    $disabled = (isset($input_config['disabled']) && !empty($input_config['disabled'])) ? " disabled" : '';
    $readonly = (isset($input_config['readonly']) && !empty($input_config['readonly'])) ? " readonly" : '';

    $placeholder = (isset($input_config['placeholder']) && $input_config['placeholder'] != '') ? " placeholder=\"{$input_config['placeholder']}\"" : '';
    $minValue = (isset($input_config['minValue']) && $input_config['minValue'] != '') ? " min=\"{$input_config['minValue']}\"" : '';
    $maxValue = (isset($input_config['maxValue']) && $input_config['maxValue'] != '') ? " max=\"{$input_config['maxValue']}\"" : '';
    $minLength = (isset($input_config['minLength']) && $input_config['minLength'] != '') ? " minLength=\"{$input_config['minLength']}\"" : '';
    $maxLength = (isset($input_config['maxLength']) && $input_config['maxLength'] != '') ? " maxLength=\"{$input_config['maxLength']}\"" : '';

    if ($type == 'select') {

      $field_foreign_key = GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE;
      $field_foreign_value = GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE;

      $input = <<< EOT
      <div class="form-floating">
        <select class="form-select {$class_input}" name="{$name}" id="{$id}">
          <option selected>Selecione</option>
          <?php foreach (\$data as \$key => \$options) : ?>
            <option value="<?= \$option->{$field_foreign_key} ?>"><?= \$option->{$field_foreign_value} ?></option>
          <?php endforeach; ?>
        </select>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>
      EOT;

    } else if ($type == 'textarea') {

      $input = <<< EOT
      <div class="form-floating">
        <textarea type="textarea" class="form-control {$class_input}" name="{$name}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>$value</textarea>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>\n
      EOT;
    } else {

      $value = (isset($input_config['value']) && !empty($input_config['value'])) ? " value=\"<?= \$data->{$input_config['value']} ?>\"" : '';

      // seleção do tipo de classe a ser inserido
      if ($type == 'checkbox' || $type == 'radio') {
        $class_input = "form-check-input";
        $class_label = "form-check-label";
      } else if ($type == 'range') {
        $class_input = "form-range";
      } 
      
      // Retornar input simplificado se for tipo hidden
      if ($type == 'hidden') {
        $input = <<< EOT
        <div class="form-floating">
          <input type="{$type}" name="{$name}" id="{$id}"{$value}{$required}>
        </div>\n
        EOT;

        return $input;
      }

      $input = <<< EOT
        <div class="form-floating">
          <input type="{$type}" class="form-control {$class_input}" name="{$id}" id="{$id}"{$value}{$placeholder}{$minLength}{$maxLength}{$minValue}{$maxValue}{$disabled}{$readonly}{$required}>
          <label for="{$id}" class="$class_label">{$label}</label>
        </div>\n
        EOT;
    }

    return $input;
  }

  private function strGetTableHeaderHtml(array $dataTable)
  {
    // retorna os registros que não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_table_header = "";

    foreach ($arr_table_data_selected as $key => $table_input) {
      $html_field_name = $table_input[GERADOR_COL_NAMEFIELD_HTML];
      $html_field_name = ucfirst($html_field_name);

      $html_table_header .= "<th>{$html_field_name}</th>\n";

      return $html_table_header;
    }
  }

  private function strGetTableBodyHtml(array $dataTable)
  {
    // retorna os registros que são chave primaria ou não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return $value[GERADOR_COL_PK] || !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_table_body = "";

    foreach ($arr_table_data_selected as $key => $table_input) {
      if (empty($table_input[GERADOR_COL_NAMETABLE_FOREIGN])) {
        $html_field_value = $table_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];
      } else {
        $html_field_value = $table_input[GERADOR_COL_NAMEFIELD_DB];
      }

      $html_table_body .= "<td>{$html_field_value}</td>\n";

      return $html_table_body;
    }
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
}
