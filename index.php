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


$app->get('/admin/users', function() {

User::verifyLogin();
$users = User::listAll();

$page = new PageAdmin();
$page->setTpl("users", array(
	"users"=>$users
));
//destrct footer
});


$app->get('/admin/users/create', function() {

	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("users-create");

});

$app->get('/admin/users/:iduser/delete', function($iduser) {

	User::verifyLogin();

});

$app->get('/admin/users/:iduser', function($iduser) {

	User::verifyLogin();

	$page = new PageAdmin();
	$page->setTpl("users-update");

});

//post envia 

$app->post('/admin/users/create', function() {

	User::verifyLogin();

	//var_dump($_POST);
	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->setData($_POST);
	var_dump($user);
	//var_dump($user->getValues());

	$user->save();
	//direcionar
	header("Location: /admin/users");
	exit;



});

$app->post('/admin/users/:iduser', function($iduser) {

	User::verifyLogin();

});





$app->run();







 ?>

