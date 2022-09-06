<?php


function render_template($page = '', $data = array())
{
  $ci = &get_instance();

  $data['header_title'] = (!empty($data['header_title'])) ? $data['header_title'] : 'Modelo';

  $ci->load->view("modelo/template/header", $data);
  $ci->load->view("modelo/template/menu", $data);
  $ci->load->view("modelo/{$page}", $data);
  $ci->load->view("modelo/template/footer", $data);
}

function render_template_usuario($page = '', $data = array())
{
  $ci = &get_instance();

  $ci->load->view("area_usuario/template/top", $data);
  $ci->load->view("area_usuario/template/menu", $data);
  $ci->load->view("area_usuario/{$page}", $data);
  $ci->load->view("area_usuario/template/bottom", $data);
}

function base_url_assets($url = '')
{
  return base_url("assets/{$url}");
}

function base_url_uploads($url = '')
{
  return base_url("uploads/{$url}");
}

function base_url_usuario($url = '')
{
  return base_url("usuario/{$url}");
}

/*=======================================
  form validation - validação de formulario
  =======================================*/

function form_validation_errors()
{
  return validation_errors("<div class='alert alert-danger'>", "</div>");
}

function form_validation_input($input_key)
{
  if (empty(form_error($input_key))) {
    return '';
  }
  return 'is-invalid';
}

/*=======================================
  set flashdata - mensagens retorno
  =======================================*/

function set_flash_message_danger($key = '', $message = '')
{
  $ci = &get_instance();

  $ci->session->set_flashdata($key, "<div class='alert alert-danger'>{$message}</div>");
}

function set_flash_message_warning($key = '', $message = '')
{
  $ci = &get_instance();

  $ci->session->set_flashdata($key, "<div class='alert alert-warning'>{$message}</div>");
}

function set_flash_message_success($key = '', $message = '')
{
  $ci = &get_instance();

  $ci->session->set_flashdata($key, "<div class='alert alert-success email-enviado'>{$message}</div>");
}

function get_flash_message($key = '')
{
  $ci = &get_instance();

  $flash_message = $ci->session->flashdata($key);
  $ci->session->set_flashdata($key, NULL);

  return $flash_message;
}

function response_json($data = array())
{
  $ci = &get_instance();

  return $ci->output
    ->set_content_type('application/json')
    ->set_output(json_encode($data));
}


function build_edit_button($link = '')
{
  return "<a href='{$link}' class='btn btn-info'><i class='fa fa-edit' aria-hidden='true'></i></a>";
}

function build_delete_button($link = '')
{
  return "<a href='{$link}' class='btn btn-danger btn-excluir'><i class='fa fa-trash' aria-hidden='true'></i></a>";
}

function build_substituicao_button($link = '')
{
  return "<a href='{$link}' class='btn btn-warning'><i class='fa fa-random' aria-hidden='true'></i></a>";
}

function build_form_validation_create($fields = array())
{
  $validations = array();
  foreach ($fields as $field_name => $field) {
    if ($field['required']) {
      $validations[$field_name]['required'] = TRUE;
    }
  }

  $validations_str = json_encode($validations);

  $script_validation = "
    $('form').validate({
        rules: {$validations_str},
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    })";

  return $script_validation;
}

function build_form_mask($fields = array())
{
  $script_mask = "";

  foreach ($fields as $field_name => $field) {
    if (!empty($field['html_def']['mask'])) {
      $script_mask .= "$('#{$field_name}').inputmask('{$field['html_def']['mask']}')\n";
    }
  }

  return $script_mask;
}

