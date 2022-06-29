<?php 

require_once 'app/config/constants.php';
require_once 'app/Main.php';

$selectedFramework = FRAMEWORK_LIST[array_key_first(FRAMEWORK_LIST)]['name'];

$a = new Main();
$a->run($selectedFramework);