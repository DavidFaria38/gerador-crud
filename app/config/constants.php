<?php

defined('BASEURL') or define('BASEURL', '/git/gerador_crud');

defined('DB_SERVERNAME') or define('DB_SERVERNAME', 'localhost');
defined('DB_USERNAME') or define('DB_USERNAME', 'root');
defined('DB_PASSWORD') or define('DB_PASSWORD', '');
defined('DB_NAME') or define('DB_NAME', 'gerador_base');


defined('FRAMEWORK_LIST') or define('FRAMEWORK_LIST', array(
  'CODEIGNITER_3' => array(
    'name' => 'CODEIGNITER_3',
    'title' => 'Codeigniter 3',
    'path' => 'Codeigniter3.php',
  ),
  // 'CODEIGNITER_4' => array(
  //   'name' => 'CODEIGNITER_4',
  //   'title' => 'Codeigniter 4',
  //   'path' => 'Codeigniter4.php',
  // ),
));

defined('HTML_INPUT_TYPE_LIST') or define('HTML_INPUT_TYPE_LIST', array(
  'textarea' => array('name' => 'textarea', 'active' => TRUE, 'attr_minMax' => 'length'),
  'select' => array('name' => 'select', 'active' => TRUE, 'attr_minMax' => 'length'),
  'text' => array('name' => 'text', 'active' => TRUE, 'attr_minMax' => 'length'),
  'checkbox' => array('name' => 'checkbox', 'active' => TRUE, 'attr_minMax' => FALSE),
  'radio' => array('name' => 'radio', 'active' => TRUE, 'attr_minMax' => FALSE),
  'number' => array('name' => 'number', 'active' => TRUE, 'attr_minMax' => 'value'),
  'email' => array('name' => 'email', 'active' => TRUE, 'attr_minMax' => 'length'),
  'hidden' => array('name' => 'hidden', 'active' => TRUE, 'attr_minMax' => FALSE),
  'range' => array('name' => 'range', 'active' => TRUE, 'attr_minMax' => 'value'),
  'datetime-local' => array('name' => 'datetime', 'active' => TRUE, 'attr_minMax' => 'value'),
  'datetime' => array('name' => 'date', 'active' => TRUE, 'attr_minMax' => 'value'),
  'date' => array('name' => 'date', 'active' => TRUE, 'attr_minMax' => 'value'),
  'time' => array('name' => 'time', 'active' => TRUE, 'attr_minMax' => 'value'),
  'week' => array('name' => 'week', 'active' => TRUE, 'attr_minMax' => 'value'),
  'month' => array('name' => 'month', 'active' => TRUE, 'attr_minMax' => 'value'),
  'file' => array('name' => 'file', 'active' => TRUE, 'attr_minMax' => FALSE),
  'color' => array('name' => 'color', 'active' => TRUE, 'attr_minMax' => FALSE),
  'password' => array('name' => 'password', 'active' => TRUE, 'attr_minMax' => 'length'),
  'url' => array('name' => 'url', 'active' => TRUE, 'attr_minMax' => 'length'),
));

defined('TYPE_EMAIL') or define('TYPE_EMAIL', 'email');

defined('GERADOR_DB_TABLE') or define('GERADOR_DB_TABLE', 'gerador_base');
defined('GERADOR_COL_ID') or define('GERADOR_COL_ID', 'gerbas_codigo');
defined('GERADOR_COL_NAMETABLE') or define('GERADOR_COL_NAMETABLE', 'gerbas_nomeTabelaDB');
defined('GERADOR_COL_NAMEFIELD_DB') or define('GERADOR_COL_NAMEFIELD_DB', 'gerbas_CampoNomeDB');
defined('GERADOR_COL_NAMEFIELD_HTML') or define('GERADOR_COL_NAMEFIELD_HTML', 'gerbas_campoLabelHTML');
defined('GERADOR_COL_TYPEFIELD_HTML') or define('GERADOR_COL_TYPEFIELD_HTML', 'gerbas_tipoCampoHTML');
defined('GERADOR_COL_PK') or define('GERADOR_COL_PK', 'gerbas_campoPrimaryKey');
defined('GERADOR_COL_REQUIRED') or define('GERADOR_COL_REQUIRED', 'gerbas_campoRequired');
defined('GERADOR_COL_HIDDEN') or define('GERADOR_COL_HIDDEN', 'gerbas_campoHidden');
defined('GERADOR_COL_ORDER') or define('GERADOR_COL_ORDER', 'gerbas_campoOrden');
defined('GERADOR_COL_REPORT') or define('GERADOR_COL_REPORT', 'gerbas_relatorio');
defined('GERADOR_COL_MIN_LENGTH') or define('GERADOR_COL_MIN_LENGTH', 'gerbas_tamanhoMin');
defined('GERADOR_COL_MAX_LENGTH') or define('GERADOR_COL_MAX_LENGTH', 'gerbas_tamanhoMax');
defined('GERADOR_COL_DEFAULT_VALUE') or define('GERADOR_COL_DEFAULT_VALUE', 'gerbas_campoValorDefault');
defined('GERADOR_COL_TYPE_VALIDATION') or define('GERADOR_COL_TYPE_VALIDATION', 'gerbas_tipoConsistencia');
defined('GERADOR_COL_TYPE_MASK') or define('GERADOR_COL_TYPE_MASK', 'gerbas_tipoMascara');
defined('GERADOR_COL_NAMETABLE_FOREIGN') or define('GERADOR_COL_NAMETABLE_FOREIGN', 'gerbas_TabelaRelacionada');
defined('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE') or define('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_CodigoCampo');
defined('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE') or define('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_descricaoCampo');
defined('GERADOR_COL_ACTIVE_FIELD_FOREIGN_TABLE') or define('GERADOR_COL_ACTIVE_FIELD_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_campo_ativo');
defined('GERADOR_COL_FUNCTION_FIELD') or define('GERADOR_COL_FUNCTION_FIELD', 'gerbas_FuncaoCampo');
defined('GERADOR_COL_FUNCTION_FIELD_TYPE') or define('GERADOR_COL_FUNCTION_FIELD_TYPE', 'gerbas_FuncaoCampoDestino');


defined('GERADOR_ATIVAR_REGISTRO') or define('GERADOR_ATIVAR_REGISTRO', array(
  '_ativo',
  '_publicardados',
  '_publicar_dados',
));
