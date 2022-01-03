<?php
date_default_timezone_set('America/Sao_Paulo');
ob_start();
session_start();

//error_reporting ( E_ALL  ^  E_NOTICE ); 
error_reporting(0);
ini_set('display_errors', 0 );

function is_localhost(){
	
    $whitelist = array( '127.0.0.1', '::1' );
    
    if(in_array($_SERVER['SERVER_ADDR'], $whitelist) || $_SERVER['SERVER_ADDR'] == $_SERVER['HTTP_HOST']){
		
    	return true;
	}
}

$url = explode('/',$_SERVER['REQUEST_URI']);
array_shift($url);

$http = (($_SERVER['SERVER_PORT'] == 443)?('https://'):('http://'));
$urlC 	= (is_localhost())?($http.$_SERVER['SERVER_NAME'].'/'.$url[0].'/admin/'):($http.$_SERVER['SERVER_NAME'].'/admin/');
$dir_up = (is_localhost())?(1):(0);
$pagina = $url[1 + $dir_up];


if(stristr($pagina, '?') == TRUE){
	$pagina = explode('?', $pagina);
	$pagina = $pagina[0];
}

$parametro = (isset($url[2 + $dir_up]))?($url[2 + $dir_up]):(NULL);

if(stristr($parametro, '?') == TRUE){
	$parametro = explode('?', $parametro);
	$parametro = $parametro[0];
}


include_once("includes/classes/Db.php"); 
include_once("includes/classes/Util.php"); 
include_once("includes/classes/Select.php");
include_once("includes/classes/Insert.php"); 
include_once("includes/classes/Update.php"); 
include_once("includes/classes/Delete.php"); 

$conn = Db::connect();

$select = new Select();
$insert = new Insert();
$update = new Update();
$delete = new Delete();

$query_info = $conn->query("SELECT * FROM informacao_site LIMIT 1");
$result_info = $query_info->fetch_array();

$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $query_config->fetch_array();

if(isset($_SESSION['login'])){
	
	if(stristr($pagina, 'ajax') == TRUE){
	
		include_once('includes/ajax/'.$pagina.'.php'); 
	}else{
		
		include_once("includes/header.php");

		if(empty($pagina)){
			
			header('Location:'.$urlC.'home'); 
		}else{
			
			if(file_exists('includes/'.$pagina.'.php')){
				
				include_once('includes/'.$pagina.'.php');
			}else{
				
				include_once('includes/404.php');	
			}
		} 

		include_once('includes/rodape.php');
	}
}else{
	
	include_once("includes/header.php");
	
	if(empty($pagina)){
		
		header('Location:'.$urlC.'login'); 
	}else{
		
		include_once('includes/'.$pagina.'.php');
	} 

	include_once('includes/rodape.php');
}

?>