<?php

class Codeigniter3_view
{
  public bool $defaultInputStyle;

  public string $fileNameViewCreate;
  public string $fileNameViewRead;
  public string $fileNameViewUpdate;
  public string $showName;

  public string $functionNameCreate;
  public string $functionNameRead;
  public string $functionNameUpdate;
  public string $functionNameDelete;
  public string $functionNameSufix;

  private string $dataCreate;
  private string $dataUpdate;
  private string $dataRead;

  function __construct(array $config = array())
  {
    // File names
    $this->defaultInputStyle = TRUE;
    // Function names
    $this->fileNameViewCreate = $config['fileNameViewCreate'];
    $this->fileNameViewRead = $config['fileNameViewRead'];
    $this->fileNameViewUpdate = $config['fileNameViewUpdate'];
    $this->functionNameCreate = $config['functionNameCreate'];
    $this->functionNameRead = $config['functionNameRead'];
    $this->functionNameUpdate = $config['functionNameUpdate'];
    $this->functionNameDelete = $config['functionNameDelete'];
    $this->functionNameSufix = $config['functionNameSufix'];
    $this->showName = strtolower($config['fileNameShow']);
    // other
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
    $html = $this->htmlStart(ucfirst($this->fileNameViewCreate));
    $html .= $this->htmlCreate($dataTable);
    $html .= $this->htmlEnd();
    $html .= $this->validationClientSide($dataTable);

    // var_dump("<textarea>{$html}</textarea>"); die;

    return $html;
  }
  private function createViewUpdate(array $dataTable)
  {
    $html = $this->htmlStart(ucfirst($this->fileNameViewUpdate));
    $html .= $this->htmlUpdate($dataTable);
    $html .= $this->htmlEnd();
    $html .= $this->validationClientSide($dataTable);

    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html}</textarea>"); die;

