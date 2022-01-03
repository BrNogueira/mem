
<?php

$modo = $_POST['modo'];

if(!isset($_SESSION['id_novo_pedido']) or empty($_SESSION['id_novo_pedido']) or $_SESSION['id_novo_pedido'] == 0){
	
	$id_cliente = $_SESSION['cliente_dados']['id'];

	$conn->query("INSERT INTO pedido (id_usuario) VALUES ($id_cliente)");
	$_SESSION['id_novo_pedido'] = $id_novo_pedido = $conn->insert_id;
}

$id_novo_pedido = $_SESSION['id_novo_pedido'];

$tipo_entrega 	= $_SESSION['tipo_entrega'];
$frete			= $_SESSION['frete'];
$total			= $_SESSION['valor_total'];

$_SESSION['valor_total_compra'] = $total;

$id_pedido = $_SESSION['id_novo_pedido'];
$parcelamento = 1;

if($_SESSION['endereco_entrega'] == 'endereco_atual' || isset($_SESSION['lista'])){

	$cep			= addslashes($_SESSION['cliente_dados']['cep']);
	$endereco		= addslashes($_SESSION['cliente_dados']['endereco']);
	$bairro			= addslashes($_SESSION['cliente_dados']['bairro']);
	$cidade			= addslashes($_SESSION['cliente_dados']['cidade']);
	$uf				= addslashes($_SESSION['cliente_dados']['uf']);
	$numero			= addslashes($_SESSION['cliente_dados']['numero']);
	$complemento	= addslashes($_SESSION['cliente_dados']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}elseif($_SESSION['endereco_entrega'] == 'endereco_novo'){
	
	$cep			= addslashes($_SESSION['novo_endereco']['cep']);
	$endereco		= addslashes($_SESSION['novo_endereco']['endereco']);
	$bairro			= addslashes($_SESSION['novo_endereco']['bairro']);
	$cidade			= addslashes($_SESSION['novo_endereco']['cidade']);
	$uf				= addslashes($_SESSION['novo_endereco']['uf']);
	$numero			= addslashes($_SESSION['novo_endereco']['numero']);
	$complemento	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}

if($_SESSION['endereco_entrega'] == 'endereco_novo' && $_SESSION['novo_endereco']['ativo'] == TRUE && $_SESSION['novo_endereco']['definicao'] == 'entrega_geral'){
	
	$_SESSION['cliente_dados']['cep']		= addslashes($_SESSION['novo_endereco']['cep']);
	$_SESSION['cliente_dados']['endereco']	= addslashes($_SESSION['novo_endereco']['endereco']);
	$_SESSION['cliente_dados']['bairro']	= addslashes($_SESSION['novo_endereco']['bairro']);
	$_SESSION['cliente_dados']['cidade']	= addslashes($_SESSION['novo_endereco']['cidade']);
	$_SESSION['cliente_dados']['uf']		= addslashes($_SESSION['novo_endereco']['uf']);
	$_SESSION['cliente_dados']['numero']	= addslashes($_SESSION['novo_endereco']['numero']);
	$_SESSION['cliente_dados']['complemento']	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$id_cliente = $_SESSION['cliente_dados']['id'];
	
	$update_endereco_entrega = $conn->query("UPDATE usuario SET cep = '$cep', endereco = '$endereco', bairro = '$bairro',
		cidade = '$cidade', uf = '$uf', numero = '$numero', complemento = '$complemento' WHERE id = $id_cliente");
}

$forma_cielo = TRUE;

include('includes/acoes/fecha_pedido.php');

$tipo_pagamento = ($modo == 'boleto')?('Boleto'):(($modo == 'deposito')?('Depósito'):(NULL));
$id_status_cielo = ($modo == 'boleto')?(221):(($modo == 'deposito')?(222):(0));

$conn->query("UPDATE pedido SET tipo_pagamento = '{$tipo_pagamento}', parcelamento = {$parcelamento}, id_status_cielo = {$id_status_cielo} WHERE id = {$id_pedido}");

$conn->query("UPDATE usuario SET sessao_carrinho = '' WHERE id = {$_SESSION['cliente_dados']['id']}");

$_SESSION['cliente_dados']['sessao_carrinho'] = '';

include('includes/acoes/unset.php');

if($modo == 'boleto'){
	
	$_SESSION['sucesso'] = 'PEDIDO FINALIZADO!<br/><small>Assim que confirmarmos o pagamento do boleto efetuaremos o envio do seu pedido!</small>';
}elseif($modo == 'deposito'){
	
	$_SESSION['sucesso'] = 'PEDIDO FINALIZADO!<br/><small>Assim que confirmarmos o seu depósito bancário efetuaremos o envio do seu pedido!</small>';
}

//header('Location: ' . $urlC);


?>