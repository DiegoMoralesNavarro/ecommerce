<?php 


use \Hcode\PageAdmin;
use \Hcode\Model\User;

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



$app->get('/admin/users/:iduser/delete', function($iduser) {
	User::verifyLogin();//verificar se está logado

	$user = new User();
	$user->get((int)$iduser);//setar o valor na super global e voltar

	$user->delete();
	header("Location: /admin/users");
	exit;
	
});

$app->get('/admin/users/:iduser', function($iduser){
 
   User::verifyLogin();
 
   $user = new User();
 
   $user->get((int)$iduser);
 
   $page = new PageAdmin();
 
   $page ->setTpl("users-update", array(
        "user"=>$user->getValues()
    ));
 
});



$app->post('/admin/users/:iduser', function($iduser){
 
   User::verifyLogin();
 
   $user = new User();
 
   $user->get((int)$iduser);

   $user->setData($_POST);

   $user->update();
 
 	header("Location: /admin/users");
	exit;
  
 
});






 ?>