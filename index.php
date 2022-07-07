<?php 

require_once 'app/config/constants.php';
require_once 'app/Main.php';
require_once 'app/config/Router.php';
require_once 'app/config/Request.php';


$router = new Router(new Request);

$router->get('/', function() {
  return <<<HTML
  <h1>Hello world!</h1>
  HTML;
});


// $selectedFramework = FRAMEWORK_LIST[array_key_first(FRAMEWORK_LIST)]['name'];

// $a = new Main();
// $a->run($selectedFramework);
// $a->makeDB();