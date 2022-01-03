<?php

$id_novo_pedido = $_SESSION['id_novo_pedido'];
$tipo_entrega 	= $_SESSION['tipo_entrega'];
$frete			= $_SESSION['frete'];
$total			= $_SESSION['total_carrinho'] + $frete;

if(isset($_SESSION['endereco_entrega']) && $_SESSION['endereco_entrega'] == 'endereco_atual'){
	
	$_SESSION['pagseguro']['cep'] 			= $cep			= addslashes($_SESSION['cliente_dados']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $endereco		= addslashes($_SESSION['cliente_dados']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $bairro		= addslashes($_SESSION['cliente_dados']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $cidade		= addslashes($_SESSION['cliente_dados']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $uf			= addslashes($_SESSION['cliente_dados']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $numero		= addslashes($_SESSION['cliente_dados']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $complemento	= addslashes($_SESSION['cliente_dados']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}elseif(isset($_SESSION['endereco_entrega']) && $_SESSION['endereco_entrega'] == 'endereco_novo'){
	
	$_SESSION['pagseguro']['cep'] 			= $cep			= addslashes($_SESSION['novo_endereco']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $endereco		= addslashes($_SESSION['novo_endereco']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $bairro		= addslashes($_SESSION['novo_endereco']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $cidade		= addslashes($_SESSION['novo_endereco']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $uf			= addslashes($_SESSION['novo_endereco']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $numero		= addslashes($_SESSION['novo_endereco']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $complemento	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$insert_pedido_entrega = $conn->query("INSERT INTO pedido_entrega
		(id_pedido, cep, endereco, bairro, cidade, uf, numero, complemento) VALUES
		($id_novo_pedido, '$cep', '$endereco', '$bairro', '$cidade', '$uf', '$numero', '$complemento')");	
}

if(isset($_SESSION['endereco_entrega']) && $_SESSION['endereco_entrega'] == 'endereco_novo' && $_SESSION['novo_endereco']['ativo'] == TRUE && $_SESSION['novo_endereco']['definicao'] == 'entrega_geral'){
	
	$_SESSION['pagseguro']['cep'] 			= $_SESSION['cliente_dados']['cep']			= addslashes($_SESSION['novo_endereco']['cep']);
	$_SESSION['pagseguro']['endereco'] 		= $_SESSION['cliente_dados']['endereco']	= addslashes($_SESSION['novo_endereco']['endereco']);
	$_SESSION['pagseguro']['bairro'] 		= $_SESSION['cliente_dados']['bairro']		= addslashes($_SESSION['novo_endereco']['bairro']);
	$_SESSION['pagseguro']['cidade'] 		= $_SESSION['cliente_dados']['cidade']		= addslashes($_SESSION['novo_endereco']['cidade']);
	$_SESSION['pagseguro']['uf'] 			= $_SESSION['cliente_dados']['uf']			= addslashes($_SESSION['novo_endereco']['uf']);
	$_SESSION['pagseguro']['numero'] 		= $_SESSION['cliente_dados']['numero']		= addslashes($_SESSION['novo_endereco']['numero']);
	$_SESSION['pagseguro']['complemento'] 	= $_SESSION['cliente_dados']['complemento']	= addslashes($_SESSION['novo_endereco']['complemento']);
	
	$id_cliente = $_SESSION['cliente_dados']['id'];
	
	$update_endereco_entrega = $conn->query("UPDATE usuario SET cep = '$cep', endereco = '$endereco', bairro = '$bairro',
		cidade = '$cidade', uf = '$uf', numero = '$numero', complemento = '$complemento' WHERE id = $id_cliente");
}

$_SESSION['cliente_pg'] = Util::trimPg($_SESSION['cliente_dados']);
$email_ps = ($config['pagseguro_ambiente'] == 'p')?(Util::trataEmailPg(addslashes($_SESSION['cliente_pg']['email']))):('doubleone@sandbox.pagseguro.com.br');

$dados['senderHash'] = $_POST['psHash'];
$dados['senderName'] = trim(addslashes(utf8_decode(Util::textoIntro($_SESSION['cliente_pg']['nome'].' '.$_SESSION['cliente_pg']['sobrenome'], 50))));
$dados['senderEmail'] = $email_ps;
$dados['senderCPF'] = Util::apenasNumeros($_SESSION['cliente_pg']['cpf']);
$dados['reference'] = $_SESSION['id_novo_pedido'];

if(!empty($_SESSION['cliente_pg']['telefone_contato'])){
	
	$telefone = Util::telefonePg($_SESSION['cliente_pg']['telefone_contato']);
	
	$dados['senderAreaCode'] = $telefone[0];
	$dados['senderPhone'] = $telefone[1];
}

if(isset($_SESSION['cupom_valido']) && $_SESSION['cupom_valido'] === TRUE){
				
	if($_SESSION['cupom']['tipo'] == 'p'){
		
		$desconto = $_SESSION['total_carrinho'] * ($_SESSION['cupom']['valor'] / 100);
	}elseif($_SESSION['cupom']['tipo'] == 'r' && $_SESSION['total_carrinho'] > $_SESSION['cupom']['valor']){
		
		$desconto = $_SESSION['cupom']['valor'];
	}
	
	$dados['extraAmount'] = str_replace(',','',number_format(-$desconto, 2));
}

$_SESSION['pagseguro']['frete'] = number_format($frete, 2);

$cont = 0;
$subtotal = 0;
for($i = 0; $i <= count($_SESSION['carrinho_item']); $i++){
		
	if(!empty($_SESSION['carrinho_item'][$i]['id'])){
		
		$cont++;
		
		$_SESSION['carrinho_item'][$i]['desconto'] = (isset($_SESSION['carrinho_item'][$i]['desconto']))?($_SESSION['carrinho_item'][$i]['desconto']):(0);
		
		$valor_por = $_SESSION['carrinho_item'][$i]['valor_por'] - number_format($_SESSION['carrinho_item'][$i]['valor_por'] * ($_SESSION['carrinho_item'][$i]['desconto'] / 100), 2);
		
		$dados['itemId'.$cont] = $_SESSION['carrinho_item'][$i]['id'];
		$dados['itemDescription'.$cont] = utf8_decode(substr($_SESSION['carrinho_item'][$i]['nome'], 0, 90));
		$dados['itemAmount'.$cont] = str_replace(',','',number_format($valor_por, 2));
		$dados['itemQuantity'.$cont] = $_SESSION['carrinho_item'][$i]['quantidade'];
		
		$subtotal += $dados['itemAmount'.$cont] * $dados['itemQuantity'.$cont] ;
	}
}

$dados['shippingType'] 				= $_SESSION['pagseguro']['entrega'];
$dados['shippingAddressStreet'] 	= utf8_decode(Util::textoIntro($_SESSION['pagseguro']['endereco'], 75));
$dados['shippingAddressNumber'] 	= $_SESSION['pagseguro']['numero'];
$dados['shippingAddressComplement'] = utf8_decode(Util::textoIntro($_SESSION['pagseguro']['complemento'], 35));
$dados['shippingAddressDistrict'] 	= utf8_decode($_SESSION['pagseguro']['bairro']);
$dados['shippingAddressPostalCode']	= preg_replace('#[^0-9]#','',strip_tags($_SESSION['pagseguro']['cep']));
$dados['shippingAddressCity'] 		= utf8_decode($_SESSION['pagseguro']['cidade']);
$dados['shippingAddressState'] 		= strtoupper($_SESSION['pagseguro']['uf']);
$dados['shippingAddressCountry'] 	= 'BRA';
$dados['shippingCost'] 				= number_format($_SESSION['pagseguro']['frete'], 2);

$retorno = PagSeguro::efetuaPagamentoBoleto($dados);
$urlBoleto = $retorno['paymentLink'];

$_POST['forma_pagamento'] = 'boleto';
?>

<?php if(!empty($urlBoleto)){ ?>

	<?php
	$id_novo_pedido = $_SESSION['id_novo_pedido'];
		
	$conn->query("UPDATE pedido SET boleto_link = '{$urlBoleto}', id_status = 1 WHERE id = {$id_novo_pedido}");
	?>
	
	<?php include('includes/acoes/fecha_pedido.php'); ?>

	<script>location.reload();</script>
<?php } ?>