function build_form_create($fields = array())
{
  $form_str = "";

  foreach ($fields as $field_name => $field) {
    $extra_class = $field['html_def']['extra_class'];
    $html_type = $field['html_def']['type'];
    if ($field['type'] === 'bool') {
      $checked = "checked";
      $tag_str = "<div class='form-check'>
                  <input type='checkbox' class='form-check-input {$extra_class}' id='{$field_name}' name='{$field_name}' {$checked} >
                  <label class='form-check-label' for='{$field_name}'>{$field['label']}</label>
                </div>";
    } else {
      $tag_str = "<div class='form-group'>";
      $tag_str .= "<label for='{$field_name}'>{$field['label']}</label>";
      if ($field['related']) {
        $related_field_key = $field['related_config']['key'];
        $related_field_value = $field['related_config']['value'];

        $tag_str .= "<select class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}'>";
        $tag_str .= "<option></option>";

        foreach ($field['related_data'] as $data) {
          if (set_value($field_name) == $data[$related_field_key]) {
            $tag_str .= "<option value='{$data[$related_field_key]}' selected>{$data[$related_field_value]}</option>";
          } else {
            $tag_str .= "<option value='{$data[$related_field_key]}'>{$data[$related_field_value]}</option>";
          }
        }
        $tag_str .= "</select>";
      } else {
        if ($field['type'] === 'text' && empty($field['size'])) {
          $tag_str .= "<textarea class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}'>" . set_value($field_name) . "</textarea>";
        } else if ($field['type'] === 'date') {
          $tag_str .= "<input type='text' maxlength='10' class='form-control date_picker {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='" . set_value($field_name) . "' />";
        } else if ($field['type'] === 'datetime') {
          $tag_str .= "<input type='text' class='form-control datetime_picker {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='" . set_value($field_name) . "' />";
        } else if ($field['type'] === 'int') {
          $tag_str .= "<input type='number' min='0' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='" . set_value($field_name) . "' />";
        } else {
          if (!empty($html_type)) {
            $tag_str .= "<input type='{$html_type}' maxlength='{$field['size']}' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='" . set_value($field_name) . "' />";
          } else {
            $tag_str .= "<input type='text' maxlength='{$field['size']}' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='" . set_value($field_name) . "' />";
          }
        }
      }


      $tag_str .= "</div>";
    }

    $form_str .= $tag_str;
  }

  return $form_str;
}

function build_form_update($fields = array(), $register = array())
{
  $form_str = "";

  foreach ($fields as $field_name => $field) {
    $extra_class = $field['html_def']['extra_class'];
    $html_type = $field['html_def']['type'];

    if ($field['type'] === 'bool') {
      $checked = ($register[$field_name]) ? "checked" : "";
      $tag_str = "<div class='form-check'>
                  <input type='checkbox' class='form-check-input {$extra_class}' id='{$field_name}' name='{$field_name}' {$checked} >
                  <label class='form-check-label' for='{$field_name}'>{$field['label']}</label>
                </div>";
    } else {
      $tag_str = "<div class='form-group'>";
      $tag_str .= "<label for='{$field_name}'>{$field['label']}</label>";
      if ($field['related']) {
        $related_field_key = $field['related_config']['key'];
        $related_field_value = $field['related_config']['value'];

        $tag_str .= "<select class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}'>";
        $tag_str .= "<option></option>";

        foreach ($field['related_data'] as $data) {
          if ($register[$field_name] == $data[$related_field_key]) {
            $tag_str .= "<option value='{$data[$related_field_key]}' selected>{$data[$related_field_value]}</option>";
          } else {
            $tag_str .= "<option value='{$data[$related_field_key]}'>{$data[$related_field_value]}</option>";
          }
        }
        $tag_str .= "</select>";
      } else {
        if ($field['type'] === 'text' && empty($field['size'])) {
          $tag_str .= "<textarea class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}'>" . $register[$field_name] . "</textarea>";
        } else if ($field['type'] === 'date') {
          $tag_str .= "<input type='text' maxlength='10' class='form-control date_picker {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='{$register[$field_name]}' />";
        } else if ($field['type'] === 'datetime') {
          $tag_str .= "<input type='text' class='form-control datetime_picker {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='{$register[$field_name]}' />";
        } else if ($field['type'] === 'int') {
          $tag_str .= "<input type='number' min='0' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='{$register[$field_name]}' />";
        } else if ($field['type'] === 'bool') {
        } else {
          if (!empty($html_type)) {
            $tag_str .= "<input type='{$html_type}' maxlength='{$field['size']}' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='{$register[$field_name]}' />";
          } else {
            $tag_str .= "<input type='text' maxlength='{$field['size']}' class='form-control {$extra_class}' name='{$field_name}' id='{$field_name}' placeholder='{$field['label']}' value='{$register[$field_name]}' />";
          }
        }
      }


      $tag_str .= "</div>";
    }


    $form_str .= $tag_str;
  }

  return $form_str;
}

