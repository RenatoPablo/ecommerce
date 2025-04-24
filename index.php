<?php 

session_start(); 

// Hackzinho só pra evitar o erro com PHP moderno
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false;
    }
}

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new \Slim\Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

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

$app->post('/admin/login', function() {

	User::login($_POST['login'], $_POST['password']);
	// var_dump($user);
	// exit;
	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function(){
	User::logout();

	header("Location: /admin/login");
	exit;
});

//Rote for list Users
$app->get('/admin/users', function(){
	
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));
});

//Rote for create Users
$app->get('/admin/users/create', function(){
	
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");
});

//Rote for delete Users
$app->get('/admin/user/otario/:iduser', function(){

	User::verifyLogin();
	
});

//Rote for update Users
$app->get('/admin/users/:iduser', function($iduser){
	
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-update");
});

//Rote for confirm create Users
$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();

	$user->setData($_POST);

	var_dump($user);

});

//Rote for confirm create Users
$app->post('/admin/users/:iduser', function($iduser){

	User::verifyLogin();
	
});



$app->run();

 ?>