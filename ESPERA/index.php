<?php
session_save_path('sessions');
date_default_timezone_set('America/Sao_Paulo');
ob_start();
session_start();

function is_localhost(){
	
    $whitelist = array( '127.0.0.1', '::1' );
    
    if(in_array($_SERVER['SERVER_ADDR'], $whitelist) || $_SERVER['SERVER_ADDR'] == $_SERVER['HTTP_HOST']){
		
    	return true;
	}
}

$url = explode('/',$_SERVER['REQUEST_URI']);
array_shift($url);

$http = (($_SERVER['SERVER_PORT'] == 443)?('https://'):('http://'));
$urlC 	= (is_localhost())?($http.$_SERVER['SERVER_NAME'].'/'.$url[0].'/'):($http.$_SERVER['SERVER_NAME'].'/');
$dir_up = (is_localhost())?(1):(0);
$pagina = $url[0 + $dir_up];

if(stristr($pagina, '?') == TRUE){
	
	$pagina = explode('?', $pagina);
	$pagina = $pagina[0];
}

$parametro = (isset($url[1 + $dir_up]))?($url[1 + $dir_up]):(NULL);

if(stristr($parametro, '?') == TRUE){
	
	$parametro = explode('?', $parametro);
	$parametro = $parametro[0];
}

$subparametro = (isset($url[2 + $dir_up]))?($url[2 + $dir_up]):(NULL);

if(stristr($subparametro, '?') == TRUE){
	
	$subparametro = explode('?', $subparametro);
	$subparametro = $subparametro[0];
}

// QUALQUER ARQUIVO QUE POSSUIR A PALAVRA "ajax" NO NOME SERÁ CHAMADO SEM O HTML, APENAS COM AS CLASSES, E DEVE SER COLOCADO NO DIRETORIO "ajax/"
if(stristr($pagina, 'ajax') == TRUE){
	
	include_once('includes/ajax/'.$pagina.'.php'); 
}else{
	
	include_once('includes/header.php'); 
	
    include_once('includes/cabecalho.php'); 

	if($pagina == NULL){
		
		header('Location:'.$urlC.'home'); 
	}else{
		
		if(file_exists('includes/'.$pagina.'.php')){
			
			include_once('includes/'.$pagina.'.php');
		}else{
			
			include_once('includes/404.php');
		}
	}
		
    include_once("includes/rodape.php");
}

?>