    return $html;
  }
  private function createViewRead(array $dataTable)
  {
    $html = $this->htmlStart(ucfirst($this->fileNameViewRead), 10);
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

  private function htmlStart(string $name_header, int $size_body_view = 8)
  {
    $html = <<<EOT
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="ger-width-view">
          <div class="row">
            <div class="col-md-12">
              <div class="ger-header-view">
                <div class="container-fluid">
                  <div class="row align-items-center">
                    <div class="col-md-6">
                      <h2 class="text-md-left text-white">{$name_header}</h2>
                    </div>
                    <!--
                      <div class="col-md-6">
                        <h5 class="text-md-right text-white">Detalhes 1</h5>
                        <h5 class="text-md-right text-white">Detalhes 2</h5>
                      </div>
                    -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row justify-content-center">
            <div class="col-md-{$size_body_view}">
              <div class="ger-body-view">

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

    <?= get_flash_message('success'); ?>
    <?= get_flash_message('error'); ?>

    <div class="row">
      <div class="d-flex justify-content-end pb-3">
        <a href="<?= base_url('{$this->showName}/{$this->functionNameCreate}'); ?>" class="btn btn-primary btn-lg">Cadastrar</a>
      </div>
    </div>

    <div class="ger-overflow">
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
              <td><a href="<?= base_url('{$this->showName}/{$this->functionNameUpdate}/' . \$dataValue->{$field_pk}) ?>" class="btn btn-primary">Editar</a></td>
              {$html_table_body}
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    EOT;

    return $html_table;
  }

  private function htmlCreate(array $dataTable)
  {
    $str_inputs_create = $this->strGetInputCreate($dataTable);

    $html_create = <<<EOT

    <?= get_flash_message('success'); ?>
    <?= get_flash_message('error'); ?>
    <?= form_validation_errors(); ?>

    <?= form_open(base_url('{$this->showName}/{$this->functionNameCreate}'), ['class' => 'form_validate']); ?>

    {$str_inputs_create}
    
    <div class="d-flex justify-content-center pt-3">
      <button type="button" class="btn btn-primary btn-validate">Salvar</button>
    </div>

    <?= form_close(); ?>
    EOT;

    return $html_create;
  }

  private function htmlUpdate(array $dataTable)
  {
    $str_inputs_update = $this->strGetInputUpdate($dataTable);

    $html_update = <<<EOT

    <?= get_flash_message('success'); ?>
    <?= get_flash_message('error'); ?>
    <?= form_validation_errors(); ?>

    <?= form_open(base_url('{$this->showName}/{$this->functionNameUpdate}/' . \$item_id), ['class' => 'form_validate']); ?>

    {$str_inputs_update}
    
    <div class="d-flex justify-content-center pt-3">
      <button type="button" class="btn btn-primary btn-validate">Salvar</button>
    </div>
    
    <?= form_close(); ?>
    EOT;

    return $html_update;
  }

  private function validationClientSide(array $dataTable)
  {
    // retorna os registros que não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $rules = "";

    foreach ($arr_table_data_selected as $key => $table_input) {

      $field_name = $table_input[GERADOR_COL_NAMEFIELD_DB];
      $field_type = $table_input[GERADOR_COL_TYPEFIELD_HTML];

      // selecionar o valor do atributo minlength/maxlength e min/max do input
      $attribute_minMax_type = HTML_INPUT_TYPE_LIST[$field_type]['attr_minMax'];
      $min = $table_input[GERADOR_COL_MIN_LENGTH];
      $max = $table_input[GERADOR_COL_MAX_LENGTH];

      $min_value = ($attribute_minMax_type == 'value' && $min != -1) ? "min: {$min}," : "";
      $max_value = ($attribute_minMax_type == 'value' && $max != -1) ? "max: {$max}," : "";
      $min_length = ($attribute_minMax_type == 'length' && $min != -1) ? "minlength: {$min}," : "";
      $max_length = ($attribute_minMax_type == 'length' && $max != -1) ? "maxlength: {$max}," : "";

      $required = ($table_input[GERADOR_COL_REQUIRED]) ? 'required: true,' : 'required: false,';
      $validation = (!empty($table_input[GERADOR_COL_TYPE_VALIDATION])) ? $table_input[GERADOR_COL_TYPE_VALIDATION] . ': true,' : '';

      if ($table_input[GERADOR_COL_TYPE_VALIDATION] != 'cpf' && $table_input[GERADOR_COL_TYPE_VALIDATION] != 'cnpj') {
        $validation = '';
      }
      $rules .= <<<EOT
        \n{$field_name}: {{$required}{$validation}{$min_value}{$max_value}{$min_length}{$max_length}},
        EOT;
    }

    $str_fucntion_validation_client_side = <<<EOT
    \n
    <script>
      $(function() {
        $('.form_validate').validate({
          rules: {{$rules}}
        });
      });
    </script>
    EOT;
    // var_dump('<textarea>' . $str_fucntion_validation_client_side . '</textarea>'); die;
    return $str_fucntion_validation_client_side;
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

      /* atributos minlength/maxlength e min/max serão validados por js e no server */
      // selecionar o valor do atributo minlength/maxlength e min/max do input
      // $field_type = $table_input[GERADOR_COL_TYPEFIELD_HTML];
      // $attribute_minMax_type = HTML_INPUT_TYPE_LIST[$field_type]['attr_minMax'];
      // $min = $table_input[GERADOR_COL_MIN_LENGTH];
      // $max = $table_input[GERADOR_COL_MAX_LENGTH];

      // $min_value = ($attribute_minMax_type == 'value' && $min != -1) ? $min : '';
      // $max_value = ($attribute_minMax_type == 'value' && $max != -1) ? $max : '';
      // $min_length = ($attribute_minMax_type == 'length' && $min != -1) ? $min : '';
      // $max_length = ($attribute_minMax_type == 'length' && $max != -1) ? $max : '';

      // classe para aplicar a mascara do input
      // $class_mask = $table_input[GERADOR_COL_TYPE_VALIDATION];
      $class_mask = $table_input[GERADOR_COL_TYPE_MASK];

      $input_config = array(
        'label' => $table_input[GERADOR_COL_NAMEFIELD_HTML],
        'type' => $table_input[GERADOR_COL_TYPEFIELD_HTML],
        'id' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'name' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'class' => $class_mask,
        'value' => '',
        'placeholder' => ' ',
        'required' => $table_input[GERADOR_COL_REQUIRED],
        'disabled' => '',
        'readonly' => '',
        // 'minValue' => (!empty($min_value)) ? $min_value : '',
        // 'maxValue' => (!empty($max_value)) ? $max_value : '',
        // 'minLength' => (!empty($min_length)) ? $min_length : '',
        // 'maxLength' => (!empty($max_length)) ? $max_length : '',
      );
      // var_dump('<pre>', $input_config); die;

      if ($this->defaultInputStyle) {
        $html_inputs .= $this->strMakeInput_default($input_config, $table_input);
      } else {
        $html_inputs .= $this->strMakeInput($input_config, $table_input);
      }
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

      /* atributos minlength/maxlength e min/max serão validados por js e no server */
      // selecionar o valor do atributo minlength/maxlength e min/max do input
      // $field_type = $table_input[GERADOR_COL_TYPEFIELD_HTML];
      // $attribute_minMax_type = HTML_INPUT_TYPE_LIST[$field_type]['attr_minMax'];
      // $min = $table_input[GERADOR_COL_MIN_LENGTH];
      // $max = $table_input[GERADOR_COL_MAX_LENGTH];

      // $min_value = ($attribute_minMax_type == 'value' && $min != -1) ? $min : '';
      // $max_value = ($attribute_minMax_type == 'value' && $max != -1) ? $max : '';
      // $min_length = ($attribute_minMax_type == 'length' && $min != -1) ? $min : '';
      // $max_length = ($attribute_minMax_type == 'length' && $max != -1) ? $max : '';

      // classe para aplicar a mascara do input
      // $class_mask = $table_input[GERADOR_COL_TYPE_VALIDATION];
      $class_mask = $table_input[GERADOR_COL_TYPE_MASK];

      $input_config = array(
        'create' => FALSE,
        'update' => TRUE,
        'label' => $table_input[GERADOR_COL_NAMEFIELD_HTML],
        'type' => $table_input[GERADOR_COL_TYPEFIELD_HTML],
        'id' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'name' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'class' => $class_mask,
        'value' => (!empty($table_input[GERADOR_COL_NAMETABLE_FOREIGN])) ? $table_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE] : $table_input[GERADOR_COL_NAMEFIELD_DB],
        'placeholder' => ' ',
        'required' => $table_input[GERADOR_COL_REQUIRED],
        'disabled' => '',
        'readonly' => '',
        // 'minValue' => $min_value,
        // 'maxValue' => $max_value,
        // 'minLength' => $min_length,
        // 'maxLength' => $max_length,
      );
      // var_dump('<pre>', $input_config); die;


      if ($this->defaultInputStyle) {
        $html_inputs .= $this->strMakeInput_default($input_config, $table_input);
      } else {
        $html_inputs .= $this->strMakeInput($input_config, $table_input);
      }
    }
    // var_dump("<textarea cols=\"200\" rows=\"200\">{$html_inputs}</textarea>"); die;
    return $html_inputs;
  }

  private function strMakeInput(array $input_config, array $table_input)
  {

    $label = $input_config['label'];
    $type = $input_config['type'];
    $id = $input_config['id'];
    $name = $input_config['name'];
    $class_input = (isset($input_config['class']) && !empty($input_config['class'])) ? $input_config['class'] : '';
    $class_label = "form-label";
    $value = (isset($input_config['value']) && !empty($input_config['value'])) ? $input_config['value'] : '';
    $class_function_validate = " <?= form_validation_input('{$id}') ?>";

    $required = (isset($input_config['required']) && !empty($input_config['required'])) ? " required" : '';
    $disabled = (isset($input_config['disabled']) && !empty($input_config['disabled'])) ? " disabled" : '';
    $readonly = (isset($input_config['readonly']) && !empty($input_config['readonly'])) ? " readonly" : '';

    $placeholder = (isset($input_config['placeholder']) && !empty($input_config['placeholder'])) ? " placeholder=\"{$input_config['placeholder']}\"" : '';
    $minValue = (isset($input_config['minValue']) && !empty($input_config['minValue'])) ? " min=\"{$input_config['minValue']}\"" : '';
    $maxValue = (isset($input_config['maxValue']) && !empty($input_config['maxValue'])) ? " max=\"{$input_config['maxValue']}\"" : '';
    $minLength = (isset($input_config['minLength']) && !empty($input_config['minLength'])) ? " minLength=\"{$input_config['minLength']}\"" : '';
    $maxLength = (isset($input_config['maxLength']) && !empty($input_config['maxLength'])) ? " maxLength=\"{$input_config['maxLength']}\"" : '';


    if ($type == 'select') {

      $table_data_key = $table_input[GERADOR_COL_NAMETABLE_FOREIGN];
      $field_foreign_key = $table_input[GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE];
      $field_foreign_value = $table_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];

      $update_select = "";
      if (isset($input_config['update']) && !empty($input_config['update'])) {
        $update_select = " <?= (\$option->{$field_foreign_key} == \$data->{$id}) ? 'selected' : '' ?>";
      }

      $input = <<< EOT
      <div class="form-floating">
        <select class="form-select {$class_input}" name="{$name}" id="{$id}"{$required}{$disabled}{$readonly}>
          <option disabled selected>Selecione</option>
          <?php foreach (\$data_related_tables['{$table_data_key}'] as \$key => \$option) : ?>
            <option value="<?= \$option->{$field_foreign_key} ?>"{$update_select}><?= \$option->{$field_foreign_value} ?></option>
          <?php endforeach; ?>
        </select>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>
      EOT;
    } else if ($type == 'textarea') {

      $input = <<< EOT
      <div class="form-floating">
        <textarea type="textarea" class="form-control {$class_input}{$class_function_validate}" name="{$name}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>$value</textarea>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>\n
      EOT;
    } else {

      $value = (isset($input_config['value']) && !empty($input_config['value'])) ? " value=\"<?= (form_error('{$input_config['value']}')) ? set_value('{$input_config['value']}') : \$data->{$input_config['value']} ?>\"" : " value=\"<?= set_value('{$id}') ?>\"";

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
          <input type="{$type}" class="form-control {$class_input}{$class_function_validate}" name="{$id}" id="{$id}"{$value}{$placeholder}{$minLength}{$maxLength}{$minValue}{$maxValue}{$disabled}{$readonly}{$required}>
          <label for="{$id}" class="$class_label">{$label}</label>
        </div>\n
        EOT;
    }

    return $input;
  }

  private function strMakeInput_default(array $input_config, array $table_input)
  {

    $label = $input_config['label'];
    $type = $input_config['type'];
    $id = $input_config['id'];
    $name = $input_config['name'];
    $class_input = (isset($input_config['class']) && !empty($input_config['class'])) ? $input_config['class'] : '';
    $class_label = "form-label";
    $value = (isset($input_config['value']) && !empty($input_config['value'])) ? $input_config['value'] : '';
    $defaultValue = (!empty(trim($table_input[GERADOR_COL_DEFAULT_VALUE]))) ? trim($table_input[GERADOR_COL_DEFAULT_VALUE]) : "''";
    $class_function_validate = " <?= form_validation_input('{$id}') ?>";

    $required = (isset($input_config['required']) && !empty($input_config['required'])) ? " required" : '';
    $disabled = (isset($input_config['disabled']) && !empty($input_config['disabled'])) ? " disabled" : '';
    $readonly = (isset($input_config['readonly']) && !empty($input_config['readonly'])) ? " readonly" : '';

    $placeholder = (isset($input_config['placeholder']) && !empty($input_config['placeholder'])) ? " placeholder=\"{$input_config['placeholder']}\"" : '';
    $minValue = (isset($input_config['minValue']) && !empty($input_config['minValue'])) ? " min=\"{$input_config['minValue']}\"" : '';
    $maxValue = (isset($input_config['maxValue']) && !empty($input_config['maxValue'])) ? " max=\"{$input_config['maxValue']}\"" : '';
    $minLength = (isset($input_config['minLength']) && !empty($input_config['minLength'])) ? " minLength=\"{$input_config['minLength']}\"" : '';
    $maxLength = (isset($input_config['maxLength']) && !empty($input_config['maxLength'])) ? " maxLength=\"{$input_config['maxLength']}\"" : '';


    if ($type == 'select') {

      $table_data_key = $table_input[GERADOR_COL_NAMETABLE_FOREIGN];
      $field_foreign_key = $table_input[GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE];
      $field_foreign_value = $table_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];

      $update_select = "";
      if (isset($input_config['update']) && !empty($input_config['update'])) {
        $update_select = " <?= (\$option->{$field_foreign_key} == \$data->{$id}) ? 'selected' : '' ?>";
      }

      $input = <<< EOT
      <div class="form-group">
        <label for="{$id}" class="{$class_label}">{$label}</label>
        <select class="form-select {$class_input}" name="{$name}" id="{$id}"{$required}{$disabled}{$readonly}>
          <option disabled selected>Selecione</option>
          <?php foreach (\$data_related_tables['{$table_data_key}'] as \$key => \$option) : ?>
            <option value="<?= \$option->{$field_foreign_key} ?>"{$update_select}><?= \$option->{$field_foreign_value} ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      EOT;
    } else if ($type == 'textarea') {

      $value = (!empty($value)) ? "<?= \$data->{$input_config['value']} ?>" : "";

      $input = <<< EOT
      <div class="form-group">
        <label for="{$id}" class="{$class_label}">{$label}</label>
        <textarea type="textarea" class="form-control {$class_input}{$class_function_validate}" name="{$name}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>{$value}</textarea>
      </div>\n
      EOT;
    } else {

      $value = (isset($input_config['value']) && !empty($input_config['value'])) ? " value=\"<?= (form_error('{$input_config['value']}')) ? set_value('{$input_config['value']}') : \$data->{$input_config['value']} ?>\"" : " value=\"<?= (form_error('{$id}')) ? set_value('{$id}') : {$defaultValue} ?>\"";

      // seleção do tipo de classe a ser inserido
      if ($type == 'checkbox' || $type == 'radio') {
        $class_input = "form-check-input";
        $class_label = "form-check-label";
        $defaultValue = ($defaultValue == "''") ? 'FALSE' : 'TRUE';
        $value = (isset($input_config['value']) && !empty($input_config['value'])) ? " <?= set_checkbox('{$input_config['value']}', \$data->{$input_config['value']}, (\$data->{$input_config['value']} == 1)) ?>" : " <?= set_checkbox('{$id}', '', {$defaultValue}) ?>";
      } else if ($type == 'range') {
        $class_input = "form-range";
      }

      // Retornar input simplificado se for tipo hidden
      if ($type == 'hidden') {
        $input = <<< EOT
        <div class="form-group">
          <input type="{$type}" name="{$name}" id="{$id}"{$value}{$required}>
        </div>\n
        EOT;

        return $input;
      }

      $input = <<< EOT
        <div class="form-group">
          <label for="{$id}" class="$class_label">{$label}</label>
          <input type="{$type}" class="form-control {$class_input}{$class_function_validate}" name="{$id}" id="{$id}"{$value}{$placeholder}{$minLength}{$maxLength}{$minValue}{$maxValue}{$disabled}{$readonly}{$required}>
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
    }

    return $html_table_header;
  }

  private function strGetTableBodyHtml(array $dataTable)
  {
    // retorna os registros que são chave primaria ou não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_table_body = "";

    foreach ($arr_table_data_selected as $key => $table_input) {
      if (!empty($table_input[GERADOR_COL_NAMETABLE_FOREIGN])) {
        $html_field_value = $table_input[GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE];
      } else {
        $html_field_value = $table_input[GERADOR_COL_NAMEFIELD_DB];
      }
      // var_dump('<pre>', $table_input[GERADOR_COL_TYPEFIELD_HTML], array_search($table_input[GERADOR_COL_TYPEFIELD_HTML], array('checkbox', 'radio')), '<br>');
      if(is_int(array_search($table_input[GERADOR_COL_TYPEFIELD_HTML], array('checkbox', 'radio')))){
        $html_table_body .= "<td><?= humanize_boolean(\$dataValue->{$html_field_value}) ?></td>\n";
      } else {
        $html_table_body .= "<td><?= \$dataValue->{$html_field_value} ?></td>\n";
      }

    }

    // var_dump('<pre>', "<textarea>{$html_table_body}</textarea>"); die;
    return $html_table_body;
  }

  private function getRegistroPrimaryKey(array $dataTable)
  {
    $arr_registro = array_filter($dataTable, function ($value) { // retornar registro que possui chave primaria
      return $value[GERADOR_COL_PK];
    }, ARRAY_FILTER_USE_BOTH);

    if (empty($arr_registro)) {
      exit(json_encode(['error' => "ERROR:: Não existe um registro com chave primaria; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()."]));
    }
    if (count($arr_registro) > 1) {
      exit(json_encode(['error' => "ERROR:: Existem duas chaves primaria para a mesma tabela; <br>PATH: Codeigniter3_controller.php getRegistroPrimaryKey()."]));
    }

    return $arr_registro[array_key_first($arr_registro)];
  }
}
