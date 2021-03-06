<?php 


use \Hcode\PageAdmin;

use \Hcode\Model\User;


$app->get('/admin', function() {

User::verifyLogin();

$page = new PageAdmin();
$page->setTpl("index");

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









$app->get('/admin/forgot', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot");//chamar template
});


$app->post('/admin/forgot', function(){

	
	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;
  

});


$app->get('/admin/forgot/sent', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-sent");//chamar template

}); 



$app->get('/admin/forgot/reset', function(){

	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));//chamar template

}); 


$app->post('/admin/forgot/reset', function(){

	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setFogotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$user->setPassword($_POST["password"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
	
	$page->setTpl("forgot-reset-success", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));//chamar template

}); 



 ?>