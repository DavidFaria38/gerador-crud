<?php


require_once 'app/frameworks/codeigniter3/Codeigniter3.php';
class Main
{
    private $dataTableTest = array(
        array(
          'gerbas_codigo' => '1',
          'gerbas_nomeTabelaDB' => 'Tmatricula',
          'gerbas_CampoNomeDB' => 'mat_codigo',
          'gerbas_campoTitleHTML' => 'codigo',
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
          'gerbas_campoTitleHTML' => 'nome aluno',
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
          'gerbas_campoTitleHTML' => 'turma',
          'gerbas_campoPrimaryKey' => FALSE,
          'gerbas_campoRequired' => TRUE,
          'gerbas_campoHidden' => FALSE,
          'gerbas_ordemCampo' => 3,
          'gerbas_tamanhoMin' => 0,
          'gerbas_tamanhoMax' => 0,
          'gerbas_tipoConsistencia' => '',
          'gerbas_tipoMascara' => '',
          'gerbas_tipoCampoHTML' => 'select',
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
        if(!array_key_exists($typeFramework, FRAMEWORK_LIST)){
            exit("Framework {$typeFramework} não existe.");
        }

        // exit("Framework {$typeFramework} existe.");

        if($typeFramework == FRAMEWORK_LIST['CODEIGNITER_3']['name']){
          // use Codeigniter3;
          $framework = new Codeigniter3();
        }
        
        $framework->createFromTable($this->dataTableTest);
    }
}
