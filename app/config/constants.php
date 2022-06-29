<?php 

defined('FRAMEWORK_LIST') OR define('FRAMEWORK_LIST', array(
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

defined('TYPE_EMAIL') OR define('TYPE_EMAIL', 'email');

defined('GERADOR_COL_ID') OR define('GERADOR_COL_ID', 'gerbas_codigo');
defined('GERADOR_COL_NAMETABLE') OR define('GERADOR_COL_NAMETABLE', 'gerbas_nomeTabelaDB');
defined('GERADOR_COL_NAMEFIELD_DB') OR define('GERADOR_COL_NAMEFIELD_DB', 'gerbas_CampoNomeDB');
defined('GERADOR_COL_NAMEFIELD_HTML') OR define('GERADOR_COL_NAMEFIELD_HTML', 'gerbas_campoLabelHTML');
defined('GERADOR_COL_TYPEFIELD_HTML') OR define('GERADOR_COL_TYPEFIELD_HTML', 'gerbas_tipoCampoHTML');
defined('GERADOR_COL_PK') OR define('GERADOR_COL_PK', 'gerbas_campoPrimaryKey');
defined('GERADOR_COL_REQUIRED') OR define('GERADOR_COL_REQUIRED', 'gerbas_campoRequired');
defined('GERADOR_COL_HIDDEN') OR define('GERADOR_COL_HIDDEN', 'gerbas_campoHidden');
defined('GERADOR_COL_ORDER') OR define('GERADOR_COL_ORDER', 'gerbas_campoOrden');
defined('GERADOR_COL_MIN_LENGTH') OR define('GERADOR_COL_MIN_LENGTH', 'gerbas_tamanhoMin');
defined('GERADOR_COL_MAX_LENGTH') OR define('GERADOR_COL_MAX_LENGTH', 'gerbas_tamanhoMax');
defined('GERADOR_COL_TYPE_VALIDATION') OR define('GERADOR_COL_TYPE_VALIDATION', 'gerbas_tipoConsistencia');
defined('GERADOR_COL_TYPE_MASK') OR define('GERADOR_COL_TYPE_MASK', 'gerbas_tipoMascara');
defined('GERADOR_COL_NAMETABLE_FOREIGN') OR define('GERADOR_COL_NAMETABLE_FOREIGN', 'gerbas_TabelaRelacionada');
defined('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE') OR define('GERADOR_COL_PK_FIELD_NAME_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_CodigoCampo');
defined('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE') OR define('GERADOR_COL_VALUE_FIELD_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_descricaoCampo');
// defined('GERADOR_COL_NAME_FIELD_HTML_FOREIGN_TABLE') OR define('GERADOR_COL_NAME_FIELD_HTML_FOREIGN_TABLE', 'gerbas_TabelaRelacionada_NomeCampoParaHTML');
