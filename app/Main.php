<?php


require_once 'app/frameworks/codeigniter3/Codeigniter3.php';
require_once 'app/DataGerador.php';

class Main
{
  function __construct()

  {
    // echo "class::Main inicializada!<br>";
  }

  function run(array $config = array())
  {
    if (!isset($config['frameworkType'])) {
      exit(json_encode(['error' => "Configurações invalida."]));

    }
    if (!array_key_exists($config['frameworkType'], FRAMEWORK_LIST)) {
      exit(json_encode(['error' => "Framework {$config['frameworkType']} não existe."]));

    }

    // configurações do gerador de crud
    $config_framework = array(
      // 'fileNameController' => '', // no controller, nome do arquivo controller; OBS: é definido na framework
      // 'fileNameModel' => '', // no controller e model, nome do arquivo model; OBS: é definido na framework
      'fileNameViewCreate' => 'inserir', // na view, nome header e titulo do arquivo
      'fileNameViewRead' => 'consultar', // na view, nome header e titulo do arquivo
      'fileNameViewUpdate' => 'alterar', // na view, nome header e titulo do arquivo
      'functionNameCreate' => 'inserir', // no controller e model, define nome da função
      'functionNameRead' => 'consultar', // no controller e model, define nome da função
      'functionNameUpdate' => 'alterar', // no controller e model, define nome da função
      'functionNameDelete' => 'remover', // no controller e model, define nome da função
      'functionNameSufix' => 'salvar', // no controller, sufixo para funções de salvar registro
      'functionDeleteResponseJson' => TRUE, // no controller, se função de remoção de registro retorna uma resposta em json
      'directoryName' => '', // nome do diretorio a onde será armazenado os arquivos
    );

    if ($config['frameworkType'] == FRAMEWORK_LIST['CODEIGNITER_3']['name']) {
      $config_framework['directoryName'] = 'codeigniter3_' . date('Y-m-d_H-i-s');

      $framework = new Codeigniter3($config_framework);
    }

    $getDataTable = new DataGerador();
    $arr_data_tables = $getDataTable->getDataTable();

    $selectedTables = $config['selectedTables'];

    foreach ($arr_data_tables as $key => $arr_data_table) {
      if ($selectedTables[array_search($key, $selectedTables)] == $key) {
        $dump_dir = $framework->createFromTable($arr_data_table);
      }
    }

    return $dump_dir;
  }

  function makeDB()
  {
    $db = new Database();

    $db->createDB();
    $db->createTable();
  }
}
