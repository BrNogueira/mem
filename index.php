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

$urlFull = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if(stristr($urlFull, '?') == TRUE){
	
	$urlX = explode('?',$urlFull);
	$urlX = $urlX[0];
}else{
	
	$urlX = $urlFull;
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

if($pagina != 'dica'){
	
	if(stristr($parametro, '?') == TRUE){
		
		$parametro = explode('?', $parametro);
		$parametro = $parametro[0];
	}
}

$subparametro = (isset($url[2 + $dir_up]))?($url[2 + $dir_up]):(NULL);

if(stristr($subparametro, '?') == TRUE){
	
	$subparametro = explode('?', $subparametro);
	$subparametro = $subparametro[0];
}

include_once('admin/includes/classes/Db.php');
include_once('admin/includes/classes/Util.php');
include_once('admin/includes/classes/Select.php');
include_once('admin/includes/classes/Insert.php'); 
include_once('admin/includes/classes/Update.php'); 
include_once('admin/includes/classes/Delete.php');
require_once('includes/classes/Usuario.php');
require_once('includes/classes/Carrinho.php');
require_once('includes/classes/Produto.php');
include_once('includes/classes/Frete.php');
include_once('includes/classes/PagSeguro.php');

$conn = Db::connect();

$select = new Select();
$insert = new Insert();
$update = new Update();
$delete = new Delete();

$usuario_obj = new Usuario();

$query_config = $conn->query("SELECT * FROM configuracao LIMIT 1");
$config = $query_config->fetch_array();

$query_info = $conn->query("SELECT * FROM informacao_site LIMIT 1");
$result_info = $query_info->fetch_array();

$_SESSION['result_info'] = $result_info;

// QUALQUER ARQUIVO QUE POSSUIR A PALAVRA "ajax" NO NOME SERÁ CHAMADO SEM O HTML, APENAS COM AS CLASSES, E DEVE SER COLOCADO NO DIRETORIO "ajax/"
if(stristr($pagina, 'ajax') == TRUE){
	
	include_once('includes/ajax/'.$pagina.'.php'); 
}else{
	
	include_once('includes/header.php'); 
	include_once('includes/cabecalho.php'); 

	if($pagina == NULL){
		
		header('Location:'.$urlC.'home'); 
	}else{
		
		if(in_array($pagina, array('categoria','subcategoria','colecao','secao','destaque'))){
			
			if(!isset($parametro) || empty($parametro)){
				
				include_once('includes/404.php');	
			}else{
								
				if($pagina == 'secao'){
					
					$querySG = $conn->query("SELECT * FROM secao WHERE slug = '{$parametro}' LIMIT 1");
				}elseif($pagina == 'categoria'){
					
					$querySG = $conn->query("SELECT categoria.* 
					FROM categoria
					INNER JOIN subcategoria ON subcategoria.id_categoria = categoria.id
					INNER JOIN produto ON produto.id_subcategoria = subcategoria.id
					WHERE categoria.slug = '{$parametro}' 
					GROUP BY categoria.id
					LIMIT 1");
				}elseif($pagina == 'subcategoria'){
					
					$array_parametro = explode('__', $parametro);
					
					if(count($array_parametro) == 2){
						
						$parametro_categoria = $array_parametro[0];
						$parametro_subcategoria = $array_parametro[1];
						
						$querySS = $conn->query("SELECT subcategoria.* 
						FROM subcategoria 
						INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
						INNER JOIN produto ON produto.id_subcategoria = subcategoria.id
						WHERE categoria.slug = '{$parametro_categoria}' AND subcategoria.slug = '{$parametro_subcategoria}'
						GROUP BY subcategoria.id
						LIMIT 1");
						
						if($querySS->num_rows > 0){
							
							$resultSS = $querySS->fetch_array();
							$id_subcategoria_slug = $resultSS['id'];
						}else{
							
							$id_subcategoria_slug = 99999999999999;
						}
						
						$querySG = $conn->query("SELECT subcategoria.* 
						FROM subcategoria
						INNER JOIN categoria ON categoria.id = subcategoria.id_categoria
						INNER JOIN produto ON produto.id_subcategoria = subcategoria.id
						WHERE subcategoria.id = {$id_subcategoria_slug}
						GROUP BY subcategoria.id
						LIMIT 1");
					}	
				}else{
					
					$querySG = $conn->query("SELECT * FROM {$pagina} WHERE slug = '{$parametro}' LIMIT 1");
				}
				
				if(isset($querySG) && $querySG->num_rows > 0){
					
					$resultSG = $querySG->fetch_array();
					
					if($pagina == 'estilo'){
						
						$_GET['c'] = $resultSG['id'];
						include_once('includes/estilo.php');
					}else{
						
						$_GET[$pagina] = $resultSG['id'];
						include_once('includes/produtos.php');
					}
				}else{
					
					if($pagina == 'estilo'){
						
						$_GET['c'] = 99999999999999;
						include_once('includes/estilo.php');
					}else{
						
						$_GET[$pagina] = 99999999999999;
						include_once('includes/produtos.php');
					}
				}
			}
		}elseif($pagina == 'produto'){
			
			$querySG = $conn->query("SELECT * FROM {$pagina} LIMIT 1");
				
			if($querySG->num_rows > 0){
				
				$resultSG = $querySG->fetch_array();
				
				$_GET['c'] = $resultSG['id'];
				include_once('includes/produto.php');
			}
		}elseif(file_exists('includes/'.$pagina.'.php')){
			
			include_once('includes/'.$pagina.'.php');
		}else{
			
			include_once('includes/404.php');
		}
	}

	include_once("includes/rodape.php");
}


