<?php 

/* System modelo - Constantes */

defined('SYSTEM_EMAIL_FROM') or define('SYSTEM_EMAIL_FROM', 'naoresponda@peee.com.br'); // alterar email para email utilizado pelo sistema

defined('MODULOS')       or define('MODULOS', array( // inserir os usuarios que serão utilizados no sistema
    'SISTEMA' => array(
        'key' => 'SISTEMA',
        'title' => 'Sistema',
        'name' => 'sistema'
    ),
    'GESTOR' => array(
      'key' => 'GESTOR',
      'title' => 'Gestor',
      'name' => 'gestor'
    ),
    // 'USR_EXEMPLO' => array(
    //     'key' => 'USR_EXEMPLO', // chave a ser inserido no banco de dados
    //     'title' => 'Usuario exemplo', // nome a ser exibido para o usuario
    //     'name' => 'usuario exemplo'
    // ),
));