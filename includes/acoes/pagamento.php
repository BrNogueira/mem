<?php
if($_POST['frete'] == 'pac'){
		
	$_SESSION['pagseguro']['entrega'] 	= '1';
	$_SESSION['tipo_entrega'] 			= 'PAC';
	$_SESSION['frete']	 				= $_SESSION['frete_pac'];
}elseif($_POST['frete'] == 'sedex'){
	
	$_SESSION['pagseguro']['entrega'] 	= '2';
	$_SESSION['tipo_entrega'] 			= 'SEDEX';
	$_SESSION['frete'] 					= $_SESSION['frete_sedex'];
}elseif($_POST['frete'] == 'transportadora'){
	
	$_SESSION['pagseguro']['entrega'] 	= '3';
	$_SESSION['tipo_entrega'] 			= 'ENTREGA EXPRESSA';
	$_SESSION['frete'] 					= $_SESSION['frete_transportadora'];
}elseif($_POST['frete'] == 'retirar'){
	
	$_SESSION['pagseguro']['entrega'] 	= '3';
	$_SESSION['tipo_entrega'] 			= 'RETIRAR NA LOJA';
	$_SESSION['frete'] 					= $_SESSION['frete_retirar'];
}

$_SESSION['endereco_entrega'] = $_POST['endereco_entrega'];

unset($_POST);

$_SESSION['carrinho_ok'] = TRUE;

header('Location:'.$urlC.'pagamento');

?>