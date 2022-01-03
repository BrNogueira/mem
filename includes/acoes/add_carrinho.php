<?php
$produto_obj = new Produto();

$id_rel_produto_var = $_POST['id_rel_produto_var'];

$query_var = $conn->query("SELECT * FROM rel_produto_var WHERE id = $id_rel_produto_var LIMIT 1");

$result_var = $query_var->fetch_array();

$id_produto = $result_var['id_produto'];

$produto = $produto_obj->getProduto($id_produto);

$produto['quantidade'] 	= (!isset($_POST['quantidade']) || $_POST['quantidade'] == 0)?(1):($_POST['quantidade']);

$produto['id_cor'] 				= $result_var['id_cor'];
$produto['id_tamanho'] 			= $result_var['id_tamanho'];
$produto['id_modelo'] 			= $result_var['id_modelo'];
$produto['id_rel_produto_var'] 	= $result_var['id'];
$produto['valor_por'] 			= $result_var['valor'];
$produto['peso'] 				= $result_var['peso'];
$produto['largura']				= $result_var['largura'];
$produto['altura']				= $result_var['altura'];
$produto['profundidade']		= $result_var['profundidade'];

$produto['desconto'] = 0;

$produto['voltagem'] = (isset($_POST['voltagem']))?($_POST['voltagem']):(0);

if(count($_SESSION['carrinho_item']) == 0){
	
	$_SESSION['carrinho_item'][] = $produto;
		
	header('location:'.$urlC.'carrinho');
}else{
	
	$adicionado = FALSE;
	for($i = 0; $i <= count($_SESSION['carrinho_item']); $i++){
	
		$id_produto_session = $_SESSION['carrinho_item'][$i]['id_rel_produto_var'];
		
		if($id_rel_produto_var == $id_produto_session){
			
			$adicionado = TRUE;
		}
	}
	
	if($adicionado == FALSE){
		
		$_SESSION['carrinho_item'][] = $produto;
	}
	
	header('location:'.$urlC.'carrinho');
} ?>