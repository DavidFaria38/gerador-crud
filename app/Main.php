<?php


require_once 'app/frameworks/codeigniter3/Codeigniter3.php';
require_once 'app/GetDataTable.php';

class Main
{
  private $dataTableTest = array(
    array(
      'gerbas_codigo' => '1',
      'gerbas_nomeTabelaDB' => 'Tmatricula',
      'gerbas_CampoNomeDB' => 'mat_codigo',
      'gerbas_campoLabelHTML' => 'codigo',
      'gerbas_campoPrimaryKey' => TRUE,
      'gerbas_campoRequired' => TRUE,
      'gerbas_campoHidden' => TRUE,
      'gerbas_ordemCampo' => 1,
      'gerbas_tamanhoMin' => 0,
      'gerbas_tamanhoMax' => 20,
      'gerbas_tipoConsistencia' => 'int',
      'gerbas_tipoMascara' => '',
      'gerbas_tipoCampoHTML' => 'hidden',
      'gerbas_TabelaRelacionada' => '',
      'gerbas_TabelaRelacionada_CodigoCampo' => '',
      'gerbas_TabelaRelacionada_descricaoCampo' => '',
      'gerbas_TabelaRelacionada_NomeCampoParaHTML' => '',
    ),
    array(
      'gerbas_codigo' => '2',
      'gerbas_nomeTabelaDB' => 'Tmatricula',
      'gerbas_CampoNomeDB' => 'mat_aluno_nome',
      'gerbas_campoLabelHTML' => 'nome aluno',
      'gerbas_campoPrimaryKey' => FALSE,
      'gerbas_campoRequired' => TRUE,
      'gerbas_campoHidden' => FALSE,
      'gerbas_ordemCampo' => 2,
      'gerbas_tamanhoMin' => 0,
      'gerbas_tamanhoMax' => 80,
      'gerbas_tipoConsistencia' => '',
      'gerbas_tipoMascara' => '',
      'gerbas_tipoCampoHTML' => 'text',
      'gerbas_TabelaRelacionada' => '',
      'gerbas_TabelaRelacionada_CodigoCampo' => '',
      'gerbas_TabelaRelacionada_descricaoCampo' => '',
      'gerbas_TabelaRelacionada_NomeCampoParaHTML' => '',
    ),
    array(
      'gerbas_codigo' => '3',
      'gerbas_nomeTabelaDB' => 'Tmatricula',
      'gerbas_CampoNomeDB' => 'mat_turma',
      'gerbas_campoLabelHTML' => 'turma',
      'gerbas_campoPrimaryKey' => FALSE,
      'gerbas_campoRequired' => TRUE,
      'gerbas_campoHidden' => FALSE,
      'gerbas_ordemCampo' => 3,
      'gerbas_tamanhoMin' => 0,
      'gerbas_tamanhoMax' => 0,
      'gerbas_tipoConsistencia' => '',
      'gerbas_tipoMascara' => '',
      'gerbas_tipoCampoHTML' => 'select',
      // 'gerbas_TabelaRelacionada' => '',
      // 'gerbas_TabelaRelacionada_CodigoCampo' => '',
      // 'gerbas_TabelaRelacionada_descricaoCampo' => '',
      // 'gerbas_TabelaRelacionada_NomeCampoParaHTML' => '',
      'gerbas_TabelaRelacionada' => 'Tturma',
      'gerbas_TabelaRelacionada_CodigoCampo' => 'tur_Codigo',
      'gerbas_TabelaRelacionada_descricaoCampo' => 'turma',
      'gerbas_TabelaRelacionada_NomeCampoParaHTML' => 'turma',
    ),
  );

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
      'validationClientSide' => NULL, // não implementado aidna
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
      $framework->createFromTable($arr_data_tables);
    }
  }
}
