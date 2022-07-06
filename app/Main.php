<?php


require_once 'app/frameworks/codeigniter3/Codeigniter3.php';
require_once 'app/GetDataTable.php';

class Main
{
  function __construct()

  {
    echo "class::Main inicializada!<br>";
  }

  function run(string $typeFramework)
  {
    if (!array_key_exists($typeFramework, FRAMEWORK_LIST)) {
      exit("Framework {$typeFramework} não existe.");
    }

    // configurações do gerador de crud
    $config = array(
      // 'fileNameController' => '', // no controller, nome do arquivo controller; OBS: é definido na framework
      // 'fileNameModel' => '', // no controller e model, nome do arquivo model; OBS: é definido na framework
      'fileNameViewCreate' => 'inserir', // na view, nome header e titulo do arquivo
      'fileNameViewRead' => 'consultar', // na view, nome header e titulo do arquivo
      'fileNameViewUpdate' => 'alterar', // na view, nome header e titulo do arquivo
      'validationServerSide' => TRUE, // no controller, há validação dos inputs
      'validationClientSide' => TRUE, // não implementado aidna
      'functionNameCreate' => 'inserir', // no controller e model, define nome da função
      'functionNameRead' => 'consultar', // no controller e model, define nome da função
      'functionNameUpdate' => 'alterar', // no controller e model, define nome da função
      'functionNameDelete' => 'remover', // no controller e model, define nome da função
      'functionNameSufix' => 'salvar', // no controller, sufixo para funções de salvar registro
      'functionDeleteResponseJson' => TRUE, // no controller, se função de remoção de registro retorna uma resposta em json
      'directoryName' => '', // nome do diretorio a onde será armazenado os arquivos
    );

    if ($typeFramework == FRAMEWORK_LIST['CODEIGNITER_3']['name']) {
      $config['directoryName'] = 'codeigniter3_' . date('Y-m-d_H-i-s');

      $framework = new Codeigniter3($config);
    }

    $getDataTable = new GetDataTable();
    $arr_data_tables = $getDataTable->getDataTable();

    foreach ($arr_data_tables as $key => $arr_data_table) {
      $framework->createFromTable($arr_data_table);
    }
  }

  function makeDB(){
    $db = new Database();

    var_dump($db->createDB());
    $db->createTable();
  }
}
