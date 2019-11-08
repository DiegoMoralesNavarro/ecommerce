<?php 



use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;


$app->get('/admin/categories', function(){

	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();
	
	$page->setTpl("categories", [
		'categories'=>$categories
	]);//chamar template

});


$app->get('/admin/categories/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();
	
	$page->setTpl("categories-create");//chamar template

});

$app->post('/admin/categories/create', function(){

	User::verifyLogin();

	

	$category = new Category();

	$category->setData($_POST);
	$category->save();

	header("Location: /admin/categories");
	exit;
  

});



$app->get('/admin/categories/:idcategory/delete', function($idcategory){

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory); //metodo

	$category->delete();
	
	header("Location: /admin/categories");
	exit;

});



$app->get('/admin/categories/:idcategory', function($idcategory){

	User::verifyLogin();

	//carregar do banco os cados do id clicado

	$category = new Category();

	$category->get((int)$idcategory); //metodo



	//carregar template 

	$page = new PageAdmin();
	
	$page->setTpl("categories-update",['category'=>$category->getValues()]);//chamar template

});



$app->post('/admin/categories/:idcategory', function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;


});

$app->get('/categories/:idcategory', function($idcategory){

	$category = new Category();

	$category->get((int)$idcategory);

	//contruct header
$page = new Page();
//metodo index
$page->setTpl("category",[
	"category"=>$category->getValues(),
	"products"=>[]
]);



});






 ?>