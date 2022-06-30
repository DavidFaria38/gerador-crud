<?php

class Codeigniter3_view
{

  public bool $validationClientSide;

  public string $viewNameCreate;
  public string $viewNameUpdate;
  public string $viewNameRead;

  private string $dataCreate;
  private string $dataUpdate;
  private string $dataRead;

  function __construct(array $config = array())
  {
    // File names
    $this->viewNameCreate = (isset($config['viewNameCreate']) && !empty($config['viewNameCreate'])) ? $config['viewNameCreate'] : 'Create';
    $this->viewNameUpdate = (isset($config['viewNameUpdate']) && !empty($config['viewNameUpdate'])) ? $config['viewNameUpdate'] : 'Update';
    $this->viewNameRead = (isset($config['viewNameRead']) && !empty($config['viewNameRead'])) ? $config['viewNameRead'] : 'Read';
    $this->viewNameCreate = ucfirst($this->viewNameCreate);
    $this->viewNameUpdate = ucfirst($this->viewNameUpdate);
    $this->viewNameRead = ucfirst($this->viewNameRead);

    // other
    $this->validationClientSide = (isset($config['validationClientSide']) && !empty($config['validationClientSide'])) ? TRUE : FALSE;
    // $this->functionDeleteResponseJson = (isset($config['functionDeleteResponseJson']) && $config['functionDeleteResponseJson']) ? TRUE : FALSE;
  }

  public function run(array $dataTable)
  {
    $this->dataCreate = $this->createViewCreate($dataTable);
    // $this->dataUpdate = $this->createViewUpdate($dataTable);
    // $this->dataRead = $this->createViewRead($dataTable);

    return '';
    // return $this->join();
  }
  private function createViewCreate(array $dataTable)
  {
    $html = $this->htmlStart();
    $html .= $this->htmlCreate($dataTable);
    $html .= $this->htmlEnd();
    $html .= $this->validationClientSide($dataTable);

    // var_dump("<textarea>{$html}</textarea>"); die;

    return $html;
  }
  private function createViewUpdate(array $dataTable)
  {
    $html = $this->htmlStart();
    $html .= $this->htmlUpdate($dataTable);
    $html .= $this->htmlEnd();
    $html .= $this->validationClientSide($dataTable);

    // var_dump("<textarea>{$html}</textarea>"); die;

    return $html;
  }
  private function createViewRead(array $dataTable)
  {
    $html = $this->htmlStart();
    $html .= $this->htmlTable($dataTable);
    $html .= $this->htmlEnd();

    // var_dump("<textarea>{$html}</textarea>"); die;
    return $html;
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

      <div class="form-floating">
        <input type="text" class="form-control" placeholder="" minlength="" maxlength="" name="text" id="text" value="" required>
        <label for="text" class="form-label">text</label>
      </div>
      <div class="form-floating">
        <textarea type="textarea" class="form-control" placeholder="" minlength="" maxlength="" name="textarea" id="textarea" required></textarea>
        <label for="textarea" class="form-label">textarea</label>
      </div>

      <div class="form-check">
        <input type="checkbox" class="form-check-input" name="checkbox" id="checkbox" value="">
        <label for="checkbox" class="form-check-label">checkbox</label>
      </div>
      <div class="form-check">
        <input type="radio" class="form-check-input" name="radio" id="radio" value="">
        <label for="radio" class="form-check-label">radio1</label>
      </div>
      <div class="form-check">
        <input type="radio" class="form-check-input" name="radio" id="radio" value="">
        <label for="radio" class="form-check-label">radio2</label>
      </div>


      <div class="form-floating">
        <input type="number" class="form-control" placeholder="" min="" max="" name="number" id="number" value="">
        <label for="number" class="form-label">number</label>
      </div>
      <div class="form-floating">
        <input type="email" class="form-control" placeholder="" minlength="" maxlength="" name="email" id="email" value="">
        <label for="email" class="form-label">email</label>
      </div>

      <div class="form-group">
        <label for="hidden" class="form-label">hidden</label>
        <input type="hidden" class="form-control" name="hidden" id="hidden" value="">
      </div>

      <div class="form-group">
        <label for="range" class="form-label">range</label>
        <input type="range" class="form-range" min="0" max="100" name="range" id="range" value="">
      </div>

      <div class="form-floating">
        <select class="form-select" name="select" id="select">
          <option selected>Open this select menu</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
        <label for="select" class="form-label">select</label>
      </div>

      <div class="form-floating">
        <input type="datetime-local" class="form-control" placeholder="" name="datetime-local" id="datetime-local" value="">
        <label for="datetime-local" class="form-label">datetime-local</label>
      </div>
      <div class="form-floating">
        <input type="date" class="form-control" placeholder="" min="0" max="100" name="date" id="date" value="">
        <label for="date" class="form-label">date</label>
      </div>
      <div class="form-floating">
        <input type="time" class="form-control" placeholder="" min="0" max="100" name="time" id="time" value="">
        <label for="time" class="form-label">time</label>
      </div>
      <div class="form-floating">
        <input type="week" class="form-control" placeholder="" min="0" max="100" name="week" id="week" value="">
        <label for="week" class="form-label">week</label>
      </div>
      <div class="form-floating">
        <input type="month" class="form-control" placeholder="" min="0" max="100" name="month" id="month" value="">
        <label for="month" class="form-label">month</label>
      </div>



      <div class="form-group">
        <label for="file" class="form-label">file</label>
        <input type="file" class="form-control" name="file" id="file" value="">
      </div>
      <div class="form-group">
        <label for="color" class="form-label">color</label>
        <input type="color" class="form-control form-control-color" name="color" id="color" value="">
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" placeholder="" minlength="" maxlength="" name="password" id="password" value="">
        <label for="password" class="form-label">password</label>
      </div>

      <div class="d-flex justify-content-center pt-3">
        <button type="submit" class="btn btn-primary btn-submit">Salvar</button>
      </div>
    
    <?= form_close(); ?>

    EOT;

    return $html_create;
  }

