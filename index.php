<?php 

require_once("vendor/autoload.php");
use \Slim\Slim;
use \Hcode\Page;



$app = new \Slim\Slim();

$app->config('debug', true);


$app->get('/', function() {

//////// rotas ///////
//contruct header
$page = new Page();
//metodo index
$page->setTpl("index");
//destrct footer

});

$app->run();







 ?>

