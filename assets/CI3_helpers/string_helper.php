<?php

function clear_cpf($cpf = '')
{
    $str = str_replace('-', '', $cpf);
    $str = str_replace('.', '', $str);
    return $str;
}

function clear_cnpj($cnpj = '')
{
    $str = str_replace('-', '', $cnpj);
    $str = str_replace('.', '', $str);
    $str = str_replace('/', '', $str);
    
    return $str;
}

function format_cpf_cnpj($value)
{
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === 11) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function humanize_boolean($value = 0)
{
    if ($value) return 'Sim';
    return 'Não';
}

function humanize_tipo_correcao($tipo = CORRECAO_AUTOMATICA)
{
  if ($tipo === CORRECAO_AUTOMATICA) return "Automático";
  else if ($tipo === CORRECAO_TUTOR) return "Tutor";
}

function money_to_decimal($money = '')
{
  $dc = str_replace(".","", $money);
  $dc = str_replace(",", ".", $dc);
  return $dc;
}

function in_string_comma_separated($str = '', $search = '')
{
  $parts = explode(',', $str);
  for($i = 0; $i < count($parts); $i++)
  {
    $parts[$i] = strtoupper(trim($parts[$i]));
  }

  return in_array(strtoupper($search), $parts);
}