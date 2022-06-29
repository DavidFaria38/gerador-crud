<?php


require_once 'app/frameworks/codeigniter3/Codeigniter3.php';
class Main
{
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
        
        $framework->createFromTable(array());
    }
}
