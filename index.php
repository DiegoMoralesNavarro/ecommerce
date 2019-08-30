<?php 
session_start();

require_once("vendor/autoload.php");
//require_once("functions.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;

use \Hcode\Model\User;


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

$app->get('/admin', function() {

User::verifyLogin();

$page = new PageAdmin();
$page->setTpl("index");
//destrct footer
});

$app->get('/admin/login', function() {

$page = new PageAdmin([
	"header"=>false,
	"footer"=>false
]);
$page->setTpl("login");

});

//rota metodo Post
$app->post('/admin/login', function() {

	//metodo statico
	User::login($_POST["deslogin"],$_POST["despassword"]);

	//direcionar
	header("Location: /admin");
	exit;

});


$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;

});



$app->run();







 ?>

