<?php

defined('FRAMEWORK_LIST') or define('FRAMEWORK_LIST', array(
  'CODEIGNITER_3' => array(
    'name' => 'CODEIGNITER_3',
    'title' => 'Codeigniter 3',
    'path' => 'Codeigniter3.php',
  ),
  'CODEIGNITER_4' => array(
    'name' => 'CODEIGNITER_4',
    'title' => 'Codeigniter 4',
    'path' => 'Codeigniter4.php',
  ),
));

defined('HTML_INPUT_TYPE_LIST') or define('HTML_INPUT_TYPE_LIST', array(
  'textarea' => array('name' => 'textarea', 'active' => TRUE),
  'select' => array('name' => 'select', 'active' => TRUE),
  'text' => array('name' => 'text', 'active' => TRUE),
  'checkbox' => array('name' => 'checkbox', 'active' => TRUE),
  'radio' => array('name' => 'radio', 'active' => TRUE),
  'number' => array('name' => 'number', 'active' => TRUE),
  'email' => array('name' => 'email', 'active' => TRUE),
  'hidden' => array('name' => 'hidden', 'active' => TRUE),
  'range' => array('name' => 'range', 'active' => TRUE),
  'datetime-local' => array('name' => 'datetime', 'active' => TRUE),
  'date' => array('name' => 'date', 'active' => TRUE),
  'time' => array('name' => 'time', 'active' => TRUE),
  'week' => array('name' => 'week', 'active' => TRUE),
  'month' => array('name' => 'month', 'active' => TRUE),
  'file' => array('name' => 'file', 'active' => TRUE),
  'color' => array('name' => 'color', 'active' => TRUE),
  'password' => array('name' => 'password', 'active' => TRUE),
));

defined('TYPE_EMAIL') or define('TYPE_EMAIL', 'email');

defined('GERADOR_COL_ID') or define('GERADOR_COL_ID', 'gerbas_codigo');
defined('GERADOR_COL_NAMETABLE') or define('GERADOR_COL_NAMETABLE', 'gerbas_nomeTabelaDB');
defined('GERADOR_COL_NAMEFIELD_DB') or define('GERADOR_COL_NAMEFIELD_DB', 'gerbas_CampoNomeDB');
defined('GERADOR_COL_NAMEFIELD_HTML') or define('GERADOR_COL_NAMEFIELD_HTML', 'gerbas_campoLabelHTML');
defined('GERADOR_COL_TYPEFIELD_HTML') or define('GERADOR_COL_TYPEFIELD_HTML', 'gerbas_tipoCampoHTML');
defined('GERADOR_COL_PK') or define('GERADOR_COL_PK', 'gerbas_campoPrimaryKey');
defined('GERADOR_COL_REQUIRED') or define('GERADOR_COL_REQUIRED', 'gerbas_campoRequired');
defined('GERADOR_COL_HIDDEN') or define('GERADOR_COL_HIDDEN', 'gerbas_campoHidden');
defined('GERADOR_COL_ORDER') or define('GERADOR_COL_ORDER', 'gerbas_campoOrden');
defined('GERADOR_COL_MIN_LENGTH') or define('GERADOR_COL_MIN_LENGTH', 'gerbas_tamanhoMin');
defined('GERADOR_COL_MAX_LENGTH') or define('GERADOR_COL_MAX_LENGTH', 'gerbas_tamanhoMax');
defined('GERADOR_COL_TYPE_VALIDATION') or define('GERADOR_COL_TYPE_VALIDATION', 'gerbas_tipoConsistencia');
defined('GERADOR_COL_TYPE_MASK') or define('GERADOR_COL_TYPE_MASK', 'gerbas_tipoMascara');
defined('GERADOR_COL_NAMETABLE_FOREIGN') or define('GERADOR_COL_NAMETABLE_FOREIGN', 'gerbas_TabelaRelacionada');
defined('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE') or define('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_CodigoCampo');
defined('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE') or define('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_descricaoCampo');
// defined('GERADOR_COL_NAME_FIELD_HTML_FOREIGN_TABLE') OR define('GERADOR_COL_NAME_FIELD_HTML_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_NomeCampoParaHTML');