  private function validationClientSide(array $dataTable)
  {
    return "";
  }

  // funções aux
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

  private function strGetInputCreate(array $dataTable)
  {
    // retorna os registros que são chave primaria ou não possuem campo hidden 
    $arr_table_data_selected = array_filter($dataTable, function ($value) {
      return $value[GERADOR_COL_PK] || !$value[GERADOR_COL_HIDDEN];
    }, ARRAY_FILTER_USE_BOTH);

    $html_inputs = "";
    // var_dump('<pre>', $arr_table_data_selected); die;
    foreach ($arr_table_data_selected as $key => $table_input) {
      $input_config = array(
        'label' => $table_input[GERADOR_COL_NAMEFIELD_HTML],
        'type' => $table_input[GERADOR_COL_TYPEFIELD_HTML],
        'id' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'name' => $table_input[GERADOR_COL_NAMEFIELD_DB],
        'class' => '',
        'value' => '',
        'placeholder' => '',
        'required' => $table_input[GERADOR_COL_REQUIRED],
        'disabled' => '',
        'readonly' => '',
        'minValue' => '',
        'maxValue' => '',
        'minLength' => '',
        'maxLength' => '',
      );
      // var_dump('<pre>', $input_config); die;

      $html_inputs .= $this->strMakeInput($input_config);
      
    }
    var_dump($html_inputs); die;
    return $html_inputs;
  }

  private function strMakeInput(array $input_config)
  {

    $label = $input_config['label'];
    $type = $input_config['type'];
    $id = $input_config['id'];
    $name = $input_config['name'];
    $class_input = (isset($input_config['class']) && !empty($input_config['class'])) ? $input_config['class'] : '';
    $class_label = "form-label";

    $required = (isset($input_config['required']) && !empty($input_config['required'])) ? " required" : '';
    $disabled = (isset($input_config['disabled']) && !empty($input_config['disabled'])) ? " disabled" : '';
    $readonly = (isset($input_config['readonly']) && !empty($input_config['readonly'])) ? " readonly" : '';

    $placeholder = (isset($input_config['placeholder']) && !empty($input_config['placeholder'])) ? " placeholder=\"{$input_config['placeholder']}\"" : '';
    $minValue = (isset($input_config['minValue']) && !empty($input_config['minValue'])) ? " min=\"{$input_config['minValue']}\"" : '';
    $maxValue = (isset($input_config['maxValue']) && !empty($input_config['maxValue'])) ? " max=\"{$input_config['maxValue']}\"" : '';
    $minLength = (isset($input_config['minLength']) && !empty($input_config['minLength'])) ? " minLength=\"{$input_config['minLength']}\"" : '';
    $maxLength = (isset($input_config['maxLength']) && !empty($input_config['maxLength'])) ? " maxLength=\"{$input_config['maxLength']}\"" : '';

    if ($type == 'select') {

      $field_foreign_key = GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE;
      $field_foreign_value = GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE;

      $input = <<< EOT
      <div class="form-floating">
        <select class="form-select {$class_input}" name="{$id}" id="{$id}">
          <option selected>Selecione</option>
          <?php foreach (\$data as \$key => \$options) : ?>
            <option value="<?= \$option->{$field_foreign_key} ?>"><?= \$option->{$field_foreign_value} ?></option>
          <?php endforeach; ?>
        </select>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>
      EOT;

      var_dump("<textarea>select<br>{$input}</textarea>");
      die;
    } else if ($type == 'textarea') {

      $value = (isset($input_config['value']) && !empty($input_config['value'])) ? $input_config['value'] : '';

      $input = <<< EOT
      <div class="form-floating">
        <textarea type="textarea" class="form-control {$class_input}" name="{$id}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>$value</textarea>
        <label for="{$id}" class="{$class_label}">{$label}</label>
      </div>
      EOT;
    } else {

      $value = (isset($input_config['value']) && !empty($input_config['value'])) ? "value=\"{$input_config['value']}\"" : '';

      if ($type == 'checkbox' || $type == 'radio') {
        $class_input = "form-check-input";
        $class_label = "form-check-label";
      } else if ($type == 'range') {
        $class_input = "form-range";
      } else if ($type == 'hidden') {
        $input = <<< EOT
        <div class="form-floating">
          <input type="{$type}" class="form-control {$class_input}" name="{$id}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>
        </div>
        EOT;

        return $input;
      }

      $input = <<< EOT
        <div class="form-floating">
          <input type="{$type}" class="form-control {$class_input}" name="{$id}" id="{$id}"{$placeholder}{$minLength}{$maxLength}{$disabled}{$readonly}{$required}>
          <label for="{$id}" class="$class_label">{$label}</label>
        </div>
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
}