function build_table($fields_label = array())
{
  $table_tag = "<table id='example2' class='table table-bordered table-hover'>
    <thead>
    <tr>";

  foreach ($fields_label as $label) {
    $table_tag .= "<th>{$label}</th>";
  }

  $table_tag .= "<td></td></tr></table>";

  return $table_tag;
}

function render_progress_bar($percentual, $show_porcentagem = TRUE)
{
  $bg = "bg-gradient-primary";
  // $percentual = 85;

  if ($show_porcentagem) {
    $progress_bar =
      "<div class='progress' style='height:21px; width:100%; background-color: #C4C4C4; position: relative;margin: 0 auto;left: 0;right: 0;'>
      <div class='progress-bar {$bg}' role='progressbar' style='width: {$percentual}%;' aria-valuenow='{$percentual}' aria-valuemin='0' aria-valuemax='100'>
        <span style='color: black;position: absolute; margin: 0 auto; left: 0; right: 0;'> {$percentual}% </span>
      </div>
    </div>";
  } else {
    $progress_bar =
      "<div class='progress' style='height:21px; width:100%; background-color: #C4C4C4; position: relative;margin: 0 auto;left: 0;right: 0;'>
      <div class='progress-bar {$bg}' role='progressbar' style='width: {$percentual}%;' aria-valuenow='{$percentual}' aria-valuemin='0' aria-valuemax='100'></div>
    </div>";
  }

  return $progress_bar;
}
function render_progress_bar_modulo($percentual, $show_porcentagem = TRUE)
{
  $bg = "bg-gradient-primary";
  // $percentual = 85;

  if ($show_porcentagem) {
    $progress_bar =
      "<div class='progress' style='height:23px; width:100%; min-width:110px; color:#C4C4C4; font-weight: normal; position: relative;margin: 0 auto;left: 0;right: 0;'>
        <div class='progress-bar {$bg}' role='progressbar' style='width:{$percentual}%;' aria-valuenow='{$percentual}' aria-valuemin='0' aria-valuemax='100'>
          <span style='color: black;position: absolute; margin: 0 auto; left: 0; right: 0;'> {$percentual}% </span>
        </div>
    </div>";
  } else {
    $progress_bar =
      "<div class='progress' style='height:23px; width:100%; min-width:110px; color:#C4C4C4; font-weight: normal; position: relative;margin: 0 auto;left: 0;right: 0;'>
      <div class='progress-bar {$bg}' role='progressbar' style='width:{$percentual}%;' aria-valuenow='{$percentual}' aria-valuemin='0' aria-valuemax='100'></div>
    </div>";
  }

  return $progress_bar;
}

function checkbox_to_bool($arr = array(), $field = '')
{
  if (array_key_exists($field, $arr) && $arr[$field] == 'on') {
    return TRUE;
  }
  return FALSE;
}

function set_value_input($registro = array(), $field = '')
{
  if (empty($registro)) return "";

  if (array_key_exists($field, $registro)) {
    return $registro[$field];
  }

  return set_value($field);
}

function set_value_select($registro = array(), $field = '', $value_option = '')
{
  if (array_key_exists($field, $registro)) {
    return ($registro[$field] == $value_option) ? "selected" : "";
  }

  return (set_value($field) == $value_option) ? "selected" : "";
}

function set_value_checkbox($registro = array(), $field = '')
{
  if (array_key_exists($field, $registro)) {
    return ($registro[$field]) ? "checked" : "";
  }

  if (set_value($field) == 'on') {
    return "checked";
  }

  return "";
}

function set_value_radio($registro = array(), $field = '', $value = '')
{
  if (empty($registro)) return "";

  if (array_key_exists($field, $registro)) {
    return ($registro[$field] == $value) ? "checked" : "";
  }

  if (set_value($field) == $value) {
    return "checked";
  }

  return "";
}
