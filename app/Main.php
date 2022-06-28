<?php



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
        exit("Framework {$typeFramework} existe.");
    }
}
